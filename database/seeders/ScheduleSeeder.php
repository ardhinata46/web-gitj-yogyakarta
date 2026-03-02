<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schedule::create([
            'title' => 'Ibadah Umum Pagi 1',
            'time' => Carbon::now()->next(Carbon::SUNDAY)->setTime(7, 0, 0),
            'location' => 'Gedung Utama',
            'description' => 'Ibadah raya minggu pagi sesi pertama.',
        ]);

        Schedule::create([
            'title' => 'Ibadah Umum Pagi 2',
            'time' => Carbon::now()->next(Carbon::SUNDAY)->setTime(9, 0, 0),
            'location' => 'Gedung Utama',
            'description' => 'Ibadah raya minggu pagi sesi kedua.',
        ]);

        Schedule::create([
            'title' => 'Ibadah Doa & PA',
            'time' => Carbon::now()->next(Carbon::THURSDAY)->setTime(18, 0, 0),
            'location' => 'Aula Kecil',
            'description' => 'Ibadah doa dan pemahaman alkitab rutin hari kamis.',
        ]);
    }
}
