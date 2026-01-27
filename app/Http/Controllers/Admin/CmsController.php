<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsTheme;
use App\Models\WebsiteContent;
use App\Models\SchoolSetting;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Services\ImageService;
use ZipArchive;

class CmsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    // --- Theme Management ---
    public function themes()
    {
        // Auto-scan themes directory for new folders
        $themeFolders = File::directories(resource_path('views/themes'));
        foreach ($themeFolders as $folder) {
            $directory = basename($folder);
            $manifestPath = "$folder/theme.json";

            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
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
                Cache::forget("theme_manifest_{$directory}");
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

                Cache::forget("theme_manifest_{$themeName}");
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
                $oldRelativePath = str_replace(asset('storage/'), '', $content->image_path);
                $this->imageService->delete($oldRelativePath);
            }
            $path = $this->imageService->process($request->file('image'), 'uploads/cms', [
                'width' => 1200, // Reasonable max width for section images
                'quality' => 85
            ]);
            $content->image_path = asset('storage/' . $path);
        }

        $content->fill($request->except(['image']));

        // Settings are already validated as array, Eloquent casts handles JSON encoding
        $content->save();

        Cache::forget('homepage_content');

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

        // Load additional data for unified management
        $settings = SchoolSetting::first() ?? new SchoolSetting();
        $sections = WebsiteContent::orderBy('display_order')->get();
        $pages = CmsPage::all();

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

        return view('admin.cms.customize', compact('activeTheme', 'config', 'manifest', 'settings', 'sections', 'pages'));
    }

    public function updateCustomizer(Request $request)
    {
        $activeTheme = CmsTheme::where('is_active', true)->firstOrFail();
        $manifest = $activeTheme->manifest;

        // 1. Handle Master Identity (SchoolSetting) & Sync with Theme Config
        if ($request->has('identity')) {
            $settings = SchoolSetting::first() ?? new SchoolSetting();
            $identityData = $request->input('identity');
            $config = $activeTheme->config ?? [];

            $settings->school_name = $identityData['school_name'] ?? $settings->school_name;
            $settings->tagline = $identityData['tagline'] ?? $settings->tagline;
            $settings->school_email = $identityData['school_email'] ?? $settings->school_email;

            // Sync with Theme Config if theme defines these identity keys
            if (isset($manifest['settings']['identity'])) {
                $config['identity']['site_title'] = $settings->school_name;
                $config['identity']['tagline'] = $settings->tagline;
            }

            if ($request->hasFile('identity_logo')) {
                if ($settings->logo_path) {
                    $oldPath = str_replace(asset('storage/'), '', $settings->logo_path);
                    $this->imageService->delete($oldPath);
                }
                $path = $this->imageService->process($request->file('identity_logo'), 'uploads/settings');
                $settings->logo_path = asset('storage/' . $path);

                // Sync logo with theme if applicable
                if (isset($manifest['settings']['identity']['fields']['logo_url'])) {
                    $config['identity']['logo_url'] = $settings->logo_path;
                }
            }

            if ($request->hasFile('identity_favicon')) {
                if ($settings->favicon_path) {
                    $oldPath = str_replace(asset('storage/'), '', $settings->favicon_path);
                    $this->imageService->delete($oldPath);
                }
                $path = $this->imageService->process($request->file('identity_favicon'), 'uploads/settings', ['width' => 64, 'height' => 64]);
                $settings->favicon_path = asset('storage/' . $path);
            }

            $settings->save();
            $activeTheme->config = $config;
            $activeTheme->save();

            Cache::forget('school_settings');
            Cache::forget('active_theme');
        }

        // 2. Handle Theme Content Sections (WebsiteContent)
        if ($request->has('sections')) {
            foreach ($request->input('sections') as $id => $sectionData) {
                $section = WebsiteContent::find($id);
                if ($section) {
                    $section->update($sectionData);

                    // Handle section image if uploaded
                    if ($request->hasFile("section_images.$id")) {
                        if ($section->image_path) {
                            $oldPath = str_replace(asset('storage/'), '', $section->image_path);
                            $this->imageService->delete($oldPath);
                        }
                        $path = $this->imageService->process($request->file("section_images.$id"), 'uploads/cms');
                        $section->image_path = asset('storage/' . $path);
                        $section->save();
                    }
                }
            }
            Cache::forget('homepage_content');
        }

        // 3. Handle Theme Config & Images
        if ($request->has('config')) {
            $config = $request->input('config');

            foreach ($manifest['settings'] ?? [] as $groupKey => $group) {
                foreach ($group['fields'] as $fieldKey => $field) {
                    if ($field['type'] === 'image' && $request->hasFile("images.$groupKey.$fieldKey")) {
                        if (isset($config[$groupKey][$fieldKey])) {
                            $oldPath = str_replace(asset('storage/'), '', $config[$groupKey][$fieldKey]);
                            $this->imageService->delete($oldPath);
                        }
                        $path = $this->imageService->process($request->file("images.$groupKey.$fieldKey"), 'uploads/branding');
                        $config[$groupKey][$fieldKey] = asset('storage/' . $path);
                    }
                }
            }

            $activeTheme->config = $config;
            $activeTheme->save();
            Cache::forget('active_theme');
        }

        return redirect()->back()->with('success', 'Master customization successfully applied.');
    }
}
