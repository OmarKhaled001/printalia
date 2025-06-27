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

        // --- Start of the fix ---
        // We check if the 'settings' table exists before trying to access it.
        // This prevents errors when running commands like `php artisan migrate`
        // on a fresh database where the table hasn't been created yet.
        if (Schema::hasTable('settings')) {
            LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
                $switch->locales(['ar', 'en'])->displayLocale('ar')->visible(false);
            });

            // This line is now safe because it will only run if the 'settings' table exists.
            View::share('settings', app(\App\Models\Setting::class));
        }
        // --- End of the fix ---


        // This font logic is safe because it does not depend on the database.
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


        // As a good practice, we'll also wrap the observer registration in a similar check.
        if (Schema::hasTable('subscriptions')) {
            \App\Models\Subscription::observe(SubscriptionObserver::class);
        }
    }
}
