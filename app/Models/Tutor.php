<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tutor extends Model
{
    /**
     * Get the user that owns the Tutor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

     protected $fillable = [
        'user_id', 
        'fname',
        'lname',
        'rate_session',
        'exp',
        'address',
        'gender',
        'rating',
        'gcash',
        'grabpay',
        'maya',
        'bio',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function subject_tutor(): HasMany
    {
        return $this->hasMany(tutorSubject::class, 'tutor_id', 'user_id');
    }

    public function bookedsessions(): HasOne
    {
        return $this->hasOne(bookedSession::class, 'tutor_id', 'user_id');
    }

    public function review(): HasMany //Being Reviewed
    {
        return $this->hasMany(Review::class, 'tutor_id');
    }
}
