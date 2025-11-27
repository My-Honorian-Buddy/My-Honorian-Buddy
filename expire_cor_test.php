<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CorSetting;

$setting = CorSetting::first();
$originalDate = $setting->valid_until->copy();

// Set to expired (yesterday)
$setting->valid_until = now()->subDay();
$setting->save();

echo "✅ COR setting is now expired!\n";
echo "   Valid Until: {$setting->valid_until->format('Y-m-d')}\n";
echo "   Original Date: {$originalDate->format('Y-m-d')}\n\n";
echo "Now try uploading a COR - you should see an expiration error.\n\n";
echo "To restore, run: php restore_cor_date.php\n";

// Save original date to file
file_put_contents(__DIR__.'/original_cor_date.txt', $originalDate->format('Y-m-d'));
