<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Setting;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Filament\Navigation\NavigationGroup;
use Orion\FilamentGreeter\GreeterPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\EnsureDesignerIsVerified;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\Designer\Resources\OrderResource;
use App\Filament\Designer\Resources\DesignResource;
use App\Filament\Designer\Resources\CustomerResource;
use App\Filament\Designer\Resources\RegisterDesigner;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Designer\Resources\TransactionResource;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class DesignerPanelProvider extends PanelProvider
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
            ->id('designer')
            ->path('designer')
            ->login()
            ->registration(RegisterDesigner::class)
            // ->profile()
            ->authGuard('designer')
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
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    ...Dashboard::getNavigationItems(),
                    ...DesignResource::getNavigationItems(),
                    ...OrderResource::getNavigationItems(),
                    ...TransactionResource::getNavigationItems(),
                    ...CustomerResource::getNavigationItems(),
                ]);
            })
            ->databaseNotificationsPolling('1s')
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => Auth::user('designer')->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                    //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
                    ->visible(function (): bool {
                        return Auth::user('designer')->exists();
                    }),
            ])
            ->plugins([
                FilamentEditProfilePlugin::make(),

                TableLayoutTogglePlugin::make(),
                GreeterPlugin::make()
                    ->message('مرحباً بك،')
                    ->name(text: fn() => Auth::user('designer')->name)
                    ->title(text: fn() => "اشتراكك الحالي:" . Auth::user('designer')->activeSubscription()?->plan->name)

                    ->action(
                        Action::make('go_to_page')
                            ->label('إضافة تصميم')
                            ->url('editor')
                            ->icon('heroicon-o-pencil')
                            ->openUrlInNewTab(),
                    )


                    ->sort(-1)
                    ->columnSpan('full'),

            ])
            ->brandLogo(asset('logo.png'))->brandLogoHeight('2.2rem')
            ->discoverResources(in: app_path('Filament/Designer/Resources'), for: 'App\\Filament\\Designer\\Resources')
            ->discoverPages(in: app_path('Filament/Designer/Pages'), for: 'App\\Filament\\Designer\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Designer/Widgets'), for: 'App\\Filament\\Designer\\Widgets')
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
                // EnsureDesignerIsVerified::class,
                Authenticate::class,
            ]);
    }
}
