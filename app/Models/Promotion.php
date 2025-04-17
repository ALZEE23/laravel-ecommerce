<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'usage_limit',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discount_value' => 'decimal:2',
        'usage_limit' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the orders using this promotion.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if promotion is currently valid.
     */
    public function isValid(): bool
    {
        $now = now();
        return $this->is_active &&
            $now->between($this->start_date, $this->end_date) &&
            $this->getRemainingUsage() > 0;
    }

    /**
     * Get remaining usage count.
     */
    public function getRemainingUsage(): int
    {
        $usedCount = $this->orders()->count();
        return max(0, $this->usage_limit - $usedCount);
    }

    /**
     * Calculate discount amount for given price.
     */
    public function calculateDiscount(float $price): float
    {
        if ($this->discount_type === 'percentage') {
            return round(($price * $this->discount_value) / 100, 2);
        }
        return min($price, $this->discount_value);
    }
}
