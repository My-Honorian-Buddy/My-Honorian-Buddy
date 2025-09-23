<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\NotifSession;
use App\Models\User;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\studentSubject;
use App\Models\tutorSubject;
use App\Models\bookedSession;
use App\Http\Controllers\Auth\SessionController;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Events\NewNotification;



class NotificationController extends Controller 
{
    public function getUserNotifications()
    {
        $userId = Auth::id(); // Get the current user ID
        
        $notifications = NotifSession::where('to', $userId)
            ->orderBy('created_at', 'desc') // Optional: Order by latest notifications
            ->get();
        
   
        $hasUnreadNotification = NotifSession::where('to', $userId)
            ->whereNull('read_at')
            ->exists();



        User::where('id', $userId)->update(['hasNotification' => $hasUnreadNotification]);
    

        return response()->json([
            'notifications' => $notifications,
            'hasUnreadNotification' => $hasUnreadNotification,
        ]);
    }

    public function handleTutorRequest(Request $request, $id) {
        $PreviousUrl = $request->input('previous_url', url()->previous());
        $validated = $request->validate([
            'action' => 'required|in:accept,reject',
        ]);
        
        try {
            // Get the action from the request
            $action = $request->input('action');
            Log::info('Action: '. $action);

            $Tutor = Auth::user();

            $bookedSession = bookedSession::where('tutor_id', $Tutor)->first();
            if ($action === 'accept') {

                $notification = notifSession::findOrFail($id);
                if ($bookedSession) {

                    $notification->update(['read_at' => now()]);

                    return redirect($PreviousUrl)->with([
                        'cannotAccept' => 'You currently have a tutoring session.',
                    ]);
                }
                
                // Retrieve the notification
                Log::info('Notification Session found: '. $notification);
                
                // Parse the notification info
                Log::info('Notification info: '. $notification->notif_info);
                $notifInfo = json_decode($notification->notif_info, true);

                $alltutor = Tutor::all();

                Log::info('All tutors: '. $alltutor);
                
                // Extract the required data from the notification
                $data = [
                    'student_id' => $notifInfo['student_id'], // Assuming the student is the logged-in user
                    'tutor_id' => Auth::id(), // Tutor ID from the notification
                    'tutoring_subject' => $notifInfo['subjects'],     // Replace with actual logic
                    'schedule_time' => $notifInfo['Schedule Time'],
                    'num_session' => '0',
                    'total_session' => $notifInfo['Total Session'], // Adjust as needed
                    'duration' => null,
                    'room' => null, // Default or from additional fields
                ];
                Log::info('Data: ', $data);
                // Validate the data
                
                $validator = Validator::make($data, [
                    'student_id' => 'required|exists:students,user_id',
                    'tutor_id' => 'required|exists:tutors,user_id',
                    'tutoring_subject' => 'required|array|min:1',
                    'schedule_time' => 'required|date',
                    'total_session' => 'required|integer|min:1',
                    'room' => 'nullable|string',
                ]);

                Log::info('Validator: '. $validator->errors());
                // If validation fails, return an error
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                    ], 422);
                }
    
                Log::info('Data: ', $data);
    
                // Pass the validated data to the SessionController for session creation
                $sessionController = new SessionController();
                try {
                    $response = $sessionController->store(new Request($data));
                } catch (\Exception $e) {
                    Log::error('Session creation failed: ' . $e->getMessage());
                    return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
                }
    
                Log::info('Session created: '. $response);
                
                // Mark the notification as read
                $notification->update(['read_at' => now()]);
                $notification->delete();


                return redirect($PreviousUrl)->with([
                    'success' => 'Tutor request accepted successfully!',
                ]);
            }else{


                $notification = notifSession::findOrFail($id);
                     
                // Parse the notification info
        
                $notifInfo = json_decode($notification->notif_info, true);

                $alltutor = Tutor::all();
                
                $tutor = Tutor::where('user_id', $notifInfo['tutor_id'])->first();

                $data = [
                    'NotifType' => 'Tutor Request Rejected',
                    'subjects' => $notifInfo['subjects'],
                    'tutor_name' => $tutor->fname .' '. $tutor->lname,
                    'total_session' => $notifInfo['Total Session']
                ];
                notifSession::create([
                    'notif_info' => json_encode($data),
                    'to' => $notifInfo['student_id'],
                    'user_id' => Auth::id(),
                    'read_at' => null,
                ]);

                $notification->update(['read_at' => now()]);
                $notification->delete();

                return redirect($PreviousUrl)->with([
                    'success' => 'Tutor request rejected successfully!',
                ]);

                
                
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    

    public function markAsRead(Request $request, $id)
    {
        
        $notification = NotifSession::find($id);

        if ($notification) {
            $notification->read_at = now();
            $notification->save();

            return response()->json(['success' => true, 'message' => 'Notification marked as read', 200]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found', 404]);
    }

    public function deleteNotification(Request $request, $id)
    {
        $notification = NotifSession::find($id);

        if ($notification) {
            $notification->delete();

            return response()->json(['success' => true, 'message' => 'Notification deleted', 200]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found', 404]);
    }

    public function markAllAsRead(Request $request)
    {
        $userId = Auth::id(); // Get the current user ID
        
        NotifSession::where('to', $userId)->update(['read_at' => now()]); // Mark all notifications as read for the current user
        
        return response()->json(['success' => true, 'message' => 'All notifications marked as read', 200]);
    }

    public function deleteAllNotifications(Request $request)
    {
        $userId = Auth::id(); // Get the current user ID
        
        NotifSession::where('to', $userId)->delete(); //delete all notifications for the curent user
        
        return response()->json(['success' => true, 'message' => 'All notifications deleted', 200]);
    }

    public function hasUnreadNotifications(Request $request){
        $userId = $request->user()->id; // Assuming the user is authenticated
        $hasUnreadNotification = NotifSession::where('user_id', $userId)
                                              ->whereNull('read_at')
                                              ->exists();
        return response()->json(['hasUnreadNotification' => $hasUnreadNotification]);
    }

    /**
     * Handle session confirmation
     */
    public function sessionConfirm(Request $request, $notificationId)
    {   

        $notification = notifSession::find($notificationId);

        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        }
    
        $notifInfo = json_decode($notification->notif_info, true);
        $bookedSession = bookedSession::find($notifInfo['bookedSession']);
    
        if (!$bookedSession) {
            return response()->json(['success' => false, 'message' => 'Session not found.'], 404);
        }
    
        $otherPartyId = $this->getOtherParty($bookedSession);
        $disagreementNotifications = notifSession::where('to', Auth::id())
            ->where('user_id', $otherPartyId)
            ->get()
            ->filter(function ($notif) use ($bookedSession) {
                $notifInfo = json_decode($notif->notif_info, true);
                return $notifInfo['NotifType'] === 'SessionDisagreed' &&
                    $notifInfo['bookedSession'] === $bookedSession->id;
            });

        Log::info('IS THE NOTIF EXISTING?'. $disagreementNotifications);

        if ($bookedSession->is_completed) {
            return response()->json([
                'success' => false,
                'message' => 'Session already completed. Session not updated.',
            ]);
        }

        if ($request->agree) {
            // Check if any disagreement notifications exist
            if ($disagreementNotifications->isNotEmpty()) {
                $bookedSession->accept = 0; // Reset session
                $bookedSession->save();

                // Mark and delete the current notification
                $notification->update(['read_at' => now()]);
                $notification->delete();

                // Delete all matching disagreement notifications
                $disagreementNotifications->each(function ($notif) {
                    $notif->delete();
                });


                // Send a new notification to the current user
                notifSession::create([
                    'notif_info' => json_encode([
                        'NotifType' => 'SessionDidNotUpdate',
                        'message' => 'The session was not updated,',
                        'bookedSession' => $bookedSession->id,
                    ]),
                    'to' => Auth::id(),
                    'user_id' => $otherPartyId,
                    'read_at' => null,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'The other party has already disagreed. 
                                Session not updated.',
                ]);
            }
    
            // Increment the accept count
            $bookedSession->accept += 1;
            $bookedSession->save();
    
            // Check if both parties agreed
            if ($bookedSession->accept === 2) {

                $tutor = Tutor::where('user_id', $bookedSession->tutor_id)->first();

                // Increment the num_session
                $bookedSession->num_session += 1;
                $bookedSession->sesUpdate = now()->toDateString();
                $bookedSession->accept = 0; // Reset accept counter
                $bookedSession->save();


                
                // Increment the exp and points
                if ($tutor) {
                    $tutor->exp += 1;
                    $earnedPoints = $bookedSession->num_session * 10;
                    $tutor->points += $earnedPoints;
                    $tutor->save();
                }
    

                // Notify both tutor and student
                $this->sendNotification($bookedSession, 'SessionUpdated', 'Your session count has been updated.', $bookedSession->student_id);
                $this->sendNotification($bookedSession, 'SessionUpdated', 'Your session count has been updated.', $bookedSession->tutor_id);
                $this->sendNotification($bookedSession, 'PointsUpdated', 'You earned ' . $earnedPoints . ' points.', $bookedSession->tutor_id);
                
            }
    
            $notification->update(['read_at' => now()]);
            $notification->delete();
            $numberOfSession = $bookedSession->num_session;
            $totalSession = $bookedSession->total_session;

            if ($numberOfSession == $totalSession) {
                $response = Http::post(route('complete.session'), [
                    'session_id' => $bookedSession->id,
                ]);

                if ($response->successful()) {
                    $bookedSession->is_completed = true;
                }
                return response()->json(['success' => true, 
                'message' => 'The tutoring session has been successfully updated and marked as completed.',
                'next_step' => 'Please click the "Complete" button on the current session to process payment and officially end the session.',]);
            }
            
            return response()->json(['success' => true, 'message' => 'Agreement recorded.']);
        } else {
            // Disagreement logic
            $bookedSession->accept = 0; // Reset the accept counter
            $bookedSession->save();
    
            $this->sendNotification(
                $bookedSession,
                'SessionDisagreed', // Be consistent
                'The other party has disagreed to add this session.',
                $otherPartyId
            );
    
            $notification->update(['read_at' => now()]);
            $notification->delete();
    
            return response()->json(['success' => true, 'message' => 'You have disagreed.']);
        }
    }
    
    /**
     * Helper function to send notifications.
     */
    protected function sendNotification($bookedSession, $type, $message, $recipientId)
    {
        $notif = notifSession::create([
            'notif_info' => json_encode([
                'NotifType' => $type,
                'message' => $message,
                'bookedSession' => $bookedSession->id,
                'num_session' => $bookedSession->num_session,
                'total_session' => $bookedSession->total_session,
            ]),
            'to' => $recipientId,
            'user_id' => Auth::id(),
            'read_at' => null,
        ]);

        event(new NewNotification($notif, $recipientId));
    }   
    
    /**
     * Get the other party's user ID.
     */
    protected function getOtherParty($bookedSession)
    {
        return Auth::id() === $bookedSession->student_id
            ? $bookedSession->tutor_id
            : $bookedSession->student_id;
    }


}
