<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Orion\FilamentGreeter\GreeterPlugin;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\EnsureDesignerIsVerified;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\Designer\Resources\RegisterDesigner;
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
        // $designer = Auth::user();
        // dd($designer);
        // $subscription = $designer->activeSubscription()->latest()->first();
        // $plan = $subscription?->plan ?? (object)['name' => 'غير معروف', 'design_limit' => 0];

        // $designsUsed = $designer->designs()->count();
        // $remainingDesigns = max(0, ($plan->design_limit ?? 0) - $designsUsed);

        // $daysLeft = now()->diffInDays(optional($subscription)->end_date, false);
        return $panel
            ->id('designer')
            ->path('designer')
            ->login()
            ->registration(RegisterDesigner::class)
            ->profile()
            ->authGuard('designer')
            ->font('cairo')
            ->colors([
                'primary' => Color::Green,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->plugins([
                TableLayoutTogglePlugin::make(),
                GreeterPlugin::make()
                    ->message('مرحباً بك،')
                    ->name(text: fn() => Auth::user('designer')->name)
                    ->title(text: fn() => "اشتراكك الحالي:" . Auth::user('designer')->activeSubscription()?->plan->name)
                    // ->avatar(
                    //     size: 'w-16 h-16',
                    //     url: auth('designer')->user()->profile
                    //         ? asset('storage/' . auth('designer')->user()->profile)
                    //         : 'https://ui-avatars.com/api/?name=' . urlencode(auth('designer')->user()->name)
                    // )
                    ->action(
                        Action::make('copy-referral')
                            ->label('نسخ رابط الإحالة')
                            ->icon('heroicon-o-clipboard')
                            ->color('primary')

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
                EnsureDesignerIsVerified::class,
                Authenticate::class,
            ]);
    }
}
