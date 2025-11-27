<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CorSetting;
use Carbon\Carbon;

$setting = CorSetting::first();

// Read original date from file
if (file_exists(__DIR__.'/original_cor_date.txt')) {
    $originalDate = Carbon::parse(file_get_contents(__DIR__.'/original_cor_date.txt'));
} else {
    $originalDate = Carbon::create(2026, 7, 31);
}

$setting->valid_until = $originalDate;
$setting->save();

echo "✅ COR setting restored!\n";
echo "   Valid Until: {$setting->valid_until->format('Y-m-d')}\n";

// Clean up
if (file_exists(__DIR__.'/original_cor_date.txt')) {
    unlink(__DIR__.'/original_cor_date.txt');
}
