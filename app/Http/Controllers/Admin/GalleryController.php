<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Gallery/Index', [
            'items' => Gallery::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Gallery/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|url',
            'category' => 'nullable|string|max:100',
            'event_date' => 'nullable|date',
        ]);

        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return Inertia::render('Admin/Gallery/Edit', [
            'item' => $gallery
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|url',
            'category' => 'nullable|string|max:100',
            'event_date' => 'nullable|date',
        ]);

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
