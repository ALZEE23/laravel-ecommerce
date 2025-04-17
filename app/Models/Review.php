<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
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
        'rating',
        'comment'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer'
    ];

    /**
     * Get the user who wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being reviewed.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get star rating as HTML.
     */
    public function getStarRatingAttribute(): string
    {
        $stars = str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
        return "<span class='text-yellow-400'>{$stars}</span>";
    }

    /**
     * Scope a query to only include verified purchase reviews.
     */
    public function scopeVerified($query)
    {
        return $query->whereHas('user.orders', function ($query) {
            $query->whereHas('products', function ($query) {
                $query->where('product_id', $this->product_id);
            });
        });
    }

    /**
     * Check if review is from a verified purchase.
     */
    public function isVerifiedPurchase(): bool
    {
        return $this->user->orders()
            ->whereHas('products', function ($query) {
                $query->where('product_id', $this->product_id);
            })->exists();
    }
}
