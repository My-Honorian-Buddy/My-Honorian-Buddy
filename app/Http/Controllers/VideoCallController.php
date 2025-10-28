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
            $bookedSession->update(['room' => $roomName]);
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

    public function participantLeft()
    {
        $bookedSession = bookedSession::where('student_id', Auth::id())
            ->orWhere('tutor_id', Auth::id())
            ->first();
    
        if (!$bookedSession) {
            return response()->json(['error' => 'No active session found'], 404);
        }
        if ($bookedSession->num_session == $bookedSession->total_session) {

            return redirect()->route('workspace.start')->with('MeetEnded', 'You have left the video call room.' . ' ' . 'Cannot add any more session, total session already completed.' );
        }
    
        $updatedBefore = $bookedSession->sesUpdate 
            ? Carbon::parse($bookedSession->sesUpdate)->format('F d, Y') 
            : null;

        // Only send notifications if the session was not already updated today
        if ($updatedBefore != now()->format('F d, Y') || $updatedBefore == null) {
            $data = [
                'NotifType' => 'AddNumSession',
                'bookedSession' => $bookedSession->id,
                'num_session' => $bookedSession->num_session,
                'total_session' => $bookedSession->total_session,
            ];
        
            // Check if notification for student already exists
            $studentNotifExists = notifSession::where('notif_info', json_encode($data))
                ->where('to', $bookedSession->student_id)
                ->exists();
        
            // Check if notification for tutor already exists
            $tutorNotifExists = notifSession::where('notif_info', json_encode($data))
                ->where('to', $bookedSession->tutor_id)
                ->exists();
        
            // Create notifications if not already sent
            if (!$studentNotifExists) {
                notifSession::create([
                    'notif_info' => json_encode($data),
                    'to' => $bookedSession->student_id,
                    'user_id' => Auth::id(),
                    'read_at' => null,
                ]);
            }
        
            if (!$tutorNotifExists) {
                notifSession::create([
                    'notif_info' => json_encode($data),
                    'to' => $bookedSession->tutor_id,
                    'user_id' => Auth::id(),
                    'read_at' => null,
                ]);
            }
        }
        
    
        return redirect()->route('workspace.start')->with('MeetEnded', 'You have left the video call room.');
    }

    /**
     * Initiate a video call with notification
     */
    public function initiateCall(Request $request)
    {
        $receiverId = $request->input('receiver_id');
        $caller = Auth::user();

        
        $bookedSession = bookedSession::where(function($query) use ($receiverId) {
            $query->where('student_id', Auth::id())->where('tutor_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('tutor_id', Auth::id())->where('student_id', $receiverId);
        })->first();

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

        notifSession::create([
            'notif_info' => json_encode($notifData),
            'to' => $receiverId,
            'user_id' => $caller->id,
            'read_at' => null,
        ]);

        
        broadcast(new NewNotification($receiverId));

        return response()->json([
            'success' => true,
            'call_id' => $callId,
            'room_name' => $roomName,
            'receiver_name' => $receiver->name
        ]);
    }

    /**
     * Handle call response (accept/decline)
     */
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

            notifSession::create([
                'notif_info' => json_encode($declineNotifData),
                'to' => $callerId,
                'user_id' => $receiver->id,
                'read_at' => null,
            ]);

            
            broadcast(new NewNotification($callerId));
        }

        return response()->json(['success' => true, 'message' => 'Call declined']);
    }

}
