<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'birth_date',
        'church_group',
        'status',
        'is_active',
        'family_id',
        'family_role',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
