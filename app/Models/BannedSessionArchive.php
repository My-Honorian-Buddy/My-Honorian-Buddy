<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannedSessionArchive extends Model
{
    use HasFactory;

    protected $table = 'banned_sessions_archive';

    protected $fillable = [
        'original_session_id',
        'student_id',
        'tutor_id',
        'student_name',
        'tutor_name',
        'tutoring_subject',
        'schedule_time',
        'duration',
        'status',
        'num_session',
        'total_session',
        'feedback',
        'room',
        'is_completed',
        'reviewed',
        'ban_reason',
        'ban_requested_at',
        'tutor_report',
        'tutor_report_images',
        'tutor_report_submitted_at',
        'ban_status',
        'banned_at',
        'banned_by',
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
        'ban_requested_at' => 'datetime',
        'tutor_report_submitted_at' => 'datetime',
        'banned_at' => 'datetime',
        'tutor_report_images' => 'array',
        'is_completed' => 'boolean',
        'reviewed' => 'boolean',
    ];
}
