<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
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
            // ->profile()
            ->authGuard('designer')
            ->font('cairo')
            ->colors([
                'primary' => Color::Green,
            ])
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
                EnsureDesignerIsVerified::class,
                Authenticate::class,
            ]);
    }
}
