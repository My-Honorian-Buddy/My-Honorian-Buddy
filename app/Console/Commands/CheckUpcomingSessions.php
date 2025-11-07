<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\bookedSession;
use App\Models\notifSession;
use App\Events\NewNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckUpcomingSessions extends Command
{
    protected $signature = 'sessions:check-upcoming';
    protected $description = 'Check for sessions starting in 10 minutes and send reminder notifications';

    public function handle()
    {
        // Get the time 10 minutes from now (with 1 minute window)
        $tenMinutesFromNow = Carbon::now()->addMinutes(10);
        $nineMinutesFromNow = Carbon::now()->addMinutes(9);

        Log::info('Checking for upcoming sessions between ' . $nineMinutesFromNow . ' and ' . $tenMinutesFromNow);

        // Find sessions scheduled between 9-10 minutes from now
        $upcomingSessions = bookedSession::whereBetween('schedule_time', [
            $nineMinutesFromNow,
            $tenMinutesFromNow
        ])
        ->where('is_completed', false)
        ->get();

        Log::info('Found ' . $upcomingSessions->count() . ' upcoming sessions');

        foreach ($upcomingSessions as $session) {
            // Check if we've already sent a reminder for this session
            $existingReminder = notifSession::where('notif_info', 'like', '%SessionReminder%')
                ->where('notif_info', 'like', '%"bookedSession":' . $session->id . '%')
                ->where('created_at', '>', Carbon::now()->subMinutes(15))
                ->first();

            if ($existingReminder) {
                Log::info('Reminder already sent for session ' . $session->id);
                continue;
            }

            // Send reminder to student
            $studentNotif = notifSession::create([
                'notif_info' => json_encode([
                    'NotifType' => 'SessionReminder',
                    'message' => 'Your tutoring session starts in 10 minutes!',
                    'bookedSession' => $session->id,
                    'subject' => $session->tutoring_subject,
                    'schedule_time' => $session->schedule_time,
                    'tutor_id' => $session->tutor_id,
                ]),
                'to' => $session->student_id,
                'user_id' => $session->tutor_id,
                'read_at' => null,
            ]);
            broadcast(new NewNotification($session->student_id, $studentNotif));
            Log::info('Sent reminder to student ' . $session->student_id . ' for session ' . $session->id);

            // Send reminder to tutor
            $tutorNotif = notifSession::create([
                'notif_info' => json_encode([
                    'NotifType' => 'SessionReminder',
                    'message' => 'Your tutoring session starts in 10 minutes!',
                    'bookedSession' => $session->id,
                    'subject' => $session->tutoring_subject,
                    'schedule_time' => $session->schedule_time,
                    'student_id' => $session->student_id,
                ]),
                'to' => $session->tutor_id,
                'user_id' => $session->student_id,
                'read_at' => null,
            ]);
            broadcast(new NewNotification($session->tutor_id, $tutorNotif));
            Log::info('Sent reminder to tutor ' . $session->tutor_id . ' for session ' . $session->id);
        }

        $this->info('Processed ' . $upcomingSessions->count() . ' upcoming sessions');
        return 0;
    }
}
