<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tutor_id',
        'comment',
        'rating',
    ];

    /**
     * Get the user that owns the Review
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }
    
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'user_id');
    }
}
