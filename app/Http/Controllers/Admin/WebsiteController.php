<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use App\Models\CmsTheme;
use App\Models\WebsiteContent;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display the Website Manager dashboard.
     */
    public function index()
    {
        $settings = SchoolSetting::first() ?? new SchoolSetting();
        $activeTheme = CmsTheme::where('is_active', true)->first();
        $contentCount = WebsiteContent::count();
        $pagesCount = CmsPage::count();

        // Stats for the dashboard
        $stats = [
            'identity' => [
                'name' => $settings->school_name ?? 'Not Set',
                'has_logo' => !empty($settings->logo_path),
            ],
            'theme' => [
                'name' => $activeTheme ? $activeTheme->name : 'None',
                'version' => $activeTheme ? ($activeTheme->manifest['version'] ?? '1.0.0') : '-',
            ],
            'content' => [
                'sections' => $contentCount,
            ],
            'pages' => [
                'count' => $pagesCount,
            ]
        ];

        return view('admin.website.index', compact('stats', 'settings', 'activeTheme'));
    }
}
