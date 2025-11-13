<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'class_id',
        'admission_fee',
        'monthly_fee',
        'total_seats',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
