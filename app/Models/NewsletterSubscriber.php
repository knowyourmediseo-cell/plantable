<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'status',
        'token',
        'subscribed_at',
        'unsubscribed_at',
        'ip_address',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($subscriber) {
            if (!$subscriber->token) {
                $subscriber->token = Str::random(32);
            }
            if (!$subscriber->subscribed_at && $subscriber->status === 'subscribed') {
                $subscriber->subscribed_at = now();
            }
        });
    }

    public function scopeSubscribed($query)
    {
        return $query->where('status', 'subscribed');
    }

    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }
}
