<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'status',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'user_type', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relationships
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'assigned_to');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->where('user_type', 'customer');
    }

    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }

    // Accessors
    public function getIsAdminAttribute()
    {
        return $this->user_type === 'admin';
    }

    public function getIsCustomerAttribute()
    {
        return $this->user_type === 'customer';
    }
}
