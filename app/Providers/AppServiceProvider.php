<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Notification;
use App\Models\CmsPage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share notifications with all views (or specifically master layout)
        view()->composer('components.master-layout', function ($view) {
            if (auth()->check()) {
                $notifications = Notification::where('user_id', auth()->id())
                    ->latest()
                    ->take(5)
                    ->get();
                $unreadCount = Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();

                $view->with('notifications', $notifications)
                    ->with('unreadCount', $unreadCount);
            }
        });

        // Share dynamic pages with theme layouts (Cached)
        view()->composer('themes.*.layout', function ($view) {
            $customPages = Cache::remember('custom_pages_list', 86400, function () {
                return CmsPage::where('is_active', true)
                    ->orderBy('title')
                    ->get();
            });
            $view->with('customPages', $customPages);
        });
    }
}
