<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bookingHistoryLogs extends Model
{
    //

    protected $fillable = [
        'booking_details',
    ];

    protected $casts = [
        'booking_details' => 'array',
    ];
}
