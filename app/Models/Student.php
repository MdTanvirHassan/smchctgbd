<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'name',
        'roll_number',
        'gender',
        'date_of_birth',
        'guardian_name',
        'guardian_contact',
        'address',
        'photo_path',
        'admission_date',
    ];

    public function studentClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
