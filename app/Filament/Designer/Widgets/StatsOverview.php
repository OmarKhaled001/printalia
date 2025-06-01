<?php

namespace App\Filament\Designer\Widgets;

use App\Enums\StatusTypes;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $designer = Auth::guard('designer')->user();
        $subscription = $designer->activeSubscription();
        $plan = $subscription?->plan;

        $used = $designer->designsUsedCount();
        $limit = $plan->design_count ??  "غير محدود";
        $remaining = $designer->remainingDesigns();
        $daysLeft = $designer->daysLeftInSubscription();
        $ordersCount = $designer->customers()->withCount('orders')->get()->sum('orders_count');

        $customersCount = $designer->customers()->count();

        // ✅ أرباح الطلبات المنتهية فقط
        $finishedOrdersTotal = \App\Models\Transaction::where('designer_id', $designer->id)
            ->where('status', StatusTypes::Pending)
            ->get()
            ->sum('amount');
        $referralEarnings = 00.0;

        return [
            Stat::make('التصاميم المستخدمة', "$used / $limit")
                ->description('عدد التصاميم المستهلكة من إجمالي الخطة')
                ->color('primary'),

            Stat::make('المتبقي من الأيام', "$daysLeft يوم")
                ->description('الوقت المتبقي في الاشتراك')
                ->color($daysLeft <= 3 ? 'danger' : 'success'),

            Stat::make('عدد الطلبات', $ordersCount)
                ->description('إجمالي الطلبات المرتبطة بك')
                ->color('info'),

            Stat::make('عدد العملاء', $customersCount)
                ->description('إجمالي العملاء المرتبطين بك')
                ->color('info'),

            Stat::make('أرباح الطلبات المنتهية', number_format($finishedOrdersTotal, 2) . ' ر.س')
                ->description('فقط الطلبات التي تم إنهاؤها في المصانع ولم يتم تحويل ربحها')
                ->color('success'),

            Stat::make('أرباح الإحالة', number_format($referralEarnings, 2) . ' ر.س')
                ->description('مكافآت تم احتسابها عبر الإحالة')
                ->color('primary'),
        ];
    }
}
