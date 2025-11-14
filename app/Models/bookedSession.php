<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class bookedSession extends Model
{
    use HasFactory, SoftDeletes;

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
        'admin_approved',
        'ban_requested',
        'ban_reason',
        'ban_requested_at',
        'tutor_report',
        'tutor_report_images',
        'tutor_report_submitted_at',
        'ban_status',
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
        'reviewed' => 'boolean',
        'ban_requested' => 'boolean',
        'tutor_report_images' => 'array',
        'ban_requested_at' => 'datetime',
        'tutor_report_submitted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'user_id');
    }

    public function studentUser()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function tutorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id', 'id');
    }

}
