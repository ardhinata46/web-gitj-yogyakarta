<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Devotional;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DevotionalController extends Controller
{
    public function index()
    {
        $devotionals = Devotional::latest()->paginate(10);
        return Inertia::render('Admin/Devotionals/Index', [
            'devotionals' => $devotionals
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Devotionals/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'verse' => 'nullable|string',
            'author' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Devotional::create($validated);

        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil ditambahkan.');
    }

    public function edit(Devotional $devotional)
    {
        return Inertia::render('Admin/Devotionals/Edit', [
            'devotional' => $devotional
        ]);
    }

    public function update(Request $request, Devotional $devotional)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'verse' => 'nullable|string',
            'author' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $devotional->update($validated);

        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil diperbarui.');
    }

    public function destroy(Devotional $devotional)
    {
        $devotional->delete();

        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil dihapus.');
    }
}
