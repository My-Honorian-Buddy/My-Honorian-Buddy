<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'provider',
        'role',
        'mode',
        'profile_pic',
        'hasNotification',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function tutor(): HasOne
    {
        return $this->hasOne(Tutor::class, 'user_id', 'id');
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'user_id', 'id');
    }

    public function to_do_lists(): HasMany
    {
        return $this->hasMany(ToDoLists::class);
    }

    public function bookedsessions(): HasOne {
        return $this->hasOne(bookedSession::class, 'bookedsession_id', 'id');
    }

    
    
}
