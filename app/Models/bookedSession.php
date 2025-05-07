<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bookedSession extends Model
{
    use HasFactory;

    protected $table = 'bookedsessions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'tutor_id',
        'tutoring_subject',
        'schedule_time',
        'is_completed',
        'duration',
        'status',
        'num_session',
        'total_session',
        'feedback',
        'room',
        'accept',
        'reviewed',
        'sesUpdate',
    ];

    protected $casts = [
        'reviewed' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'user_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id', 'user_id');
    }

}
