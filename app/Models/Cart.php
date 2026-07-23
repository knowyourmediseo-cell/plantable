<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_code',
        'discount_amount',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getTotalAttribute()
    {
        return $this->subtotal - $this->discount_amount;
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    public static function getCurrentCart()
    {
        if (auth()->check()) {
            return static::firstOrCreate([
                'user_id' => auth()->id(),
            ]);
        }

        $sessionId = session()->getId();
        return static::firstOrCreate([
            'session_id' => $sessionId,
        ]);
    }

    public function mergeWithUserCart()
    {
        if (!auth()->check()) {
            return;
        }

        $userCart = static::where('user_id', auth()->id())->first();
        
        if (!$userCart || $userCart->id === $this->id) {
            $this->update(['user_id' => auth()->id(), 'session_id' => null]);
            return;
        }

        // Merge items
        foreach ($this->items as $item) {
            $existingItem = $userCart->items()
                ->where('product_id', $item->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $item->quantity
                ]);
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        $this->delete();
    }
}
