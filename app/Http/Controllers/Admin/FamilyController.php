<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FamilyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Families/Index', [
            'families' => Family::withCount('members')->latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Families/Create', [
            'members' => Member::whereNull('family_id')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kk_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id'
        ]);

        $family = Family::create([
            'name' => $validated['name'],
            'kk_number' => $validated['kk_number'],
            'address' => $validated['address'],
        ]);

        Member::whereIn('id', $validated['member_ids'])->update(['family_id' => $family->id]);

        return redirect()->route('admin.families.index')->with('success', 'Family created successfully.');
    }

    public function edit(Family $family)
    {
        return Inertia::render('Admin/Families/Edit', [
            'family' => $family->load('members'),
            'available_members' => Member::whereNull('family_id')->get()
        ]);
    }

    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kk_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'member_ids' => 'nullable|array',
            'member_ids.*' => 'exists:members,id'
        ]);

        $family->update([
            'name' => $validated['name'],
            'kk_number' => $validated['kk_number'],
            'address' => $validated['address'],
        ]);

        if (isset($validated['member_ids'])) {
            // First detach old members (optional, depends on logic, but usually we just add)
            // For now, let's just allow adding
            Member::whereIn('id', $validated['member_ids'])->update(['family_id' => $family->id]);
        }

        return redirect()->route('admin.families.index')->with('success', 'Family updated successfully.');
    }

    public function destroy(Family $family)
    {
        // Detach members before deleting
        Member::where('family_id', $family->id)->update(['family_id' => null, 'family_role' => null]);
        $family->delete();
        return redirect()->route('admin.families.index')->with('success', 'Family deleted and members detached.');
    }

    public function addMember(Request $request, Family $family)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'family_role' => 'required|string|max:50',
        ]);

        Member::where('id', $validated['member_id'])->update([
            'family_id' => $family->id,
            'family_role' => $validated['family_role']
        ]);

        return redirect()->back()->with('success', 'Member added to family.');
    }

    public function removeMember(Request $request, Family $family, Member $member)
    {
        if ($member->family_id === $family->id) {
            $member->update(['family_id' => null, 'family_role' => null]);
        }
        return redirect()->back()->with('success', 'Member removed from family.');
    }
}
