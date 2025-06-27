<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Setting;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $primaryColor = '#6366f1';
        $fontFamily = 'Inter';

        // 2. Only query the database for settings if the 'settings' table exists.
        //    This prevents errors during `php artisan migrate`.
        if (Schema::hasTable('settings')) {
            $primaryColorFromDb = Setting::where('key', 'primary_color')->value('value');
            if ($primaryColorFromDb) {
                $primaryColor = $primaryColorFromDb;
            }

            $fontFamilyFromDb = Setting::where('key', 'font_family')->value('value');
            if ($fontFamilyFromDb) {
                $fontFamily = $fontFamilyFromDb;
            }
        }
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('web')
            ->brandLogo(asset('logo.png'))->brandLogoHeight('2.2rem')
            ->font($fontFamily)
            ->colors([
                'primary' =>  $primaryColor,
            ])
            ->renderHook('head.start', function () {
                $fonts = array_unique([
                    Setting::where('key', 'font_family')->value('value') ?? 'Inter',
                ]);

                $fontLinks = collect($fonts)->map(function ($font) {
                    $encoded = urlencode($font);
                    return "<link href=\"https://fonts.googleapis.com/css2?family={$encoded}&display=swap\" rel=\"stylesheet\">";
                })->implode("\n");

                return <<<HTML
                    {$fontLinks}
                    <link rel="stylesheet" href="{$GLOBALS['app']['url']}/dynamic-styles.css">
                HTML;
            })

            ->databaseNotifications()
            ->databaseNotificationsPolling('3s')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\Setting::class,
            ])
            ->plugins([
                FilamentEditProfilePlugin::make()->shouldRegisterNavigation(false)
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => Auth::user('admin')->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                    //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
                    ->visible(function (): bool {
                        return Auth::user('admin')->exists();
                    }),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
