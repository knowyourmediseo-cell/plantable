<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'location',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('sort_order');
    }

    public function allItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}
