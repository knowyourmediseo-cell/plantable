<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'iso3',
        'phone_code',
        'currency',
        'currency_symbol',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
