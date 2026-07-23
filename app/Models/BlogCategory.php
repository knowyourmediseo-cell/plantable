<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('uploads/blog-categories/' . $this->image) : null;
    }
}
