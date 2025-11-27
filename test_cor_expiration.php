<?php
/**
 * COR Settings Expiration Test Script
 * 
 * This script demonstrates how COR settings expiration works
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CorSetting;
use Carbon\Carbon;

echo "=============================================================\n";
echo "COR SETTINGS EXPIRATION TEST\n";
echo "=============================================================\n\n";

// Get current settings
$currentSetting = CorSetting::first();

if (!$currentSetting) {
    echo "❌ No COR settings found in database.\n";
    exit(1);
}

echo "📋 Current COR Settings:\n";
echo "   University: {$currentSetting->university_name}\n";
echo "   Campus: {$currentSetting->campus_name}\n";
echo "   Academic Year: {$currentSetting->academic_year}\n";
echo "   Valid From: {$currentSetting->valid_from->format('M d, Y')}\n";
echo "   Valid Until: {$currentSetting->valid_until->format('M d, Y')}\n";
echo "   Is Active: " . ($currentSetting->is_active ? '✅ YES' : '❌ NO') . "\n\n";

// Test current validity
echo "🔍 Current Status (Today: " . now()->format('M d, Y') . "):\n";
echo "   Is Valid: " . ($currentSetting->isValid() ? '✅ YES' : '❌ NO') . "\n";
echo "   Can Get Active: " . (CorSetting::getActive() ? '✅ YES' : '❌ NO') . "\n\n";

// Calculate days until expiration
$daysUntilExpiration = now()->diffInDays($currentSetting->valid_until, false);
if ($daysUntilExpiration > 0) {
    echo "⏰ Expires in: {$daysUntilExpiration} days\n\n";
} elseif ($daysUntilExpiration == 0) {
    echo "⚠️  Expires today!\n\n";
} else {
    echo "❌ Already expired " . abs($daysUntilExpiration) . " days ago!\n\n";
}

echo "=============================================================\n";
echo "SIMULATION TESTS\n";
echo "=============================================================\n\n";

// Test 1: What happens when settings expire?
echo "Test 1: What happens if valid_until was yesterday?\n";
$testDate = now()->subDay();
echo "   Simulating: valid_until = {$testDate->format('Y-m-d')}\n";
echo "   Would be valid: " . ($currentSetting->valid_until >= $testDate && $currentSetting->is_active ? '❌ NO' : '✅ YES (would expire)') . "\n\n";

// Test 2: What happens before valid_from?
echo "Test 2: What happens if valid_from is tomorrow?\n";
$testDate = now()->addDay();
echo "   Simulating: valid_from = {$testDate->format('Y-m-d')}\n";
echo "   Would be valid: " . ($currentSetting->valid_from <= $testDate && $currentSetting->is_active ? '✅ YES' : '❌ NO (not yet active)') . "\n\n";

echo "=============================================================\n";
echo "HOW TO TEST EXPIRATION\n";
echo "=============================================================\n\n";

echo "Option 1: Update valid_until to yesterday\n";
echo "   Run in Tinker:\n";
echo "   php artisan tinker\n";
echo "   >>> \$s = App\\Models\\CorSetting::first();\n";
echo "   >>> \$s->valid_until = now()->subDay();\n";
echo "   >>> \$s->save();\n\n";

echo "Option 2: Update valid_until via Filament Admin\n";
echo "   1. Login to admin panel\n";
echo "   2. Go to System Settings -> COR Verification Settings\n";
echo "   3. Edit the setting\n";
echo "   4. Change 'Valid Until' to yesterday's date\n";
echo "   5. Save\n\n";

echo "Option 3: Create a new expired setting\n";
echo "   Run in Tinker:\n";
echo "   php artisan tinker\n";
echo "   >>> App\\Models\\CorSetting::create([\n";
echo "       'university_name' => 'PAMPANGA STATE UNIVERSITY',\n";
echo "       'cor_title' => 'Certificate of Registration',\n";
echo "       'campus_name' => 'Bacolor Campus',\n";
echo "       'academic_year' => 'AY 2024-2025',\n";
echo "       'valid_from' => now()->subYear(),\n";
echo "       'valid_until' => now()->subDay(),\n";
echo "       'is_active' => true,\n";
echo "   ]);\n\n";

echo "After making it expired, try uploading COR again.\n";
echo "You should see: ⚠️ COR verification settings have expired.\n\n";
