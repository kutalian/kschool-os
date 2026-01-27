<?php

namespace App\Http\Controllers;

use App\Models\SchoolSetting;
use App\Models\CmsTheme;
use App\Models\WebsiteContent;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Get School Settings
        $settings = Cache::remember('school_settings', 86400, function () {
            return SchoolSetting::firstOrNew();
        });

        // 2. Get Active Theme
        $activeTheme = Cache::remember('active_theme', 86400, function () {
            return CmsTheme::where('is_active', true)->first();
        });

        // Fallback to default if no theme is active
        $themeDirectory = $activeTheme ? $activeTheme->directory : 'default';

        // 3. Get Homepage Content
        $sections = Cache::remember('homepage_content', 86400, function () {
            return WebsiteContent::where('is_active', true)
                ->orderBy('display_order')
                ->get();
        });

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
        $settings = Cache::remember('school_settings', 86400, function () {
            return SchoolSetting::firstOrNew();
        });
        $activeTheme = Cache::remember('active_theme', 86400, function () {
            return CmsTheme::where('is_active', true)->first();
        });

        if (!$activeTheme)
            return abort(404);

        $viewPath = "themes.{$activeTheme->directory}.{$slug}";

        if (!View::exists($viewPath)) {
            // Check Database for custom page (Cached)
            $page = Cache::remember("cms_page_{$slug}", 86400, function () use ($slug) {
                return CmsPage::where('slug', $slug)->where('is_active', true)->first();
            });

            if (!$page) {
                return abort(404);
            }

            $themeConfig = $activeTheme->config ?? [];
            $manifest = $activeTheme->manifest;

            // Try specific template or fallback to generic 'page'
            $template = "themes.{$activeTheme->directory}." . ($page->template ?? 'page');
            if (!View::exists($template)) {
                $template = "themes.{$activeTheme->directory}.page";
            }

            // If even generic page doesn't exist, we might have a problem
            if (!View::exists($template)) {
                return view('welcome', ['content' => $page->content]); // very basic fallback
            }

            $teachers = \App\Models\Staff::take(4)->get();
            $classes = \App\Models\ClassRoom::take(6)->get();

            return view($template, compact('settings', 'activeTheme', 'themeConfig', 'manifest', 'teachers', 'classes', 'page'));
        }

        $themeConfig = $activeTheme->config ?? [];
        $manifest = $activeTheme->manifest;

        // Contextual data based on page
        $teachers = ($slug === 'teachers') ? \App\Models\Staff::all() : \App\Models\Staff::take(4)->get();
        $classes = ($slug === 'classes') ? \App\Models\ClassRoom::all() : \App\Models\ClassRoom::take(6)->get();

        return view($viewPath, compact('settings', 'activeTheme', 'themeConfig', 'manifest', 'teachers', 'classes'));
    }
}
