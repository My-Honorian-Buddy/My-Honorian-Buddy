<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Status;

class RewardRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'reward_id',
        'tutor_id',
        'status',
    ];

    // protected $casts = [
    //     'stats' => Status::class,
    // ];

    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected'; 

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

}
