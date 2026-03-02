<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $allPermissions = Permission::withCount('roles')->orderBy('name')->get();
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return Inertia::render('Admin/RolesPermissions/Index', [
            'roles' => $roles,
            'permissions' => $allPermissions,
            'users' => $users,
        ]);
    }

    public function update(Request $request)
    {
        $roles = $request->input('roles', []);

        if (!is_array($roles)) {
            return back()->with('error', 'Format data tidak valid.');
        }

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName], ['label' => $roleName]);
            $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->all();
            $role->permissions()->sync($permissionIds);
        }

        return back()->with('success', 'Role & permission berhasil diperbarui.');
    }

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|alpha_dash|unique:roles,name',
            'label' => 'nullable|string|max:100',
        ]);

        Role::create($data);

        return back()->with('success', 'Role berhasil ditambahkan.');
    }

    public function updateRole(Request $request, Role $role)
    {
        if ($role->name === 'super_admin') {
            return back()->with('error', 'Role super_admin tidak bisa diubah.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:50|alpha_dash|unique:roles,name,' . $role->id,
            'label' => 'nullable|string|max:100',
        ]);

        $role->update($data);

        return back()->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyRole(Role $role)
    {
        if ($role->name === 'super_admin') {
            return back()->with('error', 'Role super_admin tidak bisa dihapus.');
        }

        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();

        return back()->with('success', 'Role berhasil dihapus.');
    }

    public function storePermission(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80|alpha_dash|unique:permissions,name',
            'label' => 'nullable|string|max:100',
        ]);

        Permission::create($data);

        return back()->with('success', 'Permission berhasil ditambahkan.');
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80|alpha_dash|unique:permissions,name,' . $permission->id,
            'label' => 'nullable|string|max:100',
        ]);

        $permission->update($data);

        return back()->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroyPermission(Permission $permission)
    {
        if ($permission->roles()->exists()) {
            return back()->with('error', 'Permission sedang digunakan oleh role. Hapus relasi dulu.');
        }

        $permission->roles()->detach();
        $permission->delete();

        return back()->with('success', 'Permission berhasil dihapus.');
    }

    public function assignRoleToUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_ids' => 'array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($data['user_id']);
        $user->roles()->sync($data['role_ids'] ?? []);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }

}
