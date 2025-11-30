<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\CorSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ResetExpiredCorStatus extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cor:reset-expired';

    /**
     * The console command description.
     */
    protected $description = 'Reset verified COR status to pending when academic year expires';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current active COR setting
        $activeSetting = CorSetting::getActive();
        
        // If no active settings or settings expired
        if (!$activeSetting || !$activeSetting->isValid()) {
            $this->info('No active COR settings found or settings have expired.');
            
            // Reset all verified users to pending
            $affectedUsers = User::where('cor_status', 'verified')
                ->update(['cor_status' => 'pending']);
            
            $this->info("Reset {$affectedUsers} verified users to pending status.");
            
            Log::info("COR Status Reset: {$affectedUsers} users reset from verified to pending due to expired settings.");
            
            return Command::SUCCESS;
        }
        
        $this->info('COR settings are still valid. No reset needed.');
        $this->info("Valid until: {$activeSetting->valid_until->format('M d, Y')}");
        
        return Command::SUCCESS;
    }
}
