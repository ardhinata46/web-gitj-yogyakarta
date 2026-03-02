<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'is_published',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
