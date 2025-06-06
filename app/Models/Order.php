<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'promotion_id',
        'discount_amount',
        'status',
        'payment_method',
        'shipping_address',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the order.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the promotion used for the order.
     */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Get the checkout associated with the order.
     */
    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    /**
     * Check if order can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Get the formatted total price.
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return number_format($this->total_price, 2);
    }

    /**
     * Get the formatted discount amount.
     */
    public function getFormattedDiscountAmountAttribute(): string
    {
        return number_format($this->discount_amount ?? 0, 2);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Create checkout automatically when order is created
        static::created(function ($order) {
            $order->checkout()->create([
                'user_id' => $order->user_id,
                'payment_method' => $order->payment_method,
                'status' => 'pending'
            ]);
        });

        // Update checkout status when order status changes to processing
        static::updated(function ($order) {
            if ($order->status === 'processing' && $order->getOriginal('status') === 'pending') {
                $order->checkout->markAsPaid();
            }
        });
    }
}
