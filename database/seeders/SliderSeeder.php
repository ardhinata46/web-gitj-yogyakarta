<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slider::create([
            'title' => 'Selamat Datang di GITJ Yogyakarta',
            'subtitle' => 'Rumah bagi pertumbuhan rohani dan persaudaraan sejati.',
            'image_url' => 'https://images.unsplash.com/photo-1438232992991-995b7058bbb3?q=80&w=2600&auto=format&fit=crop',
            'cta_text' => 'Lihat Jadwal Ibadah',
            'cta_link' => '/jadwal',
            'order' => 1,
            'is_active' => true,
        ]);

        Slider::create([
            'title' => 'Bertumbuh Bersama dalam Kasih',
            'subtitle' => 'Bergabunglah dalam berbagai kegiatan pelayanan kami.',
            'image_url' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2600&auto=format&fit=crop',
            'cta_text' => 'Kontak Kami',
            'cta_link' => '/kontak',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
