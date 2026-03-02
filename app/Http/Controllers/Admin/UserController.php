<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::with('roles')->orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function updateRoles(Request $request, User $user)
    {
        $data = $request->validate([
            'role_ids' => 'array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($data['role_ids'] ?? []);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }
}
