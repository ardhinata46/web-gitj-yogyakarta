<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kk_number',
        'address',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function headOfFamily()
    {
        return $this->members()->where('family_role', 'Kepala Keluarga')->first();
    }
}
