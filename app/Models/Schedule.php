<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'time',
        'location',
        'description',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
