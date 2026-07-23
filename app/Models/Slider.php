<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'mobile_image',
        'button_text',
        'button_link',
        'button_target',
        'text_position',
        'text_color',
        'overlay_color',
        'overlay_opacity',
        'sort_order',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/placeholder.png');
    }

    public function getMobileImageUrlAttribute()
    {
        return $this->mobile_image ? asset('storage/' . $this->mobile_image) : $this->image_url;
    }
}
