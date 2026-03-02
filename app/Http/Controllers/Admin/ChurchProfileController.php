<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChurchProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChurchProfileController extends Controller
{
    public function edit()
    {
        return Inertia::render('Admin/Profile/Edit', [
            'profile' => ChurchProfile::first() ?? new ChurchProfile()
        ]);
    }

    public function update(Request $request)
    {
        $profile = ChurchProfile::first() ?? new ChurchProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'history' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'google_maps_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'logo_url' => 'nullable|url',
        ]);

        if ($profile->exists) {
            $profile->update($validated);
        }
        else {
            ChurchProfile::create($validated);
        }

        return redirect()->back()->with('success', 'Church profile updated successfully.');
    }
}
