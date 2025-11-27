<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class CorSetting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'university_name',
        'cor_title',
        'campus_name',
        'academic_year',
        'valid_from',
        'valid_until',
        'is_active',
        'additional_keywords',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'additional_keywords' => 'array',
    ];

    /**
     * Get the currently active COR settings
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->latest()
            ->first();
    }

    /**
     * Get all required keywords for verification
     */
    public function getRequiredKeywords(): array
    {
        $keywords = [
            $this->university_name,
            $this->cor_title,
            'Student No',
            $this->campus_name,
            $this->academic_year,
        ];

        // Add any additional keywords
        if ($this->additional_keywords && is_array($this->additional_keywords)) {
            $keywords = array_merge($keywords, $this->additional_keywords);
        }

        return array_filter($keywords); // Remove empty values
    }

    /**
     * Check if this setting is currently valid
     */
    public function isValid(): bool
    {
        $now = now();
        return $this->is_active 
            && $this->valid_from <= $now 
            && $this->valid_until >= $now;
    }

    /**
     * Automatically deactivate expired settings
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($corSetting) {
            // If setting is marked as active, deactivate all others
            if ($corSetting->is_active) {
                self::where('id', '!=', $corSetting->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
