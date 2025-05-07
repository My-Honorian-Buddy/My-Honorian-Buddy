<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $hasNotification;

    protected $listeners = ['refreshNotificationBell' => 'checkNotifications'];

    public function mount()
    {
        $this->checkNotifications();
    }

    public function checkNotifications()
    {
        $this->hasNotification = Auth::user()->hasNotification;
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}

