<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrayerRequestController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/PrayerRequests/Index', [
            'items' => PrayerRequest::latest()->get()
        ]);
    }

    public function updateStatus(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,prayed_for,archived',
        ]);

        $prayerRequest->update($validated);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function destroy(PrayerRequest $prayerRequest)
    {
        $prayerRequest->delete();
        return redirect()->back()->with('success', 'Prayer request deleted successfully.');
    }
}
