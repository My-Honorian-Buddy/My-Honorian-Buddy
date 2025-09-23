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

class SessionController extends Controller
{
    public function store(Request $request){

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
            $notifInfo = [
                'NotifType' => 'Tutor Request Accepted',
                'subjects' => $subjects,
                'tutor_name' => $tutor->fname .' '. $tutor->lname,
                'schedule_time' => $validated['schedule_time'],
                'total_session' => $validated['total_session'],
            ];
            notifSession::create([
                'notif_info' => json_encode($notifInfo),
                'to' => $validated['student_id'],
                'user_id' => $validated['tutor_id'] ,
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


    public function notifStore (Request $request) {
        Log::info('All Data for Notif Tutor Request: ', $request->all());
        
        $userID = Auth::user()->id;

        $user = User::find($userID);

        $student = $user->student;

        $studentName = $student->fname . ' ' . $student->lname;
        
        
        $validated =$request->validate([
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


        $notifInfo = [
            
            'NotifType' => $validated['NotifType'],
            'Schedule Time' => $scheduleTime,
            'Total Session' => $validated['total_session'],
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
                'user_id' => $userID ,
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

            // Calculate payment
            $totalAmount = $tutor->rate_session * $bookedSession->num_session;
            $tutorname = $tutor->fname .' '. $tutor->lname;
            // Initialize Guzzle client
            $client = new Client([
                'base_uri' => 'https://api.paymongo.com/v1/',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(config('services.paymongo.secret_key') . ':'),
                    'Content-Type' => 'application/json',
                ],
            ]);
            
            try {

                // Create Payment Link
                $paymentLinkResponse = $client->post('links', [
                    'json' => [
                        'data' => [
                            'attributes' => [
                                'amount' => $totalAmount * 100,  // Amount in cents
                                'description' => "Payment for tutoring session #{$bookedSession->id} for {$tutorname}",
                                'remarks' => 'Honorian Buddy Payment',  // Optional remarks
                            ],
                        ],
                    ],
                ]);
               
                // Parse the response
                $paymentLink = json_decode($paymentLinkResponse->getBody()->getContents(), true);
    
                // Log the Payment Link response for debugging
                $bookedSession->payment_link_sent = true;
                $bookedSession->payment_link_url = $paymentLink['data']['id'];
                $bookedSession->is_completed = true;
                $bookedSession->save();
                
                // Notify student with the payment link
                notifSession::create([
                    'notif_info' => json_encode([
                        'NotifType' => 'PaymentLink',
                        'payment_url' => $paymentLink['data']['attributes']['checkout_url'],
                        'amount' => $totalAmount,
                        'booked_session_id' => $bookedSession->id,
                    ]),
                    'to' => $bookedSession->student_id,
                    'user_id' => $bookedSession->tutor_id,
                    'read_at' => null,
                ]);

                return redirect()->route('workspace.start')->with([
                    'linkSent' => 'Session marked as completed and payment link has been sent to student',
                ]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Extract and log detailed error information
                $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
                Log::error('Failed to create payment link', [
                    'session_id' => $sessionId,
                    'error' => $e->getMessage(),
                    'response' => $responseBody,
                ]);
    
                return response()->json([
                    'error' => 'Failed to create payment link',
                    'details' => $e->getMessage(),
                    'response' => $responseBody,
                ], 500);
            }
        }

        return redirect()->route('workspace.start')->with([
            'linkSent' => 'Session marked as completed and payment link has been sent to student',
        ]);
        
    }
    
    public function dropSession(Request $request){
        $accept = $request->input('accept') ?? 'none';
        $sessionId = $request->input('session_id');
        $bookedSession = bookedSession::findOrFail($sessionId);
        $user = Auth::user();
        $userName = $user->student ? $user->student->fname . ' ' . $user->student->lname : $user->tutor->fname . ' ' . $user->tutor->lname;

        if ($accept != 'none') {

            notifSession::where('id', $request->input('notification_id'))->delete();

            if($request->input('accept') == 'true'){

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
            }else if($request->input('accept') == 'false'){
                
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
                ->exists()) 
            {
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
            'studentName' => $student->fname .' '. $student->lname,
        ];
        if (notifSession::where('to', $bookedSession->tutor_id)
            ->where('user_id', $bookedSession->student_id)
            ->where('notif_info', json_encode($data))
            ->exists()) 
        {

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
