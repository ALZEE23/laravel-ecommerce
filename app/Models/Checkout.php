<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'payment_method',
        'status'
    ];

    // Constants for status
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function markAsPaid(): bool
    {
        if ($this->order->status !== 'processing') {
            return false;
        }

        return $this->update(['status' => self::STATUS_PAID]);
    }

    public function markAsFailed(): bool
    {
        return $this->update(['status' => self::STATUS_FAILED]);
    }

    // Observer method to handle order status changes
    public static function boot()
    {
        parent::boot();

        static::created(function ($checkout) {
            // Create checkout when order is created
            if ($checkout->order->status === 'pending') {
                $checkout->update(['status' => self::STATUS_PENDING]);
            }
        });
    }
}
