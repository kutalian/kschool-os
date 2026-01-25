<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        // Get the first settings row or create empty instance
        $settings = SchoolSetting::first() ?? new SchoolSetting();
        return view('admin.settings.general', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_email' => 'nullable|email',
            'logo' => 'nullable|image|max:2048', // 2MB Max
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            'theme_color' => 'nullable|string|max:20',
            // Add other validations as needed
        ]);

        $settings = SchoolSetting::first();
        if (!$settings) {
            $settings = new SchoolSetting();
        }

        // Handle File Uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path) {
                Storage::delete($settings->logo_path);
            }
            $path = $request->file('logo')->store('uploads/settings', 'public');
            $settings->logo_path = asset('storage/' . $path);
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path) {
                Storage::delete($settings->favicon_path);
            }
            $path = $request->file('favicon')->store('uploads/settings', 'public');
            $settings->favicon_path = asset('storage/' . $path);
        }

        // Update basic fields
        $settings->fill($request->except(['logo', 'favicon', 'social_links']));

        // Handle JSON fields manually if needed (Social Links)
        // Assuming form sends array: social_links[facebook], social_links[twitter]
        if ($request->has('social_links')) {
            $settings->social_links = $request->input('social_links');
        }

        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
