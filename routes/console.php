<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CheckPaymentLinkStatus;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('check-upcoming-sessions', function () {
    Artisan::call('sessions:check-upcoming'); 
})->purpose('Check for upcoming tutoring sessions')->everyMinute();