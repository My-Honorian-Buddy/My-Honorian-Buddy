<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Console\Commands;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Register your custom command here
        Commands\CheckUpcomingSessions::class,
        Commands\ResetExpiredCorStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::info("🔔 Checking for upcoming sessions every minute");
        $schedule->command('sessions:check-upcoming')->everyMinute()->sendOutputTo(storage_path('sessions_reminder.log'));
        
        // COR expiration reset - runs daily at midnight
        // Note: If scheduler doesn't work, use direct cron: 0 0 * * * php artisan cor:reset-expired
        $schedule->command('cor:reset-expired')
            ->daily()
            ->at('00:00')
            ->sendOutputTo(storage_path('logs/cor_reset.log'));
    }
    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
