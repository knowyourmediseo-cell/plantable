<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'template',
        'featured_image',
        'show_in_menu',
        'sort_order',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
    ];

    protected $casts = [
        'show_in_menu' => 'boolean',
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function getUrlAttribute()
    {
        return route('frontend.pages.show', $this->slug);
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('uploads/pages/' . $this->featured_image) : null;
    }
}
