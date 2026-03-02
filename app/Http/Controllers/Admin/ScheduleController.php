<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::latest()->paginate(10);
        return Inertia::render('Admin/Schedules/Index', [
            'schedules' => $schedules
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Schedules/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        return Inertia::render('Admin/Schedules/Edit', [
            'schedule' => $schedule
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
