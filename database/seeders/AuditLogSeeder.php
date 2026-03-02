<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $entries = [
            [
                'action' => 'admin.members.store',
                'method' => 'POST',
                'url' => '/admin/members',
                'route_name' => 'admin.members.store',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'payload' => [
                    'name' => 'Dummy Member',
                    'phone' => '08123456789',
                ],
            ],
            [
                'action' => 'admin.schedules.store',
                'method' => 'POST',
                'url' => '/admin/schedules',
                'route_name' => 'admin.schedules.store',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'payload' => [
                    'title' => 'Ibadah Minggu',
                    'time' => '08:00',
                ],
            ],
            [
                'action' => 'admin.announcements.update',
                'method' => 'PATCH',
                'url' => '/admin/announcements/1',
                'route_name' => 'admin.announcements.update',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'payload' => [
                    'title' => 'Update Warta',
                ],
            ],
        ];

        foreach ($entries as $entry) {
            AuditLog::create([
                'user_id' => $user->id,
                ...$entry,
            ]);
        }
    }
}
