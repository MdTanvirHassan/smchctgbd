<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'shift',
        'type',
        'routine_title',
        'file_path',
        'file_type',
        'published_date',
        'is_active'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
