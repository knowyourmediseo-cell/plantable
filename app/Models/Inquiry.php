<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inquiry_number',
        'type',
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'product_id',
        'quantity',
        'custom_requirements',
        'status',
        'priority',
        'assigned_to',
        'followed_up_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'custom_requirements' => 'array',
        'followed_up_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($inquiry) {
            if (!$inquiry->inquiry_number) {
                $inquiry->inquiry_number = 'INQ-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function notes()
    {
        return $this->hasMany(InquiryNote::class);
    }

    public function attachments()
    {
        return $this->hasMany(InquiryAttachment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
}
