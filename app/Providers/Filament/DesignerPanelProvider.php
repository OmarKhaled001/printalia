<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Pages\Auth\RegisterDesigner;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\EnsureDesignerIsVerified;
use Filament\Http\Middleware\AuthenticateSession;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class DesignerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('designer')
            ->path('designer')
            ->login()
            ->registration(RegisterDesigner::class)
            ->authGuard('designer')
            ->font('cairo')
            ->colors([
                'primary' => Color::Green,
            ])

            ->plugins([
                TableLayoutTogglePlugin::make()
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
                EnsureDesignerIsVerified::class,
                Authenticate::class,
            ]);
    }
}
