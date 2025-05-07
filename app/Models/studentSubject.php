<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class studentSubject extends Model
{
    /**
     * Get the user that owns the studentSubject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected $fillable = [
        //for student subjects
        'student_id',
        'subj_code',
        'subj_name',
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }



}
