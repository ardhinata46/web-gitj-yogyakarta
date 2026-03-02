<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Devotional;
use App\Models\Slider;
use App\Models\ChurchProfile;
use App\Models\Schedule;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Web/Home', [
            'sliders' => Slider::where('is_active', true)->orderBy('order')->get(),
            'profile' => ChurchProfile::first(),
            'announcements' => Announcement::published()->latest()->take(3)->get(),
            'devotional' => Devotional::whereDate('date', today())->first() ?? Devotional::latest()->first(),
        ]);
    }

    public function devotionals()
    {
        return Inertia::render('Web/Devotionals', [
            'devotionals' => Devotional::latest()->paginate(10)
        ]);
    }

    public function announcements()
    {
        return Inertia::render('Web/Announcements', [
            'announcements' => Announcement::published()->latest()->paginate(9)
        ]);
    }

    public function schedules()
    {
        return Inertia::render('Web/Schedules', [
            'schedules' => Schedule::all()
        ]);
    }

    public function gallery()
    {
        return Inertia::render('Web/Gallery', [
            'items' => \App\Models\Gallery::latest()->get()
        ]);
    }

    public function prayerRequest()
    {
        return Inertia::render('Web/PrayerRequest');
    }

    public function storePrayerRequest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'request' => 'required|string',
            'is_anonymous' => 'required|boolean',
        ]);

        \App\Models\PrayerRequest::create($validated);

        return redirect()->back()->with('success', 'Permohonan doa Anda telah terkirim. Tuhan memberkati.');
    }
}
