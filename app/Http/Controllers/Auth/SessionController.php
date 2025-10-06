<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Mail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\bookedSession;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\tutorSubject;
use App\Models\notifSession;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;
use App\Models\bookingHistoryLogs;
use App\Events\NewNotification;
use Carbon\Carbon;
use App\Models\Schedule;

class SessionController extends Controller
{
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
            notifSession::create([
                'notif_info' => json_encode($notifInfo),
                'to' => $validated['student_id'],
                'user_id' => $validated['tutor_id'],
                'read_at' => null,
            ]);

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

        notifSession::create([
            'notif_info' => json_encode($notifInfo),
            'to' => $validated['tutor_id'],
            'user_id' => $userID,
            'read_at' => null,
        ]);

        Log::info('Notif created successfully', [
            'notif_info' => $notifInfo,
        ]);

        $tutor = tutorSubject::find($validated['tutor_id']);

        // Log::info('Tutor Subjects: ', $tutor->toArray());
        broadcast(new NewNotification($userID));

        return redirect()->route('workspace.start')->with([
            'success' => 'Tutor request sent successfully!',
            'tutor' => $tutor,

        ]);
    }

    public function SessionComplete(Request $request)
    {

        $sessionId = $request->input('session_id');
        $bookedSession = bookedSession::findOrFail($sessionId);

        if ($bookedSession->payment_link_sent) {
            return redirect()->back()->with([
                'cannotSend' => 'Payment link has already been sent.',
            ]);
        }

        if ($bookedSession->num_session == 0 && !$bookedSession->is_completed) {
            return redirect()->route('workspace.start')->with([
                'cannotComplete' => 'Cannot marked session as complete because no session/meetings has been made.',
            ]);
        }

        // Check if session is completed or the number of sessions reached the total session
        if ($bookedSession->is_completed || $bookedSession->num_session == $bookedSession->total_session) {

            // Retrieve tutor details
            $tutor = Tutor::where('user_id', $bookedSession->tutor_id)->first();
            $tutorPoints = $tutor->points ?? 0;
            $tutorPoints += 10;
            // Calculate payment
            // $totalAmount = $tutor->rate_session * $bookedSession->num_session;
            // $tutorname = $tutor->fname . ' ' . $tutor->lname;
            // Initialize Guzzle client
            // $client = new Client([
            //     'base_uri' => 'https://api.paymongo.com/v1/',
            //     'headers' => [
            //         'Accept' => 'application/json',
            //         'Authorization' => 'Basic ' . base64_encode(config('services.paymongo.secret_key') . ':'),
            //         'Content-Type' => 'application/json',
            //     ],
            // ]);

            try {

                // Create Payment Link
                // $paymentLinkResponse = $client->post('links', [
                //     'json' => [
                //         'data' => [
                //             'attributes' => [
                //                 'amount' => $totalAmount * 100,  // Amount in cents
                //                 'description' => "Payment for tutoring session #{$bookedSession->id} for {$tutorname}",
                //                 'remarks' => 'Honorian Buddy Payment',  // Optional remarks
                //             ],
                //         ],
                //     ],
                // ]);

                // Parse the response
                // $paymentLink = json_decode($paymentLinkResponse->getBody()->getContents(), true);

                // // Log the Payment Link response for debugging
                // $bookedSession->payment_link_sent = true;
                // $bookedSession->payment_link_url = $paymentLink['data']['id'];
                // $bookedSession->is_completed = true;
                // $bookedSession->save();

                // Notify student with the payment link
                notifSession::create([
                    'notif_info' => json_encode([
                        'NotifType' => 'CompleteSession',
                        'message' => 'Your tutoring session has been marked as completed.',
                    ]),
                    'to' => $bookedSession->student_id,
                    'user_id' => $bookedSession->tutor_id,
                    'read_at' => null,
                ]);

                $bookedSession->delete();

                return redirect()->route('workspace.start')->with([
                    'linkSent' => 'Session marked as completed and payment link has been sent to student',
                ]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Extract and log detailed error information
                $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
                
                return response()->json([
                    'error' => 'Failed to complete the session.',
                    'details' => $e->getMessage(),
                    'response' => $responseBody,
                ], 500);
            }
        }



        return redirect()->route('workspace.start')->with([
            'linkSent' => 'Session marked as completed and payment link has been sent to student',
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

        // Get student and tutor schedules
        $studentSchedule = Schedule::where('user_id', $studentId)->first();
        $tutorSchedule = Schedule::where('user_id', $tutorId)->first();

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
        
        \Log::info('Student days: ' . implode(', ', $studentDays));
        \Log::info('Tutor days: ' . implode(', ', $tutorDays));
        
        $matchingDays = array_intersect($studentDays, $tutorDays);
        $matchingDays = array_values($matchingDays);
        
        \Log::info('Matching days found: ' . implode(', ', $matchingDays));
        \Log::info('Number of matching days: ' . count($matchingDays));

        if (empty($matchingDays)) {
            \Log::info('No matching days found - Student: [' . implode(', ', $studentDays) . '] vs Tutor: [' . implode(', ', $tutorDays) . ']');
            return response()->json([
                'success' => false,
                'message' => 'No matching schedule days found - kahit isang araw lang walang match',
                'student_days' => $studentDays,
                'tutor_days' => $tutorDays
            ]);
        }
        
        \Log::info('SUCCESS: Found ' . count($matchingDays) . ' matching day(s): ' . implode(', ', $matchingDays));

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

            \Log::info('Schedule Times - Student: ' . $studentStartTime->format('g:i A') . ' - ' . $studentEndTime->format('g:i A'));
            \Log::info('Schedule Times - Tutor: ' . $tutorStartTime->format('g:i A') . ' - ' . $tutorEndTime->format('g:i A'));

            $overlapStart = $studentStartTime->gt($tutorStartTime) ? $studentStartTime : $tutorStartTime; // max st
            $overlapEnd = $studentEndTime->lt($tutorEndTime) ? $studentEndTime : $tutorEndTime; // min et

            $overlappingTime = null;
            if ($overlapStart->lt($overlapEnd)) {
                
                $overlappingTime = $overlapStart->format('g:i A') . ' - ' . $overlapEnd->format('g:i A');
                \Log::info('Calculated overlap: ' . $overlappingTime);
            } else {
                \Log::info('No overlap - Start: ' . $overlapStart->format('g:i A') . ' End: ' . $overlapEnd->format('g:i A'));
                
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
            \Log::error('Error calculating overlapping time: ' . $e->getMessage());
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
        $accept = $request->input('accept') ?? 'none';
        $sessionId = $request->input('session_id');
        $bookedSession = bookedSession::findOrFail($sessionId);
        $user = Auth::user();
        $userName = $user->student ? $user->student->fname . ' ' . $user->student->lname : $user->tutor->fname . ' ' . $user->tutor->lname;

        if ($accept != 'none') {

            notifSession::where('id', $request->input('notification_id'))->delete();

            if ($request->input('accept') == 'true') {

                $dataDrop = [
                    'NotifType' => 'SessionSuccessfullyDropped',
                    'booked_session_id' => $sessionId,
                    'message' => 'Your tutoring session has been dropped.',
                    'tutorName' => $userName,
                    'tutor_id' => Auth::user()->id,
                ];

                notifSession::create([
                    'notif_info' => json_encode($dataDrop),
                    'to' => $bookedSession->student_id,
                    'user_id' => $bookedSession->tutor_id,
                    'read_at' => null,
                ]);
                notifSession::create([
                    'notif_info' => json_encode($dataDrop),
                    'to' => $bookedSession->tutor_id,
                    'user_id' => $bookedSession->student_id,
                    'read_at' => null,
                ]);
            } else if ($request->input('accept') == 'false') {

                $data = [
                    'NotifType' => 'SessionDropRequestDenied',
                    'booked_session_id' => $sessionId,
                    'message' => 'Your request to drop the tutoring session has been denied.',
                    'tutorName' => $userName,
                ];

                notifSession::create([
                    'notif_info' => json_encode($data),
                    'to' => $bookedSession->student_id,
                    'user_id' => $bookedSession->tutor_id,
                    'read_at' => null,
                ]);

                notifSession::where('id', $request->input('notification_id'))->delete();
                return redirect()->route('workspace.start')->with([
                    'dropResponse' => 'Session dropped successfully.',
                ]);
            };
        }

        if (Auth::user()->role == 'Student') {

            $data = [
                'NotifType' => 'DropSession',
                'booked_session_id' => $bookedSession->id,
                'studentName' => $userName,
            ];
            if (notifSession::where('to', $bookedSession->tutor_id)
                ->where('user_id', $bookedSession->student_id)
                ->where('notif_info', json_encode($data))
                ->exists()
            ) {
                return redirect()->route('workspace.start')->with([
                    'dropRequest' => 'You have already sent a drop request for your current session.',
                ]);
            }
            notifSession::create([
                'notif_info' => json_encode($data),
                'to' => $bookedSession->tutor_id,
                'user_id' => $bookedSession->student_id,
                'read_at' => null,
            ]);
            return redirect()->route('workspace.start')->with([
                'dropRequest' => 'Session dropped request sent to the tutor.',
            ]);
        }
        $student = Student::where('user_id', $bookedSession->student_id)->first();

        $data = [
            'NotifType' => 'DropSession',
            'booked_session_id' => $bookedSession->id,
            'studentName' => $student->fname . ' ' . $student->lname,
        ];
        if (notifSession::where('to', $bookedSession->tutor_id)
            ->where('user_id', $bookedSession->student_id)
            ->where('notif_info', json_encode($data))
            ->exists()
        ) {
        }
        $message = Chatify::newMessage([
            'from_id' => $bookedSession->tutor_id,
            'to_id' => $bookedSession->student_id,
            'body' => 'Tutoring session has been ended.',
            'attachment' => null,
        ]);

        // Notify both users of the new conversation
        Chatify::push("private-chatify." . $bookedSession->tutor_id . "." . $bookedSession->student_id, 'messaging', [
            'from_id' => $bookedSession->tutor_id,
            'to_id' => $bookedSession->student_id,
            'message' => Chatify::messageCard(Chatify::parseMessage($message), true)
        ]);

        $encodedBookedSession = json_encode($bookedSession);
        bookingHistoryLogs::create([
            'booking_details' => $encodedBookedSession,
        ]);

        $bookedSession->delete();

        return redirect()->route('workspace.start')->with([
            'dropSuccess' => 'Session dropped successfully',
        ]);
    }
}
