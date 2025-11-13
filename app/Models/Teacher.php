<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_path',
        'designation_id',
        'qualification',
        'biography',
        'join_date'
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
