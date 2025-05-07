<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CheckPaymentLinkStatus;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('check-payment-status', function () {
    Artisan::call('payment:check-status'); 
})->purpose('Manually check payment link status')->everyMinute();