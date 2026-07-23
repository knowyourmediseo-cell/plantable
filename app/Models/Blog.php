<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'author_id',
        'excerpt',
        'content',
        'featured_image',
        'views',
        'read_time',
        'is_featured',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_tag_pivot');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getUrlAttribute()
    {
        return route('frontend.blogs.show', $this->slug);
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : asset('images/placeholder.png');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
