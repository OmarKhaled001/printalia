<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use App\Observers\SubscriptionObserver;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Schema;

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

        Schema::defaultStringLength(191);

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->locales(['ar', 'en'])->displayLocale('ar')->visible(false);
        });

        View::share('settings', app(\App\Models\Setting::class));

        $googleFonts = [
            'Cairo',
            'Tajawal',
            'Amiri',
            'Mada',
            'Aref Ruqaa',
            'Changa',
            'El Messiri',
            'Reem Kufi',
            'Baloo Bhaijaan 2',
            'Noto Naskh Arabic',
            'Noto Kufi Arabic',
            'IBM Plex Sans Arabic',
            'Harmattan',
            'Lateef',
            'Scheherazade New',
        ];

        $fontLinks = collect($googleFonts)->map(function ($font) {
            $encoded = urlencode($font);
            return "https://fonts.googleapis.com/css2?family={$encoded}&display=swap";
        })->toArray();

        View::share('googleFontLinks', $fontLinks);

        \App\Models\Subscription::observe(SubscriptionObserver::class);
    }
}
