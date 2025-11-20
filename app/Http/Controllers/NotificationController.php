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
use Exception;



class NotificationController extends Controller 
{
    public function getUserNotifications()
    {
        $userId = Auth::id(); // Get the current user ID
        
        $notifications = NotifSession::where('to', $userId)
            ->orderBy('created_at', 'desc') // Optional: Order by latest notifications
            ->get();
        
        // Add recipient role to each notification
        $notifications = $notifications->map(function($notification) use ($userId) {
            $recipientRole = null;
            
            // Check if user has student account
            $student = Student::where('user_id', $userId)->first();
            // Check if user has tutor account
            $tutor = Tutor::where('user_id', $userId)->first();
            
            // Determine recipient role based on notification context
            $notifInfo = is_string($notification->notif_info) 
                ? json_decode($notification->notif_info, true) 
                : $notification->notif_info;
            
            // Strategy 1: Check if notification has explicit student_id or tutor_id matching current user
            if (isset($notifInfo['student_id']) && $notifInfo['student_id'] == $userId) {
                $recipientRole = 'Student';
            } elseif (isset($notifInfo['tutor_id']) && $notifInfo['tutor_id'] == $userId) {
                $recipientRole = 'Tutor';
            }
            
            // Strategy 2: Check booked session to determine recipient role
            if (!$recipientRole && isset($notifInfo['booked_session_id'])) {
                $bookedSession = bookedSession::find($notifInfo['booked_session_id']);
                if ($bookedSession) {
                    if ($bookedSession->student_id == $userId) {
                        $recipientRole = 'Student';
                    } elseif ($bookedSession->tutor_id == $userId) {
                        $recipientRole = 'Tutor';
                    }
                }
            }
            
            // Strategy 3: For notifications sent through 'to' field, determine role by checking who the notification is TO
            // If user is a tutor and receives notification, it's likely for their tutor role
            // If user is a student and receives notification, it's likely for their student role
            if (!$recipientRole) {
                // Check the notification type and requester role to infer recipient role
                if (isset($notifInfo['requester_role'])) {
                    // If student requests, notification goes to tutor
                    if ($notifInfo['requester_role'] === 'Student') {
                        $recipientRole = 'Tutor';
                    } 
                    // If tutor requests, notification goes to student
                    elseif ($notifInfo['requester_role'] === 'Tutor') {
                        $recipientRole = 'Student';
                    }
                }
            }
            
            // Strategy 4: Fallback to user's current active role
            if (!$recipientRole) {
                $user = User::find($userId);
                if ($user && $user->role) {
                    $recipientRole = $user->role;
                } else {
                    $recipientRole = 'Student'; // Default fallback
                }
            }
            
            $notification->recipient_role = $recipientRole;
            return $notification;
        });
   
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

            // Check if tutor has an ACTIVE (not deleted/archived) session
            $bookedSession = bookedSession::where('tutor_id', $Tutor->id)
                ->whereNull('deleted_at')
                ->first();
            if ($action === 'accept') {

                $notification = notifSession::findOrFail($id);
                if ($bookedSession) {

                    $notification->update(['read_at' => now()]);

                    return redirect($PreviousUrl)->with([
                        'cannotAccept' => 'You currently have an active tutoring session.',
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
                    'student_id' => $notifInfo['student_id'],
                    'tutor_id' => Auth::id(),
                    'tutoring_subject' => $notifInfo['subjects'],
                    'schedule_time' => $notifInfo['schedule_time'],
                    'num_session' => '0',
                    'total_session' => $notifInfo['total_session'],
                    'duration' => 0,
                    'room' => null,
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
                
                // Get the current logged-in tutor (who is rejecting) instead of from notif_info
                $currentTutor = Tutor::where('user_id', Auth::id())->first();
                $tutorName = $currentTutor ? ($currentTutor->fname . ' ' . $currentTutor->lname) : Auth::user()->name;

                $data = [
                    'NotifType' => 'Tutor Request Rejected',
                    'subjects' => $notifInfo['subjects'],
                    'tutor_name' => $tutorName,
                    'total_session' => $notifInfo['total_session']
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
                    'message' => 'The other party has already disagreed. Session not updated.',
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
                    $bookedSession->status = 'completed';
                    $bookedSession->save();
                }
                return response()->json([
                    'success' => true, 
                    'message' => 'The tutoring session has been successfully updated and marked as completed.',
                    'next_step' => 'Please click the "Complete" button on the current session to officially end the session.',
                ]);
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

        event(new NewNotification($recipientId, $notif));
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

    /**
     * Handle session completion confirmation from student.
     */
    public function sessionCompletionConfirm(Request $request, $notificationId)
    {
        Log::info('sessionCompletionConfirm called', [
            'notification_id' => $notificationId,
            'agree' => $request->agree,
            'user_id' => Auth::id()
        ]);

        $notification = notifSession::find($notificationId);

        if (!$notification) {
            Log::error('Notification not found', ['notification_id' => $notificationId]);
            return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
        }

        $notifInfo = json_decode($notification->notif_info, true);
        $bookedSession = bookedSession::find($notifInfo['bookedSession']);

        if (!$bookedSession) {
            Log::error('Session not found', ['session_id' => $notifInfo['bookedSession']]);
            return response()->json(['success' => false, 'message' => 'Session not found.'], 404);
        }

        // Only students can respond to completion requests
        if (Auth::id() !== $bookedSession->student_id) {
            Log::warning('Non-student tried to confirm completion', [
                'user_id' => Auth::id(),
                'student_id' => $bookedSession->student_id
            ]);
            return response()->json(['success' => false, 'message' => 'Only students can confirm completion.'], 403);
        }

        if ($request->agree) {
            try {
                // Mark session as completed and update status
                $bookedSession->is_completed = true;
                $bookedSession->status = 'completed';
                $bookedSession->save();

                Log::info('Session marked as completed and will be archived (soft deleted)', [
                    'session_id' => $bookedSession->id,
                    'is_completed' => $bookedSession->is_completed,
                    'status' => $bookedSession->status,
                    'student_id' => $bookedSession->student_id,
                    'tutor_id' => $bookedSession->tutor_id,
                ]);

                // Notify tutor of agreement
                $tutorNotif = notifSession::create([
                    'notif_info' => json_encode([
                        'NotifType' => 'CompleteSession',
                        'message' => 'The student has confirmed. Session completed successfully!',
                        'bookedSession' => $bookedSession->id,
                        'num_session' => $bookedSession->num_session,
                        'total_session' => $bookedSession->total_session,
                    ]),
                    'to' => $bookedSession->tutor_id,
                    'user_id' => Auth::id(),
                    'read_at' => null,
                ]);
                broadcast(new NewNotification($bookedSession->tutor_id, $tutorNotif));

                $bookedSession->delete();
                Log::info('Session archived (soft deleted) - visible to admin, both parties freed up', [
                    'archived_session_id' => $bookedSession->id,
                ]);

                // Delete the notification
                $notification->update(['read_at' => now()]);
                $notification->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Session completed successfully! Both you and your tutor can now book new sessions.',
                    'reload' => true
                ]);
            } catch (Exception $e) {
                Log::error('Failed to complete session', [
                    'error' => $e->getMessage(),
                    'session_id' => $bookedSession->id,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to complete the session.',
                ]);
            }
        } else {
            // Student disagreed
            $notification->update(['read_at' => now()]);
            $notification->delete();

            // Notify tutor about disagreement
            $deniedNotif = notifSession::create([
                'notif_info' => json_encode([
                    'NotifType' => 'SessionCompletionDenied',
                    'message' => 'The student has disagreed with the session completion.',
                    'bookedSession' => $bookedSession->id,
                ]),
                'to' => $bookedSession->tutor_id,
                'user_id' => Auth::id(),
                'read_at' => null,
            ]);
            broadcast(new NewNotification($bookedSession->tutor_id, $deniedNotif));

            Log::info('Student disagreed with completion', [
                'session_id' => $bookedSession->id,
                'student_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'You have disagreed with the completion.',
            ]);
        }
    }

    public function submitBanReport(Request $request)
    {
        try {
            $request->validate([
                'session_id' => 'required|exists:bookedsessions,id',
                'report_text' => 'required|string|max:1000',
                'images.*' => 'nullable|image|max:5120', // 5MB max per image
            ]);

            $sessionId = $request->input('session_id');
            $reportText = $request->input('report_text');
            
            // Find the booked session
            $bookedSession = bookedSession::findOrFail($sessionId);
            
            // Verify the user is the tutor
            if (Auth::id() !== $bookedSession->tutor_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: You are not the tutor of this session.',
                ], 403);
            }

            // Handle image uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('ban_reports', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Update the session with the report
            $bookedSession->update([
                'tutor_report' => $reportText,
                'tutor_report_images' => $imagePaths,
                'tutor_report_submitted_at' => now(),
                'ban_status' => 'report_submitted',
            ]);

            // Mark the ban request notification as read
            notifSession::where('to', Auth::id())
                ->where('notif_info->NotifType', 'BanRequest')
                ->where('notif_info->session_id', $sessionId)
                ->update(['read_at' => now()]);

            // Send notification to admin that report was submitted
            $adminNotif = notifSession::create([
                'notif_info' => json_encode([
                    'NotifType' => 'BanReportSubmitted',
                    'message' => 'Tutor has submitted a ban report.',
                    'session_id' => $sessionId,
                    'tutor_name' => Auth::user()->name,
                    'student_name' => $bookedSession->studentUser->name ?? 'Unknown',
                ]),
                'to' => 1, // Admin user ID
                'user_id' => Auth::id(),
                'read_at' => null,
            ]);

            // Broadcast to admin
            broadcast(new \App\Events\NewNotification(1, $adminNotif));

            Log::info('Ban report submitted', [
                'session_id' => $sessionId,
                'tutor_id' => Auth::id(),
                'images_count' => count($imagePaths),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully. Admin will review your response.',
            ]);
        } catch (Exception $e) {
            Log::error('Failed to submit ban report', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit report. Please try again.',
            ], 500);
        }
    }

}
