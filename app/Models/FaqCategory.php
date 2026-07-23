<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
