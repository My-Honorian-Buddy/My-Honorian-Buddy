<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'title', 
        'start', 
        'end', 
        'booked_session_id', 
        'description', 
        'event_type', 
        'session_number'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with BookedSession
     */
    public function bookedSession()
    {
        return $this->belongsTo(bookedSession::class, 'booked_session_id');
    }
}
