<?php

namespace Database\Seeders;

use App\Models\ChurchProfile;
use Illuminate\Database\Seeder;

class ChurchProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChurchProfile::create([
            'name' => 'GITJ Yogyakarta',
            'vision' => 'Menjadi gereja yang bertumbuh dalam iman, kasih, dan pelayanan yang berdampak bagi masyarakat.',
            'mission' => "1. Meningkatkan kualitas ibadah dan kehidupan rohani jemaat.\n2. Mengembangkan pelayanan kasih bagi sesama.\n3. Membangun kebersamaan dan persaudaraan yang rukun.",
            'history' => 'Gereja Injili di Tanah Jawa (GITJ) Yogyakarta telah melayani masyarakat di Yogyakarta selama bertahun-tahun dengan semangat kasih Kristus.',
            'address' => 'Jl. Kaliurang KM 5, Yogyakarta, Indonesia',
            'phone' => '+62 274 123456',
            'email' => 'info@gitjyogyakarta.org',
            'google_maps_url' => 'https://goo.gl/maps/example',
            'facebook_url' => 'https://facebook.com/gitjyogyakarta',
            'instagram_url' => 'https://instagram.com/gitjyogyakarta',
            'youtube_url' => 'https://youtube.com/gitjyogyakarta',
            'logo_url' => 'https://images.unsplash.com/photo-1544427928-c49cdfebf19a?q=80&w=2600&auto=format&fit=crop',
        ]);
    }
}
