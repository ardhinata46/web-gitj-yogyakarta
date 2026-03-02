<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return Inertia::render('Admin/Members/Index', [
            'members' => $members
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Members/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'church_group' => 'nullable|string',
            'status' => 'required|in:aktif,pasif,pindah,meninggal',
        ]);

        Member::create($validated);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return Inertia::render('Admin/Members/Edit', [
            'member' => $member
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'church_group' => 'nullable|string',
            'status' => 'required|in:aktif,pasif,pindah,meninggal',
        ]);

        $member->update($validated);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
