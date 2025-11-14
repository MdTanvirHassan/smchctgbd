<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'video_path', 'video_url', 'caption', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(VideoGalleryCategory::class, 'category_id');
    }
}

