<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Notification;
use App\Models\CmsPage;
use App\Models\SchoolSetting;
use App\Models\Message;
use App\Models\Notice;
use App\Models\ForumComment;
use App\Observers\MessageObserver;
use App\Observers\NoticeObserver;
use App\Observers\ForumObserver;

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
        // Register Model Observers
        Message::observe(MessageObserver::class);
        Notice::observe(NoticeObserver::class);
        ForumComment::observe(ForumObserver::class);

        // Share global settings (Cached)
        $settings = Cache::remember('school_settings', 86400, function () {
            return SchoolSetting::first() ?? new SchoolSetting();
        });

        // Apply dynamic timezone and date format
        if ($settings->timezone) {
            date_default_timezone_set($settings->timezone);
            config(['app.timezone' => $settings->timezone]);
        }
        if ($settings->date_format) {
            config(['app.date_format' => $settings->date_format]);
        }

        // Share notifications and global settings with admin master layout
        view()->composer('components.master-layout', function ($view) use ($settings) {
            $view->with('settings', $settings);

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
