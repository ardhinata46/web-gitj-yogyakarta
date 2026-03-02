<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devotional extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'verse',
        'author',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
