<?php

namespace Database\Seeders;

use App\Models\Devotional;
use Illuminate\Database\Seeder;

class DevotionalSeeder extends Seeder
{
    public function run(): void
    {
        Devotional::create([
            'date' => date('Y-m-d'),
            'title' => 'Kasih yang Sempurna',
            'content' => 'Kasih Allah tidak pernah berkesudahan. Dia memberikan yang terbaik bagi kita semua. Mari kita hidup dalam kasih-Nya hari ini.',
            'author' => 'Pdt. Sugeng Prayitno',
            'verse' => '1 Yohanes 4:18',
        ]);

        Devotional::create([
            'date' => date('Y-m-d', strtotime('-1 day')),
            'title' => 'Pengharapan di Tengah Badai',
            'content' => 'Saat badai kehidupan datang, jangan takut. Tuhan adalah jangkar kita yang teguh dan kuat.',
            'author' => 'Pdt. Ani Kusuma',
            'verse' => 'Ibrani 6:19',
        ]);
    }
}
