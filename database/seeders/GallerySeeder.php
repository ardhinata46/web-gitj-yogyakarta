<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        Gallery::create([
            'title' => 'Natal Jemaat 2025',
            'description' => 'Perayaan Natal bersama jemaat GITJ Yogyakarta dengan penuh suka cita.',
            'image_url' => 'https://images.unsplash.com/photo-1543589077-47d81606c1bf?q=80&w=2600&auto=format&fit=crop',
            'category' => 'Ibadah',
            'event_date' => '2025-12-25',
        ]);

        Gallery::create([
            'title' => 'Aksi Sosial Peduli Sesama',
            'description' => 'Kegiatan pembagian sembako untuk masyarakat sekitar gereja.',
            'image_url' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2600&auto=format&fit=crop',
            'category' => 'Sosial',
            'event_date' => '2026-01-10',
        ]);

        Gallery::create([
            'title' => 'Lomba Sekolah Minggu',
            'description' => 'Keseruan anak-anak sekolah minggu dalam lomba menggambar.',
            'image_url' => 'https://images.unsplash.com/photo-1510074377623-8cf13fb86c08?q=80&w=2600&auto=format&fit=crop',
            'category' => 'Sekolah Minggu',
            'event_date' => '2026-02-01',
        ]);
    }
}
