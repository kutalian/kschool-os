<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Services\ImageService;

class SettingController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function edit()
    {
        // Get the first settings row or create empty instance
        $settings = SchoolSetting::first() ?? new SchoolSetting();

        // Fetch and group world timezones
        $timezones = [];
        foreach (\DateTimeZone::listIdentifiers() as $timezone) {
            $parts = explode('/', $timezone);
            $region = $parts[0] ?? 'Others';
            if (count($parts) > 1) {
                $timezones[$region][] = $timezone;
            } else {
                $timezones['Others'][] = $timezone;
            }
        }

        return view('admin.settings.general', compact('settings', 'timezones'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_email' => 'nullable|email',
            'logo' => 'nullable|image|max:2048', // 2MB Max
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            'theme_color' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:100',
            'date_format' => 'nullable|string|max:50',
            // Add other validations as needed
        ]);

        $settings = SchoolSetting::first();
        if (!$settings) {
            $settings = new SchoolSetting();
        }

        // Handle File Uploads
        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                // Extract relative path from asset URL if stored that way
                $oldRelativePath = str_replace(asset('storage/'), '', $settings->logo_path);
                $this->imageService->delete($oldRelativePath);
            }
            $path = $this->imageService->process($request->file('logo'), 'uploads/settings', [
                'width' => 400,
                'quality' => 90
            ]);
            $settings->logo_path = asset('storage/' . $path);
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path) {
                $oldRelativePath = str_replace(asset('storage/'), '', $settings->favicon_path);
                $this->imageService->delete($oldRelativePath);
            }
            $path = $this->imageService->process($request->file('favicon'), 'uploads/settings', [
                'width' => 64,
                'height' => 64,
                'format' => 'png' // Keep png for better transparency support in icons
            ]);
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

        Cache::forget('school_settings');

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
