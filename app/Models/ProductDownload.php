<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDownload extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'file',
        'file_type',
        'file_size',
        'downloads',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFileUrlAttribute()
    {
        return $this->file ? asset('uploads/downloads/' . $this->file) : null;
    }

    public function incrementDownloads()
    {
        $this->increment('downloads');
    }
}
