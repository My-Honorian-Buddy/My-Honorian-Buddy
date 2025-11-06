<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\bookedSession;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\tutorSubject;
use App\Models\notifSession;
use App\Models\Event;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;
use App\Models\bookingHistoryLogs;
use App\Events\NewNotification;
use Carbon\Carbon;
use App\Models\Schedule;
use Exception;

class SessionController extends Controller
{
    public function showAppointmentPage($tutorId)
    {
        $tutor = Tutor::findOrFail($tutorId);
        $tutorUser = $tutor->user;
        $tutorSubjects = $tutor->subject_tutor ?? [];
        
        return view('appointment', [
            'tutorId' => $tutorId,
            'tutor' => $tutor,
            'tutorUser' => $tutorUser,
            'tutorSubjects' => $tutorSubjects
        ]);
    }

    protected function createCalendarEventsForBookedSession($bookedSession, $student, $tutor)
    {

        $initialScheduleTime = Carbon::parse($bookedSession->schedule_time);
        $dayOfWeek = $initialScheduleTime->dayOfWeek;
        $totalSessions = $bookedSession->total_session;
        
        
        $subjects = json_decode($bookedSession->tutoring_subject, true);
        $subjectNames = is_array($subjects) ? implode(', ', $subjects) : $subjects;
        
        
        $tutorName = $tutor->fname . ' ' . $tutor->lname;
        
        
        $usersToNotify = [
            ['id' => $bookedSession->student_id, 'name' => $student->fname],
            ['id' => $bookedSession->tutor_id, 'name' => $tutor->fname]
        ];
        
        foreach ($usersToNotify as $user) {
            
            $currentDate = $initialScheduleTime->copy();
            
            for ($sessionNum = 1; $sessionNum <= $totalSessions; $sessionNum++) {
                
                if ($sessionNum > 1) {
                    $currentDate = $currentDate->copy()->addWeek();
                }
                
                $eventStart = $currentDate->copy();
                $eventEnd = $currentDate->copy()->addHour();
                
                $title = "Session {$sessionNum}/{$totalSessions} - {$subjectNames} with {$tutorName}";
                
                $description = "Tutoring Session {$sessionNum} of {$totalSessions}\n";
                $description .= "Subject: {$subjectNames}\n";
                $description .= "Tutor: {$tutorName}\n";
                $description .= "Date: " . $eventStart->format('l, F j, Y') . "\n";
                $description .= "Time: " . $eventStart->format('g:i A');
                
                Event::create([
                    'user_id' => $user['id'],
                    'title' => $title,
                    'start' => $eventStart,
                    'end' => $eventEnd,
                    'booked_session_id' => $bookedSession->id,
                    'description' => $description,
                    'event_type' => 'booked_session',
                    'session_number' => $sessionNum
                ]);
                
                Log::info("Created calendar event for session {$sessionNum} on {$eventStart} for user {$user['id']}");
            }
        }
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'tutor_id' => 'required|exists:tutors,user_id',
            'tutoring_subject' => 'required|array|min:1',
            'schedule_time' => 'required|date',
            'num_session' => 'nullable|integer',
            'total_session' => 'required|integer',
            'duration' => 'nullable|integer',
            'room' => 'nullable|string',
        ]);

        $validated['num_session'] = $validated['num_session'] ?? 0; // Default to 0
        $validated['duration'] = $validated['duration'] ?? 0; // Default to

        $subjects = $validated['tutoring_subject'];
        $validated['tutoring_subject'] = json_encode($validated['tutoring_subject']);

        $student = Student::where('user_id', $validated['student_id'])->first();
        $tutor = Tutor::where('user_id', $validated['tutor_id'])->first();

        Log::info("VALIDATED DATA: ", $validated);
        $session = bookedSession::create($validated);


        if ($session) {

            $this->createCalendarEventsForBookedSession($session, $student, $tutor);
            
            $appointmentDateTime = Carbon::parse($validated['schedule_time']);
            
            $notifInfo = [
                'NotifType' => 'Tutor Request Accepted',
                'subjects' => $subjects,
                'tutor_name' => $tutor->fname . ' ' . $tutor->lname,
                'schedule_time' => $validated['schedule_time'],
                'appointment_day' => $appointmentDateTime->format('l'),
                'appointment_date' => $appointmentDateTime->format('F j, Y'),
                'appointment_time' => $appointmentDateTime->format('g:i A'),
                'total_session' => $validated['total_session'],
            ];
            $notification = notifSession::create([
                'notif_info' => json_encode($notifInfo),
                'to' => $validated['student_id'],
                'user_id' => $validated['tutor_id'],
                'read_at' => null,
            ]);

            // Broadcast to student's private channel
            broadcast(new \App\Events\NewNotification($validated['student_id'], $notification));

            $message = Chatify::newMessage([
                'from_id' => $validated['tutor_id'],
                'to_id' => $validated['student_id'],
                'body' => 'Tutoring session has been accepted.',
                'attachment' => null,
            ]);

            // Notify both users of the new conversation
            Chatify::push("private-chatify." . $validated['student_id'], 'messaging', [
                'from_id' => $validated['tutor_id'],
                'to_id' => $validated['student_id'],
                'message' => Chatify::messageCard(Chatify::parseMessage($message), true)
            ]);
            session()->flash('success', 'Session created successfully!');
        }

        return redirect()->back()->with([
            'success' => 'Tutor request accepted successfully!',
        ]);
    }


    public function notifStore(Request $request)
    {
        Log::info('All Data for Notif Tutor Request: ', $request->all());

        $userID = Auth::user()->id;
        $user = User::find($userID);
        $student = $user->student;
        $studentName = $student->fname . ' ' . $student->lname;


        $validated = $request->validate([
            'NotifType' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'total_session' => 'required|integer|min:1',
            'tutor_id' => 'required',
            'subjects' => 'required|array|min:1',
            'unique_message' => 'nullable|string',
        ]);
        Log::info("VALIDATED DATA: ", $validated);
        $scheduleTime = "{$validated['date']} {$validated['time']}";

        // get the date and time to show inside the notif
        $appointmentDate = Carbon::parse($validated['date']);
        $appointmentTime = Carbon::parse($validated['time']);

        $notifInfo = [
            'NotifType' => $validated['NotifType'],
            'schedule_time' => $scheduleTime,
            'appointment_day' => $appointmentDate->format('l'),
            'appointment_date' => $appointmentDate->format('F j, Y'),
            'appointment_time' => $appointmentTime->format('g:i A'),
            'total_session' => $validated['total_session'],
            'subjects' => $validated['subjects'],
            'unique_message' => $validated['unique_message'] ?? '',
            'studentName' => $studentName,
            'tutor_id' => $validated['tutor_id'],
            'student_id' => $userID,
        ];

        Log::info('Data: ', $notifInfo);

        // Get the tutor user ID to send the broadcast
        $tutor = Tutor::find($validated['tutor_id']);
        if (!$tutor) {
            Log::error('Tutor not found:', ['tutor_id' => $validated['tutor_id']]);
            return redirect()->back()->with('error', 'Tutor not found');
        }

        // Store notification with tutor's user_id (not tutor_id)
        $notification = notifSession::create([
            'notif_info' => json_encode($notifInfo),
            'to' => $tutor->user_id,  // Store the tutor's USER ID, not tutor ID
            'user_id' => $userID,
            'read_at' => null,
        ]);

        Log::info('Notif created successfully', [
            'notif_info' => $notifInfo,
            'notification_id' => $notification->id,
            'tutor_user_id' => $tutor->user_id,
        ]);

        // Broadcast to the tutor with the full notification object
        Log::info('Broadcasting to tutor user ID:', ['user_id' => $tutor->user_id]);
        broadcast(new NewNotification($tutor->user_id, $notification));

        return redirect()->route('workspace.start')->with([
            'success' => 'Tutor request sent successfully!',
            'notification_id' => $notification->id,

        ]);
    }

    public function SessionComplete(Request $request)
    {
        Log::info('========== SESSION COMPLETE CALLED ==========');
        Log::info('Request data:', $request->all());
        
        $sessionId = $request->input('session_id');
        Log::info('Session ID from request:', ['session_id' => $sessionId]);
        
        if (!$sessionId) {
            Log::error('No session_id provided in request');
            return redirect()->back()->with([
                'error' => 'Session ID is missing.',
            ]);
        }
        
        $bookedSession = bookedSession::find($sessionId);
        
        if (!$bookedSession) {
            Log::error('Session not found:', ['session_id' => $sessionId]);
            return redirect()->back()->with([
                'error' => 'Session not found.',
            ]);
        }
        
        Log::info('Booked session found:', [
            'id' => $bookedSession->id,
            'num_session' => $bookedSession->num_session,
            'total_session' => $bookedSession->total_session,
            'is_completed' => $bookedSession->is_completed,
        ]);

        if ($bookedSession->num_session == 0 && !$bookedSession->is_completed) {
            Log::warning('Cannot complete - no sessions made', [
                'session_id' => $bookedSession->id,
                'num_session' => $bookedSession->num_session,
                'total_session' => $bookedSession->total_session
            ]);
            return redirect()->route('workspace.start')->with([
                'cannotComplete' => ' Cannot complete session: No meetings have been conducted yet.'
            ]);
        }

        // Check if session is completed or the number of sessions reached the total session
        if ($bookedSession->is_completed || $bookedSession->num_session == $bookedSession->total_session) {

            // Only tutors can initiate completion
            if (Auth::user()->role !== 'Tutor') {
                Log::warning('Non-tutor tried to complete session', [
                    'user_id' => Auth::id(),
                    'role' => Auth::user()->role
                ]);
                return redirect()->route('workspace.start')->with([
                    'error' => 'Only tutors can complete sessions.',
                ]);
            }

            // Check if admin has approved completion
            if (!$bookedSession->admin_approved) {
                Log::warning('Cannot complete - admin approval required', [
                    'session_id' => $bookedSession->id,
                    'admin_approved' => $bookedSession->admin_approved
                ]);
                return redirect()->route('workspace.start')->with([
                    'error' => 'Admin approval is required before completing this session. Please wait for admin to review and approve.'
                ]);
            }

            try {
                // Send completion confirmation request to student
                $completionNotif = notifSession::create([
                    'notif_info' => json_encode([
                        'NotifType' => 'SessionCompletionRequest',
                        'message' => 'Your tutor has marked this session as complete. Do you agree?',
                        'bookedSession' => $bookedSession->id,
                        'num_session' => $bookedSession->num_session,
                        'total_session' => $bookedSession->total_session,
                    ]),
                    'to' => $bookedSession->student_id,
                    'user_id' => $bookedSession->tutor_id,
                    'read_at' => null,
                ]);

                // Broadcast to student
                broadcast(new \App\Events\NewNotification($bookedSession->student_id, $completionNotif));

                Log::info('Completion request sent to student', [
                    'session_id' => $bookedSession->id,
                    'student_id' => $bookedSession->student_id,
                    'notification_id' => $completionNotif->id
                ]);

                return redirect()->route('workspace.start')->with([
                    'success' => 'Completion request sent to student. Waiting for confirmation.',
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'Failed to complete the session.',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }

        return redirect()->route('workspace.start')->with([
            'success' => 'Session marked as completed successfully.',
        ]);
    }

    public function getMatchingSchedules(Request $request)
    {
        $tutorId = $request->get('tutor_id');
        $studentId = Auth::id();

        if (!$tutorId || !$studentId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing tutor or student information'
            ]);
        }

        // Get the tutor's user_id from the Tutor model
        $tutor = Tutor::find($tutorId);
        if (!$tutor) {
            return response()->json([
                'success' => false,
                'message' => 'Tutor not found'
            ]);
        }

        // Get student and tutor schedules using user_id
        $studentSchedule = Schedule::where('user_id', $studentId)->first();
        $tutorSchedule = Schedule::where('user_id', $tutor->user_id)->first();

        if (!$studentSchedule || !$tutorSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'One or both users have not set up their schedules yet',
                'student_has_schedule' => !!$studentSchedule,
                'tutor_has_schedule' => !!$tutorSchedule
            ]);
        }

        // match the days bet student and tutor
        $studentDays = $studentSchedule->days_week ?? [];
        $tutorDays = $tutorSchedule->days_week ?? [];
        
        Log::info('Student days: ' . implode(', ', $studentDays));
        Log::info('Tutor days: ' . implode(', ', $tutorDays));
        
        $matchingDays = array_intersect($studentDays, $tutorDays);
        $matchingDays = array_values($matchingDays);
        
        Log::info('Matching days found: ' . implode(', ', $matchingDays));
        Log::info('Number of matching days: ' . count($matchingDays));

        if (empty($matchingDays)) {
            Log::info('No matching days found - Student: [' . implode(', ', $studentDays) . '] vs Tutor: [' . implode(', ', $tutorDays) . ']');
            return response()->json([
                'success' => false,
                'message' => 'No matching schedule days found - kahit isang araw lang walang match',
                'student_days' => $studentDays,
                'tutor_days' => $tutorDays
            ]);
        }
        
        Log::info('SUCCESS: Found ' . count($matchingDays) . ' matching day(s): ' . implode(', ', $matchingDays));

        // arrayed the days to manipulate the dates
        $availableDates = [];
        $dayMap = [
            'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4,
            'Friday' => 5, 'Saturday' => 6, 'Sunday' => 0
        ];

        $today = now();
        for ($week = 0; $week < 4; $week++) {
            foreach ($matchingDays as $day) {
                if (isset($dayMap[$day])) {
                    $date = $today->copy()->addWeeks($week)->startOfWeek()->addDays($dayMap[$day] - 1);
                    
                    
                    if ($date->isFuture() || $date->isToday()) {
                        $availableDates[] = [
                            'date' => $date->format('Y-m-d'),
                            'formatted_date' => $date->format('M j, Y'),
                            'day_name' => $day,
                            'full_date' => $date->format('l, F j, Y')
                        ];
                    }
                }
            }
        }

        usort($availableDates, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // get the overlapping time
        try {
            $studentStartTime = Carbon::parse($studentSchedule->start_time);
            $studentEndTime = Carbon::parse($studentSchedule->end_time);
            $tutorStartTime = Carbon::parse($tutorSchedule->start_time);
            $tutorEndTime = Carbon::parse($tutorSchedule->end_time);

            Log::info('Schedule Times - Student: ' . $studentStartTime->format('g:i A') . ' - ' . $studentEndTime->format('g:i A'));
            Log::info('Schedule Times - Tutor: ' . $tutorStartTime->format('g:i A') . ' - ' . $tutorEndTime->format('g:i A'));

            $overlapStart = $studentStartTime->gt($tutorStartTime) ? $studentStartTime : $tutorStartTime; // max st
            $overlapEnd = $studentEndTime->lt($tutorEndTime) ? $studentEndTime : $tutorEndTime; // min et

            $overlappingTime = null;
            if ($overlapStart->lt($overlapEnd)) {
                
                $overlappingTime = $overlapStart->format('g:i A') . ' - ' . $overlapEnd->format('g:i A');
                Log::info('Calculated overlap: ' . $overlappingTime);
            } else {
                Log::info('No overlap - Start: ' . $overlapStart->format('g:i A') . ' End: ' . $overlapEnd->format('g:i A'));
                
                return response()->json([
                    'success' => false,
                    'message' => 'No overlapping time found between your schedules',
                    'student_time' => $studentSchedule->start_time . ' - ' . $studentSchedule->end_time,
                    'tutor_time' => $tutorSchedule->start_time . ' - ' . $tutorSchedule->end_time,
                    'student_days' => $studentDays,
                    'tutor_days' => $tutorDays
                ]);
            }

        } catch (Exception $e) {
            Log::error('Error calculating overlapping time: ' . $e->getMessage());
            $overlappingTime = 'Time calculation error';
        }

        return response()->json([
            'success' => true,
            'matching_days' => $matchingDays,
            'available_dates' => $availableDates,
            'overlapping_time' => $overlappingTime,
            'student_schedule' => [
                'days' => $studentDays,
                'time' => $studentSchedule->start_time . ' - ' . $studentSchedule->end_time
            ],
            'tutor_schedule' => [
                'days' => $tutorDays,
                'time' => $tutorSchedule->start_time . ' - ' . $tutorSchedule->end_time
            ]
        ]);
    }

    public function dropSession(Request $request)
    {
        Log::info('========== DROP SESSION CALLED ==========');
        Log::info('Request data:', $request->all());
        Log::info('User role:', ['role' => Auth::user()->role]);
        
        $accept = $request->input('accept') ?? 'none';
        $sessionId = $request->input('session_id');
        
        Log::info('Drop session params:', [
            'accept' => $accept,
            'session_id' => $sessionId
        ]);
        
        if (!$sessionId) {
            Log::error('No session_id provided for drop');
            return redirect()->back()->with([
                'error' => 'Session ID is missing.',
            ]);
        }
        
        $bookedSession = bookedSession::find($sessionId);
        
        if (!$bookedSession) {
            Log::error('Session not found for drop:', ['session_id' => $sessionId]);
            return redirect()->back()->with([
                'error' => 'Session not found.',
            ]);
        }
        
        Log::info('Booked session found for drop:', [
            'id' => $bookedSession->id,
            'student_id' => $bookedSession->student_id,
            'tutor_id' => $bookedSession->tutor_id
        ]);
        
        $user = Auth::user();
        $userName = $user->student ? $user->student->fname . ' ' . $user->student->lname : $user->tutor->fname . ' ' . $user->tutor->lname;

        // Handle drop request response (accept/deny)
        if ($accept != 'none') {
            $notificationId = $request->input('notification_id');

            if ($request->input('accept') == 'true') {
                // Accepted - Drop the session immediately
                Log::info('Drop request accepted, deleting session');
                
                // Send notification to both parties that session is dropped
                $dataDrop = [
                    'NotifType' => 'SessionDropped',
                    'booked_session_id' => $sessionId,
                    'message' => 'The tutoring session has been dropped.',
                    'dropped_by' => $userName,
                ];

                // Notify the requester
                $requesterNotif = notifSession::create([
                    'notif_info' => json_encode($dataDrop),
                    'to' => $user->role === 'Student' ? $bookedSession->student_id : $bookedSession->tutor_id,
                    'user_id' => Auth::user()->id,
                    'read_at' => null,
                ]);
                
                // Notify the other party
                $otherPartyId = $user->role === 'Student' ? $bookedSession->tutor_id : $bookedSession->student_id;
                $otherPartyNotif = notifSession::create([
                    'notif_info' => json_encode($dataDrop),
                    'to' => $otherPartyId,
                    'user_id' => Auth::user()->id,
                    'read_at' => null,
                ]);
                
                // Broadcast to both parties in real-time
                broadcast(new NewNotification($user->role === 'Student' ? $bookedSession->student_id : $bookedSession->tutor_id, $requesterNotif));
                broadcast(new NewNotification($otherPartyId, $otherPartyNotif));

                // Delete the original drop request notification
                if ($notificationId) {
                    notifSession::where('id', $notificationId)->delete();
                }

                // Send chat message
                $message = Chatify::newMessage([
                    'from_id' => Auth::user()->id,
                    'to_id' => $otherPartyId,
                    'body' => 'Tutoring session has been dropped.',
                    'attachment' => null,
                ]);

                // Save to history and delete session
                $encodedBookedSession = json_encode($bookedSession);
                bookingHistoryLogs::create([
                    'booking_details' => $encodedBookedSession,
                ]);

                Event::where('booked_session_id', $bookedSession->id)->delete();
                Log::info("Deleted all calendar events for booked session {$bookedSession->id}");

                $bookedSession->delete();

                return redirect()->route('workspace.start')->with([
                    'success' => 'Session has been dropped successfully.',
                ]);
                
            } else if ($request->input('accept') == 'false') {
                // Denied - Notify requester
                Log::info('Drop request denied');
                
                $requesterRole = $user->role === 'Student' ? 'Tutor' : 'Student';
                $requesterId = $user->role === 'Student' ? $bookedSession->tutor_id : $bookedSession->student_id;
                
                $dataDenied = [
                    'NotifType' => 'SessionDropRequestDenied',
                    'booked_session_id' => $sessionId,
                    'message' => 'Your request to drop the tutoring session has been denied.',
                    'denied_by' => $userName,
                ];

                $deniedNotif = notifSession::create([
                    'notif_info' => json_encode($dataDenied),
                    'to' => $requesterId,
                    'user_id' => Auth::user()->id,
                    'read_at' => null,
                ]);
                
                // Broadcast to requester in real-time
                broadcast(new NewNotification($requesterId, $deniedNotif));

                // Delete the original drop request notification
                if ($notificationId) {
                    notifSession::where('id', $notificationId)->delete();
                }

                return redirect()->route('workspace.start')->with([
                    'info' => 'Drop request has been denied.',
                ]);
            }
        }

        // Send drop request (both Student and Tutor can request)
        $student = Student::where('user_id', $bookedSession->student_id)->first();
        $tutor = Tutor::where('user_id', $bookedSession->tutor_id)->first();
        
        if (Auth::user()->role == 'Student') {
            // Student requesting to drop
            $data = [
                'NotifType' => 'SessionDropRequested',
                'booked_session_id' => $bookedSession->id,
                'requester_name' => $userName,
                'requester_role' => 'Student',
                'message' => $userName . ' has requested to drop the tutoring session.',
            ];
            
            // Check if request already exists
            if (notifSession::where('to', $bookedSession->tutor_id)
                ->where('user_id', $bookedSession->student_id)
                ->whereRaw("JSON_EXTRACT(notif_info, '$.NotifType') = ?", ['SessionDropRequested'])
                ->whereRaw("JSON_EXTRACT(notif_info, '$.booked_session_id') = ?", [$bookedSession->id])
                ->exists()
            ) {
                return redirect()->route('workspace.start')->with([
                    'info' => 'You have already sent a drop request for this session.',
                ]);
            }
            
            $notification = notifSession::create([
                'notif_info' => json_encode($data),
                'to' => $bookedSession->tutor_id,
                'user_id' => $bookedSession->student_id,
                'read_at' => null,
            ]);
            
            // Broadcast in real-time to tutor
            broadcast(new NewNotification($bookedSession->tutor_id, $notification));
            
            return redirect()->route('workspace.start')->with([
                'success' => 'Drop request sent to tutor. Waiting for confirmation.',
            ]);
        } else {
            // Tutor requesting to drop
            $data = [
                'NotifType' => 'SessionDropRequested',
                'booked_session_id' => $bookedSession->id,
                'requester_name' => $userName,
                'requester_role' => 'Tutor',
                'message' => $userName . ' has requested to drop the tutoring session.',
            ];
            
            // Check if request already exists
            if (notifSession::where('to', $bookedSession->student_id)
                ->where('user_id', $bookedSession->tutor_id)
                ->whereRaw("JSON_EXTRACT(notif_info, '$.NotifType') = ?", ['SessionDropRequested'])
                ->whereRaw("JSON_EXTRACT(notif_info, '$.booked_session_id') = ?", [$bookedSession->id])
                ->exists()
            ) {
                return redirect()->route('workspace.start')->with([
                    'info' => 'You have already sent a drop request for this session.',
                ]);
            }
            
            $notification = notifSession::create([
                'notif_info' => json_encode($data),
                'to' => $bookedSession->student_id,
                'user_id' => $bookedSession->tutor_id,
                'read_at' => null,
            ]);
            
            // Broadcast in real-time to student
            broadcast(new NewNotification($bookedSession->student_id, $notification));
            
            return redirect()->route('workspace.start')->with([
                'success' => 'Drop request sent to student. Waiting for confirmation.',
            ]);
        }
    }
}
