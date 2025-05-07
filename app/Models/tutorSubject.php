<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class tutorSubject extends Model
{
    /**
     * Get the user that owns the tutorSubject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected $fillable =[
        'tutor_id',
        'subj_code',
        'subj_name',
        
    ];
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'user_id');
    }
}
