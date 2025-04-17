<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'type',
        'description',
        'total',
        'period_start',
        'period_end'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date'
    ];

    /**
     * Get the formatted total.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2);
    }

    /**
     * Get the period duration in days.
     */
    public function getPeriodDurationAttribute(): int
    {
        return $this->period_start->diffInDays($this->period_end);
    }

    /**
     * Scope a query to only include reports of a specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if report is within current period.
     */
    public function isCurrentPeriod(): bool
    {
        $now = now();
        return $now->between($this->period_start, $this->period_end);
    }
}
