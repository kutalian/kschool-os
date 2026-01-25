<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
                $notifications = \App\Models\Notification::where('user_id', auth()->id())
                    ->latest()
                    ->take(5)
                    ->get();
                $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();

                $view->with('notifications', $notifications)
                    ->with('unreadCount', $unreadCount);
            }
        });
    }
}
