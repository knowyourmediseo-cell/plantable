<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'minimum_order_amount',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function isValid()
    {
        if (!$this->status) {
            return false;
        }

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'fixed') {
            $discount = $this->value;
        } else {
            $discount = ($amount * $this->value) / 100;
        }

        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        return min($discount, $amount);
    }
}
