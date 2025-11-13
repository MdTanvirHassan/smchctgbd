<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name', 'section', 'shift'];

    public function fees()
    {
        return $this->hasOne(Fee::class, 'class_id');
    }
}
