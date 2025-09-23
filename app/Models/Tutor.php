<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\RewardRedemption;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutor extends Model

{
    /**
     * Get the user that owns the Tutor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id', 
        'fname',
        'lname',
        'rate_session',
        'exp',
        'address',
        'gender',
        'rating',
        'bio',
        'points',
        'NoOfReviews',
        'year_level',
        'department',
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
    
    public function rewardRedemptions (): HasMany
    {
        return $this->hasMany(RewardRedemption::class, 'tutor_id');
    }
}
