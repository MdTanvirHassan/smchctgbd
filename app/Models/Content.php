<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'file_path',
        'link_url',
        'start_date',
        'end_date',
        'is_published'
    ];

    public static function getLatestPublished($type, $limit = 5)
    {
        return self::where('type', $type)
            ->where('is_published', 1)
            ->when($type === 'important_notice', function ($query) {
                $query->where('end_date', '>=', now());
            })
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }
}
