<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CorVerificationNotification extends Notification
{
    use Queueable;

    protected $schoolYear;

    /**
     * Create a new notification instance.
     */
    public function __construct($schoolYear)
    {
        $this->schoolYear = $schoolYear;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        Log::info("via() called for " . get_class($notifiable));
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'NotifType' => 'CorVerification',
            'message' => 'Please verify your COR for',
            'schoolYear' => $this->schoolYear
        ];
    }
}
