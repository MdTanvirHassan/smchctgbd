<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'file_path', 'caption', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
}
