<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Models\bookedSession;
use App\Models\NotifSession;
use App\Models\User;
use App\Models\Student;
use App\Models\Tutor;

class CheckPaymentLinkStatus extends Command
{
    protected $signature = 'payment:check-status';
    protected $description = 'Check payment link statuses and update if paid';

    public function handle()
    {
        Log::info('Checking payment link statuses...');
        $client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('sk_test_AZ62m1KYoxnorEvpFbP1oysg:'),
            ],
        ]);

        // Get all unpaid booked sessions with a payment link
        $bookedSessions = bookedSession::whereNotNull('payment_link_url')
                                       ->where('status', 'pending')
                                       ->get();

        Log::info("Found {$bookedSessions->count()} sessions with pending payment links");
        foreach ($bookedSessions as $session) {
            try {
                // Fetch the payment link details
                $response = $client->request('GET', 'links/' . $session->payment_link_url);
                $linkData = json_decode($response->getBody()->getContents(), true);

                Log::info("Payment link status for session ID: {$session->id} is {$linkData['data']['attributes']['status']}");

                // Check if the link status is "paid"
                if ($linkData['data']['attributes']['status'] === 'paid') {
                    $session->status = 'completed';
                    $session->save();
                    
                    $studentName = Student::where('user_id', $session->student_id)->first();
                    // Define the notification data
                    $notifData = [
                        'NotifType' => 'PaymentReceived',
                        'message' => "The student has paid PHP " . ($linkData['data']['attributes']['amount'] / 100) . 
                                    " for Booked Session ID: {$session->id}.",
                        'bookedSession' => $session->id,
                        'studentName' => $studentName->fname . " ". $studentName->lname,
                    ];

                    // Check if a similar notification already exists for the tutor
                    $existingNotification = NotifSession::where('to', $session->tutor_id)
                    ->where('user_id', $session->student_id)
                    ->whereJsonContains('notif_info->NotifType', $notifData['NotifType'])
                    ->whereJsonContains('notif_info->bookedSession', $notifData['bookedSession'])
                    ->first();
                        
                    NotifSession::where('to', $session->student_id)
                    ->where('user_id', $session->tutor_id)
                    ->whereJsonContains('notif_info', [
                        'NotifType' => 'PaymentLink',
                        'payment_url' => $linkData['data']['attributes']['checkout_url'],
                        'amount' => $linkData['data']['attributes']['amount'],
                        'booked_session_id' => $session->id,
                    ])
                    ->delete();
                    

                    if (!$existingNotification) {
                        // If no similar notification exists, create a new one
                        NotifSession::create([
                            'notif_info' => json_encode($notifData),
                            'to' => $session->tutor_id, // Notify the tutor
                            'user_id' => $session->student_id, // The student who paid
                            'read_at' => null,
                        ]);
                    }

                
                    Log::info("Payment received for session ID: {$session->id}");
                }
            } catch (\Exception $e) {
                Log::error("Failed to check payment link status for session ID: {$session->id}", [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return Command::SUCCESS;
    }
}
