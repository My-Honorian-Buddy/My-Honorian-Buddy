<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CorSetting;
use Carbon\Carbon;

class CorSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default COR setting for current academic year
        CorSetting::create([
            'university_name' => 'PAMPANGA STATE UNIVERSITY',
            'cor_title' => 'Certificate of Registration',
            'campus_name' => 'Bacolor Campus',
            'academic_year' => 'AY 2025-2026',
            'valid_from' => Carbon::create(2025, 8, 1), // August 1, 2025
            'valid_until' => Carbon::create(2026, 7, 31), // July 31, 2026
            'is_active' => true,
            'additional_keywords' => null, // No additional keywords needed for academic year basis
        ]);

        $this->command->info('✅ Default COR verification settings created successfully');
    }
}
