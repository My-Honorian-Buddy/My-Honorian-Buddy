<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notifSession extends Model
{
    protected $fillable = [
        'notif_info',
        'to',
        'user_id',
    ];

    protected $casts = [
        'notif_info' => 'array',
    ];

}
