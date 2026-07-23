<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'video_url',
        'video_file',
        'thumbnail',
        'duration',
        'views',
        'sort_order',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getEmbedUrlAttribute()
    {
        if ($this->type === 'youtube' && $this->video_url) {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $this->video_url, $matches);
            $videoId = $matches[1] ?? null;
            return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
        } elseif ($this->type === 'vimeo' && $this->video_url) {
            preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
            $videoId = $matches[1] ?? null;
            return $videoId ? "https://player.vimeo.com/video/{$videoId}" : null;
        }
        return null;
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/placeholder.png');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
