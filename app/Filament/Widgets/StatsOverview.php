<?php

namespace App\Filament\Widgets;

use App\Models\Designer;
use App\Models\Order;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $activeSubscriptions = Subscription::where('is_approved', true)
            ->where('end_date', '>=', now())
            ->count();

        $monthlyRevenue = Subscription::where('is_approved', true)
            ->whereBetween('start_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $totalDesigners = Designer::count();
        $activeDesigners = Designer::where('is_active', true)
            ->where('is_verified', true)
            ->where('has_active_subscription', true)
            ->count();

        $totalOrders = Order::count();
        $monthlyOrders = Order::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        $monthlySales = Order::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total');

        return [
            Stat::make('الاشتراكات النشطة', $activeSubscriptions)
                ->description('عدد الاشتراكات المفعلة حالياً')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success'),

            Stat::make('إيرادات الاشتراكات الشهرية', number_format($monthlyRevenue) . ' ر.س')
                ->description('إجمالي إيرادات الاشتراكات هذا الشهر')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('primary'),

            Stat::make('المصممون النشطون', "{$activeDesigners} / {$totalDesigners}")
                ->description('المصممون المشتركون من إجمالي المصممين')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),

            // Stat::make('الطلبات الشهرية', $monthlyOrders)
            //     ->description("من إجمالي {$totalOrders} طلب")
            //     ->descriptionIcon('heroicon-o-shopping-bag')
            //     ->color('warning'),

            // Stat::make('مبيعات الشهر', number_format($monthlySales) . ' ر.س')
            //     ->description('إجمالي قيمة المبيعات هذا الشهر')
            //     ->descriptionIcon('heroicon-o-chart-bar')
            //     ->color('success'),

            // Stat::make('متوسط قيمة الطلب', $monthlyOrders > 0 ? number_format($monthlySales / $monthlyOrders) . ' ر.س' : '0 ر.س')
            //     ->description('متوسط سعر الطلب الواحد')
            //     ->descriptionIcon('heroicon-o-scale')
            //     ->color('danger'),
        ];
    }
}
