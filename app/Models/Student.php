<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    /**
     * Get the user that owns the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected $fillable =[
        'user_id', 
        'department',
        'fname',
        'lname',
        'year_level',
        'address',
        'gender',
        'bio',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subject_student(): HasMany
    {
        return $this->hasMany(studentSubject::class, 'student_id', 'user_id' );
    }

    public function bookedsessions(): HasOne
    {
        return $this->hasOne(bookedSession::class, 'student_id', 'user_id');
    }

    public function review(): HasMany //Reviewer
    {
        return $this->hasMany(Review::class, 'student_id');
    }
}