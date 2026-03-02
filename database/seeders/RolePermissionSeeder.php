<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'secretary' => 'Sekretaris',
            'treasurer' => 'Bendahara',
            'editor' => 'Editor',
            'roles_manager' => 'Role Manager',
            'user' => 'User',
        ];

        $permissions = [
            'members.manage',
            'families.manage',
            'schedules.manage',
            'prayer_requests.manage',
            'reports.view',
            'profile.manage',
            'transactions.manage',
            'announcements.manage',
            'devotionals.manage',
            'gallery.manage',
            'sliders.manage',
            'audit_logs.view',
            'roles.manage',
        ];

        $roleModels = [];
        foreach ($roles as $name => $label) {
            $roleModels[$name] = Role::firstOrCreate(
                ['name' => $name],
                ['label' => $label]
            );
        }

        $permissionModels = [];
        foreach ($permissions as $perm) {
            $permissionModels[$perm] = Permission::firstOrCreate(['name' => $perm], ['label' => $perm]);
        }

        $roleModels['secretary']->permissions()->sync([
            $permissionModels['members.manage']->id,
            $permissionModels['families.manage']->id,
            $permissionModels['schedules.manage']->id,
            $permissionModels['prayer_requests.manage']->id,
            $permissionModels['reports.view']->id,
            $permissionModels['profile.manage']->id,
            $permissionModels['audit_logs.view']->id,
        ]);

        $roleModels['treasurer']->permissions()->sync([
            $permissionModels['transactions.manage']->id,
            $permissionModels['reports.view']->id,
        ]);

        $roleModels['editor']->permissions()->sync([
            $permissionModels['announcements.manage']->id,
            $permissionModels['devotionals.manage']->id,
            $permissionModels['gallery.manage']->id,
            $permissionModels['sliders.manage']->id,
        ]);

        $roleModels['roles_manager']->permissions()->sync([
            $permissionModels['roles.manage']->id,
        ]);

        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->roles()->syncWithoutDetaching([$roleModels['super_admin']->id]);
        }
    }
}
