<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ToDoLists extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'is_completed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
