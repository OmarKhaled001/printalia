<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use App\Observers\SubscriptionObserver;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->locales(['ar', 'en'])->displayLocale('ar')->visible(false);
        });

        View::share('settings', app(\App\Models\Setting::class));

        \App\Models\Subscription::observe(SubscriptionObserver::class);
    }
}
