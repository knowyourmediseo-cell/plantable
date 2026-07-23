<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
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

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
