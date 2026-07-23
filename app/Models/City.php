<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'state_id',
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
