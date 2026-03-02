<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vision',
        'mission',
        'history',
        'address',
        'phone',
        'email',
        'google_maps_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'logo_url',
    ];
}
