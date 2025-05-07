<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $fillable = [
        'user_id',
        'days_week',
        'start_time',
        'end_time',
    ];

    public function user_schedule()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $casts = [
        'days_week' => 'array',
    ];
}
