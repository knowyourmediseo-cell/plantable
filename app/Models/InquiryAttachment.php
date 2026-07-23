<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryAttachment extends Model
{
    protected $fillable = [
        'inquiry_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('uploads/inquiries/' . $this->file_path) : null;
    }
}
