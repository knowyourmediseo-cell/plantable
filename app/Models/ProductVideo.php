<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'type',
        'video_url',
        'video_file',
        'thumbnail',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
        return $this->thumbnail ? asset('uploads/videos/' . $this->thumbnail) : null;
    }
}
