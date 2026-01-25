<?php

namespace App\Http\Controllers;

use App\Models\SchoolSetting;
use App\Models\CmsTheme;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Get School Settings (Shared globally usually, but fetching here for clarity)
        $settings = SchoolSetting::firstOrNew();

        // 2. Get Active Theme
        $activeTheme = CmsTheme::where('is_active', true)->first();

        // Fallback to default if no theme is active (shouldn't happen if seeded correctly)
        $themeDirectory = $activeTheme ? $activeTheme->directory : 'default';

        // 3. Get Homepage Content
        $sections = WebsiteContent::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        // 4. Check if view exists, otherwise fallback
        $viewPath = "themes.{$themeDirectory}.home";
        if (!View::exists($viewPath)) {
            // Fallback content or view
            return view('welcome');
        }

        $themeConfig = $activeTheme ? ($activeTheme->config ?? []) : [];
        $manifest = $activeTheme ? $activeTheme->manifest : [];

        $teachers = \App\Models\Staff::inRandomOrder()->take(4)->get();
        $classes = \App\Models\ClassRoom::orderBy('name')->take(18)->get();

        return view($viewPath, compact('settings', 'sections', 'teachers', 'classes', 'themeConfig', 'manifest', 'activeTheme'));
    }

    public function page($slug)
    {
        $settings = SchoolSetting::firstOrNew();
        $activeTheme = CmsTheme::where('is_active', true)->first();

        if (!$activeTheme)
            return abort(404);

        $viewPath = "themes.{$activeTheme->directory}.{$slug}";

        if (!View::exists($viewPath)) {
            return abort(404);
        }

        $themeConfig = $activeTheme->config ?? [];
        $manifest = $activeTheme->manifest;

        // Contextual data based on page
        $teachers = ($slug === 'teachers') ? \App\Models\Staff::all() : \App\Models\Staff::take(4)->get();
        $classes = ($slug === 'classes') ? \App\Models\ClassRoom::all() : \App\Models\ClassRoom::take(6)->get();

        return view($viewPath, compact('settings', 'activeTheme', 'themeConfig', 'manifest', 'teachers', 'classes'));
    }
}
