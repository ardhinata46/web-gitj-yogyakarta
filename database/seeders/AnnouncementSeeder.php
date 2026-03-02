<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title' => 'Retreat Pemuda 2026',
            'content' => 'Bergabunglah dalam retreat pemuda tahun ini dengan tema "Bertumbuh dalam Kristus". Pendaftaran dibuka hingga akhir bulan ini.',
            'is_published' => true,
        ]);

        Announcement::create([
            'title' => 'Jadwal Ibadah Paskah 2026',
            'content' => 'Berikut adalah rangkaian jadwal ibadah menyambut Paskah. Harap jemaat memperhatikan jam pelaksanaan.',
            'is_published' => true,
        ]);

        Announcement::create([
            'title' => 'Renovasi Gedung Gereja',
            'content' => 'Gereja akan melakukan renovasi area parkir mulai minggu depan. Jemaat harap memaklumi ketidaknyamanan ini.',
            'is_published' => true,
        ]);
    }
}
