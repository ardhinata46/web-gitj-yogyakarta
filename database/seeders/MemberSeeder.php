<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'address' => 'Sleman, Yogyakarta',
            'gender' => 'L',
            'church_group' => 'Wilayah Utara',
            'is_active' => true,
        ]);

        Member::create([
            'name' => 'Sari Wijaya',
            'email' => 'sari@example.com',
            'phone' => '08198765432',
            'address' => 'Bantul, Yogyakarta',
            'gender' => 'P',
            'church_group' => 'Wilayah Selatan',
            'is_active' => true,
        ]);

        Member::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@example.com',
            'phone' => '08567891234',
            'address' => 'Kota Yogyakarta',
            'gender' => 'L',
            'church_group' => 'Wilayah Tengah',
            'is_active' => true,
        ]);
    }
}
