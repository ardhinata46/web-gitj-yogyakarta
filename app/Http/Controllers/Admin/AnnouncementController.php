<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return Inertia::render('Admin/Announcements/Index', [
            'announcements' => $announcements
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Announcements/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_path' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Warta Jemaat berhasil diterbitkan.');
    }

    public function edit(Announcement $announcement)
    {
        return Inertia::render('Admin/Announcements/Edit', [
            'announcement' => $announcement
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_path' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Warta Jemaat berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Warta Jemaat berhasil dihapus.');
    }
}
