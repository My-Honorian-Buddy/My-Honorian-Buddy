<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reward extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'pointsReq',
        'image',
    ];

    public function redemptions () {
        return $this->hasMany(RewardRedemption::class);
    }
}
