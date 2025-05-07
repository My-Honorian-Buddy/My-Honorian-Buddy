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

class VideoCallController extends Controller
{
    /**
     * Create a Jitsi Meet Room.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRoom()
    {
        // Check if the authenticated user has booked sessions
        $bookedSession = bookedSession::where('student_id', Auth::id())
            ->orWhere('tutor_id', Auth::id())
            ->first();

        if (!$bookedSession) {
            return redirect()->back()->with('noSession', 'You must have a booked session to create a video call room.');
        }

        Log::info("check if session booked is null: " . $bookedSession->room);
        
        // Generate a unique room name based on the booked session
        if ($bookedSession->room !== null) {
            return redirect()
                ->route('video.call.room', ['roomName' => $bookedSession->room])
                ->with('success', 'You already have a video call room.');
        }
        
        // Generate a unique room name and update the booked session
        $roomName = $this->generateRoomName($bookedSession);

        if ($bookedSession) {
            $bookedSession->update(['room' => $roomName]);
        }
        // Pass the room name to the video call blade
        // return view('components.vc.videocall', compact('roomName'));

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



}
