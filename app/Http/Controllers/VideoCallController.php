<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bookedSession;
use App\Models\notifSession;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\NewNotification;

class VideoCallController extends Controller
{
    /**
     * Create a Jitsi Meet Room.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRoom()
    {
        
        $bookedSession = bookedSession::where('student_id', Auth::id())
            ->orWhere('tutor_id', Auth::id())
            ->whereNull('deleted_at') // Exclude archived sessions
            ->first();

        if (!$bookedSession) {
            return redirect()->back()->with('noSession', 'You must have a booked session to create a video call room.');
        }

        Log::info("check if session booked is null: " . $bookedSession->room);
        
        
        if ($bookedSession->room !== null) {
            return redirect()
                ->route('video.call.room', ['roomName' => $bookedSession->room])
                ->with('success', 'You already have a video call room.');
        }
        
        
        $roomName = $this->generateRoomName($bookedSession);

        if ($bookedSession) {
            $bookedSession->update([
                'room' => $roomName
            ]);
            
            Log::info('🎬 New call room created', [
                'session_id' => $bookedSession->id,
                'room' => $roomName
            ]);
        }

        return redirect()->route('video.call.room', ['roomName' => $roomName]);
    }

    /**
     * Generate a unique room name based on booked session details.
     *
     * @param \App\Models\BookedSession $bookedSession
     * @return string
     */
    private function generateRoomName($bookedSession)
    {

        $tutorName = Tutor::where('user_id', $bookedSession->tutor_id)->first()->fname;
        $studentName = Student::where('user_id', $bookedSession->student_id)->first()->fname;
        

        $subject = 'tutoring_session';

        // Generate a unique string based on session details
        return "Room_{$tutorName}_{$studentName}_{$subject}_" . now()->timestamp;
    }

    public function handleJoinMeet()
    {
        $user = Auth::user();

        // Check if the user has booked sessions
        $bookedSession = bookedSession::
            where('student_id', $user->id)
            ->orWhere('tutor_id', $user->id)
            ->first();

        if (!$bookedSession) {

            return redirect()->back()
                ->with(
                    'noSession', 
                    'You must have a booked tutoring session to join a video call room.')
                    ;
        } 
        Log::info("Session Booked: ". $bookedSession);
        
        // Check if a room already exists
        $roomName = $bookedSession->room ?? null;

        if ($roomName) {
            // Room exists, redirect to the room
            Log::info("Room name: " . $roomName);
            return redirect()->route('video.call.room', ['roomName' => $roomName]);
        }
        //

        // No room exists, prompt to create a new one
        return redirect()->back()
            ->with(
                'NoRoom', 
                'No room created yet.'
            );
    }

    public function participantLeft(Request $request)
    {
        Log::info('🎥 Video call ended - Request received', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $bookedSession = bookedSession::where('student_id', Auth::id())
            ->orWhere('tutor_id', Auth::id())
            ->whereNull('deleted_at') // Exclude archived sessions
            ->first();
    
        if (!$bookedSession) {
            Log::error('❌ No active session found for user:', ['user_id' => Auth::id()]);
            return response()->json(['error' => 'No active session found'], 404);
        }

        $newDuration = $request->input('duration', 0);
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        Log::info('⏱️ Duration data received', [
            'session_id' => $bookedSession->id,
            'new_duration_minutes' => $newDuration,
            'current_duration_minutes' => $bookedSession->duration ?? 0,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'call_recorded' => $bookedSession->call_duration_recorded ?? false
        ]);

        // Check if this call's duration has already been recorded RECENTLY (within last 30 seconds)
        // This prevents double-recording when both participants leave at the same time
        // But allows new calls to record properly after 30+ seconds
        if ($bookedSession->call_duration_recorded === true && 
            $bookedSession->updated_at && 
            $bookedSession->updated_at->diffInSeconds(now()) < 30) {
            
            Log::info('⏱️ Duration already recorded for this call (within last 30 sec), skipping update', [
                'session_id' => $bookedSession->id,
                'user_id' => Auth::id(),
                'last_updated' => $bookedSession->updated_at->toDateTimeString(),
                'seconds_ago' => $bookedSession->updated_at->diffInSeconds(now())
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Duration already recorded by other participant',
                'duration' => $bookedSession->duration
            ]);
        }
        
        // Reset flag if it's been more than 30 seconds (new call session)
        if ($bookedSession->call_duration_recorded === true) {
            Log::info('🔄 Resetting duration flag for new call session', [
                'session_id' => $bookedSession->id,
                'last_updated' => $bookedSession->updated_at->toDateTimeString(),
                'seconds_ago' => $bookedSession->updated_at->diffInSeconds(now())
            ]);
            $bookedSession->call_duration_recorded = false;
        }

        $currentDuration = $bookedSession->duration ?? 0;
        $totalDuration = $currentDuration + $newDuration;
        $bookedSession->duration = $totalDuration;
        $bookedSession->call_duration_recorded = true; // Mark as recorded

        Log::info('⏱️ Updating session duration', [
            'session_id' => $bookedSession->id,
            'previous_duration' => $currentDuration,
            'added_duration' => $newDuration,
            'new_total_duration' => $totalDuration,
            'duration_in_hours' => round($totalDuration / 60, 2)
        ]);
        
        if ($bookedSession->num_session == $bookedSession->total_session) {
            $bookedSession->save();
            
            Log::info('✅ All sessions completed', [
                'session_id' => $bookedSession->id,
                'total_duration' => $totalDuration
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session duration updated. All sessions completed.',
                'duration' => $totalDuration,
                'redirect' => route('workspace.start')
            ]);
        }
    
        $updatedBefore = $bookedSession->sesUpdate 
            ? Carbon::parse($bookedSession->sesUpdate)->format('F d, Y') 
            : null;

        if ($updatedBefore != now()->format('F d, Y') || $updatedBefore == null) {
            $bookedSession->num_session += 1;
            $bookedSession->sesUpdate = now()->toDateString();
            $bookedSession->save();

            Log::info('✅ Session updated', [
                'session_id' => $bookedSession->id,
                'num_session' => $bookedSession->num_session,
                'total_session' => $bookedSession->total_session,
                'total_duration' => $totalDuration
            ]);

            $tutor = Tutor::where('user_id', $bookedSession->tutor_id)->first();
            if ($tutor) {
                $tutor->exp += 1;
                $earnedPoints = $bookedSession->num_session * 10;
                $tutor->points += $earnedPoints;
                $tutor->save();

                $pointsNotif = notifSession::create([
                    'notif_info' => json_encode([
                        'NotifType' => 'PointsUpdated',
                        'message' => 'You earned ' . $earnedPoints . ' points.',
                        'bookedSession' => $bookedSession->id,
                        'num_session' => $bookedSession->num_session,
                        'total_session' => $bookedSession->total_session,
                    ]),
                    'to' => $bookedSession->tutor_id,
                    'user_id' => Auth::id(),
                    'read_at' => null,
                ]);
                broadcast(new \App\Events\NewNotification($bookedSession->tutor_id, $pointsNotif));
            }

            $studentNotif = notifSession::create([
                'notif_info' => json_encode([
                    'NotifType' => 'SessionUpdated',
                    'message' => 'Your tutoring session has been updated and recorded.',
                    'bookedSession' => $bookedSession->id,
                    'num_session' => $bookedSession->num_session,
                    'total_session' => $bookedSession->total_session,
                ]),
                'to' => $bookedSession->student_id,
                'user_id' => Auth::id(),
                'read_at' => null,
            ]);
            broadcast(new \App\Events\NewNotification($bookedSession->student_id, $studentNotif));

            $tutorNotif = notifSession::create([
                'notif_info' => json_encode([
                    'NotifType' => 'SessionUpdated',
                    'message' => 'Your session count has been updated.',
                    'bookedSession' => $bookedSession->id,
                    'num_session' => $bookedSession->num_session,
                    'total_session' => $bookedSession->total_session,
                ]),
                'to' => $bookedSession->tutor_id,
                'user_id' => Auth::id(),
                'read_at' => null,
            ]);
            broadcast(new \App\Events\NewNotification($bookedSession->tutor_id, $tutorNotif));

            if ($bookedSession->num_session == $bookedSession->total_session) {
                return response()->json([
                    'success' => true,
                    'message' => 'Session updated! All sessions completed.',
                    'duration' => $totalDuration,
                    'redirect' => route('workspace.start')
                ]);
            }
        } else {
            $bookedSession->save();
            
            Log::info('⏱️ Duration updated without session count change', [
                'session_id' => $bookedSession->id,
                'reason' => 'Already updated today'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Session duration updated successfully.',
            'duration' => $totalDuration,
            'redirect' => route('workspace.start')
        ]);
    }

    public function initiateCall(Request $request)
    {
        $receiverId = $request->input('receiver_id');
        $caller = Auth::user();

        
        $bookedSession = bookedSession::where(function($query) use ($receiverId) {
            $query->where('student_id', Auth::id())->where('tutor_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('tutor_id', Auth::id())->where('student_id', $receiverId);
        })
        ->whereNull('deleted_at') // Exclude archived sessions
        ->first();

        if (!$bookedSession) {
            return response()->json(['success' => false, 'message' => 'No session found'], 404);
        }

        
        if (!$bookedSession->room) {
            $roomName = $this->generateRoomName($bookedSession);
            $bookedSession->update(['room' => $roomName]);
        } else {
            $roomName = $bookedSession->room;
        }

        
        $receiver = User::find($receiverId);
        $callId = uniqid('call_');
        $notifData = [
            'NotifType' => 'IncomingCall',
            'caller_id' => $caller->id,
            'caller_name' => $caller->name,
            'room_name' => $roomName,
            'call_id' => $callId,
        ];

        $callNotif = notifSession::create([
            'notif_info' => json_encode($notifData),
            'to' => $receiverId,
            'user_id' => $caller->id,
            'read_at' => null,
        ]);

        
        broadcast(new NewNotification($receiverId, $callNotif));

        return response()->json([
            'success' => true,
            'call_id' => $callId,
            'room_name' => $roomName,
            'receiver_name' => $receiver->name
        ]);
    }

    // For handling accept/decline calls
    public function respondToCall(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $action = $request->input('action');

        $notification = notifSession::find($notificationId);
        
        if (!$notification) {
            return response()->json(['success' => false], 404);
        }

        
        $notification->update(['read_at' => now()]);

        $notifInfo = json_decode($notification->notif_info, true);

        if ($action === 'accept') {
            $callerId = $notifInfo['caller_id'];
            $receiver = Auth::user();
            
            $acceptNotifData = [
                'NotifType' => 'CallAccepted',
                'accepter_id' => $receiver->id,
                'accepter_name' => $receiver->name,
                'call_id' => $notifInfo['call_id'],
                'room_name' => $notifInfo['room_name'],
            ];

            $acceptNotif = notifSession::create([
                'notif_info' => json_encode($acceptNotifData),
                'to' => $callerId,
                'user_id' => $receiver->id,
                'read_at' => null,
            ]);

            broadcast(new NewNotification($callerId, $acceptNotif));
            
            return response()->json([
                'success' => true,
                'redirect' => route('video.call.room', ['roomName' => $notifInfo['room_name']])
            ]);
        }

        
        if ($action === 'decline') {
            $callerId = $notifInfo['caller_id'];
            $receiver = Auth::user();
            
            $declineNotifData = [
                'NotifType' => 'CallDeclined',
                'decliner_id' => $receiver->id,
                'decliner_name' => $receiver->name,
                'call_id' => $notifInfo['call_id'],
            ];

            $declineNotif = notifSession::create([
                'notif_info' => json_encode($declineNotifData),
                'to' => $callerId,
                'user_id' => $receiver->id,
                'read_at' => null,
            ]);

            
            broadcast(new NewNotification($callerId, $declineNotif));
        }

        return response()->json(['success' => true, 'message' => 'Call declined']);
    }

    // For handling call cancellation
    public function cancelCall(Request $request)
    {
        $callId = $request->input('call_id');
        $receiverId = $request->input('receiver_id');
        $caller = Auth::user();

        // Find and mark the original call notification as read
        $originalNotif = notifSession::where('to', $receiverId)
            ->whereNull('read_at')
            ->whereRaw("JSON_EXTRACT(notif_info, '$.call_id') = ?", [$callId])
            ->first();

        if ($originalNotif) {
            $originalNotif->update(['read_at' => now()]);
        }

        // Send cancel notification to receiver
        $cancelNotifData = [
            'NotifType' => 'CallCancelled',
            'caller_id' => $caller->id,
            'caller_name' => $caller->name,
            'call_id' => $callId,
        ];

        notifSession::create([
            'notif_info' => json_encode($cancelNotifData),
            'to' => $receiverId,
            'user_id' => $caller->id,
            'read_at' => null,
        ]);

        // Broadcast to receiver
        broadcast(new NewNotification($receiverId));

        return response()->json(['success' => true, 'message' => 'Call cancelled']);
    }

}
