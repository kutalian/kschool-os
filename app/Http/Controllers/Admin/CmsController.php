<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsTheme;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class CmsController extends Controller
{
    // --- Theme Management ---
    public function themes()
    {
        // Auto-scan themes directory for new folders
        $themeFolders = File::directories(resource_path('views/themes'));
        foreach ($themeFolders as $folder) {
            $directory = basename($folder);
            $manifestPath = "$folder/theme.json";

            if (File::exists($manifestPath)) {
                $theme = CmsTheme::where('directory', $directory)->first();
                if (!$theme) {
                    CmsTheme::create([
                        'directory' => $directory,
                        'name' => $manifest['name'] ?? ucfirst($directory),
                        'version' => $manifest['version'] ?? '1.0',
                        'is_active' => false
                    ]);
                } else {
                    $theme->update([
                        'name' => $manifest['name'] ?? ucfirst($directory),
                        'version' => $manifest['version'] ?? '1.0',
                    ]);
                }
            }
        }

        $themes = CmsTheme::all();
        return view('admin.cms.themes', compact('themes'));
    }

    public function uploadTheme(Request $request)
    {
        $request->validate([
            'theme_zip' => 'required|mimes:zip|max:10240', // 10MB
        ]);

        if ($request->hasFile('theme_zip')) {
            $zip = new ZipArchive;
            $file = $request->file('theme_zip');

            if ($zip->open($file->getRealPath()) === TRUE) {
                // Assume first folder in zip is the theme name
                $themeName = trim($zip->getNameIndex(0), '/'); // Very basic check
                $extractPath = resource_path("views/themes/");

                $zip->extractTo($extractPath);
                $zip->close();

                // Register in DB
                CmsTheme::updateOrCreate(
                    ['directory' => $themeName],
                    [
                        'name' => ucfirst($themeName),
                        'version' => '1.0', // Could read from a manifest.json in future
                        'is_active' => false
                    ]
                );

                return redirect()->back()->with('success', 'Theme uploaded successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to extract ZIP file.');
            }
        }
        return redirect()->back()->with('error', 'No file uploaded.');
    }

    public function activateTheme(CmsTheme $theme)
    {
        $theme->activate();
        return redirect()->back()->with('success', "Theme '{$theme->name}' activated.");
    }

    public function destroy(CmsTheme $theme)
    {
        // 1. Check if active
        if ($theme->is_active) {
            return redirect()->back()->with('error', "Cannot delete the currently active theme.");
        }

        // 2. Delete Directory
        $themePath = resource_path("views/themes/{$theme->directory}");
        if (File::exists($themePath)) {
            File::deleteDirectory($themePath);
        }

        // 3. Delete from DB
        $theme->delete();

        return redirect()->back()->with('success', "Theme '{$theme->name}' deleted successfully.");
    }

    // --- Content Management ---
    public function content()
    {
        $activeTheme = CmsTheme::where('is_active', true)->first();
        $manifest = $activeTheme ? $activeTheme->manifest : [];

        $sections = WebsiteContent::orderBy('display_order')->get();
        return view('admin.cms.content', compact('sections', 'manifest', 'activeTheme'));
    }

    public function updateContent(Request $request, WebsiteContent $content)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'settings' => 'nullable|array' // JSON settings
        ]);

        if ($request->hasFile('image')) {
            if ($content->image_path) {
                Storage::delete($content->image_path);
            }
            $path = $request->file('image')->store('uploads/cms', 'public');
            $content->image_path = asset('storage/' . $path);
        }

        $content->fill($request->except(['image']));

        // Settings are already validated as array, Eloquent casts handles JSON encoding
        $content->save();

        return redirect()->back()->with('success', 'Section updated successfully.');
    }
    // --- Theme Customizer ---
    public function customize()
    {
        $activeTheme = CmsTheme::where('is_active', true)->first();

        if (!$activeTheme) {
            return redirect()->route('cms.themes')->with('error', 'Please activate a theme first.');
        }

        $manifest = $activeTheme->manifest;
        $config = $activeTheme->config ?? [];

        // Fill config with defaults from manifest if missing
        if (isset($manifest['settings'])) {
            foreach ($manifest['settings'] as $groupKey => $group) {
                foreach ($group['fields'] as $fieldKey => $field) {
                    if (!isset($config[$groupKey][$fieldKey])) {
                        $config[$groupKey][$fieldKey] = $field['default'] ?? null;
                    }
                }
            }
        }

        return view('admin.cms.customize', compact('activeTheme', 'config', 'manifest'));
    }

    public function updateCustomizer(Request $request)
    {
        $activeTheme = CmsTheme::where('is_active', true)->firstOrFail();
        $manifest = $activeTheme->manifest;

        // Dynamic Validation could be added here based on manifest
        $request->validate([
            'config' => 'required|array',
            'logo' => 'nullable|image|max:2048',
        ]);

        $config = $request->input('config');

        // Handle Image Uploads dynamically based on manifest field types
        foreach ($manifest['settings'] ?? [] as $groupKey => $group) {
            foreach ($group['fields'] as $fieldKey => $field) {
                if ($field['type'] === 'image' && $request->hasFile("images.$groupKey.$fieldKey")) {
                    $path = $request->file("images.$groupKey.$fieldKey")->store('uploads/branding', 'public');
                    $config[$groupKey][$fieldKey] = asset('storage/' . $path);
                }
            }
        }

        $activeTheme->config = $config;
        $activeTheme->save();

        return redirect()->back()->with('success', 'Theme settings updated.');
    }
}
