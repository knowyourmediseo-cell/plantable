<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'route',
        'type',
        'reference_id',
        'target',
        'icon',
        'css_class',
        'is_mega_menu',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_mega_menu' => 'boolean',
        'status' => 'boolean',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->where('status', true)->orderBy('sort_order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'reference_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'reference_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getUrlAttribute()
    {
        if ($this->attributes['url']) {
            return $this->attributes['url'];
        }

        if ($this->route) {
            return route($this->route);
        }

        if ($this->type === 'category' && $this->reference_id) {
            $category = Category::find($this->reference_id);
            return $category ? $category->url : '#';
        }

        if ($this->type === 'page' && $this->reference_id) {
            $page = Page::find($this->reference_id);
            return $page ? $page->url : '#';
        }

        return '#';
    }
}
