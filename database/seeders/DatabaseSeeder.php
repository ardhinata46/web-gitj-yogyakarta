<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin GITJ',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'role' => 'super_admin',
            ]
        );

        $this->call([
            ChurchProfileSeeder::class ,
            SliderSeeder::class ,
            MemberSeeder::class ,
            TransactionSeeder::class ,
            AnnouncementSeeder::class ,
            DevotionalSeeder::class ,
            ScheduleSeeder::class ,
            GallerySeeder::class ,
            AuditLogSeeder::class ,
            RolePermissionSeeder::class ,
        ]);
    }
}
