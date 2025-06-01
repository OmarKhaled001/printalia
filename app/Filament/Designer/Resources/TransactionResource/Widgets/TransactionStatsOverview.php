<?php

namespace App\Filament\Designer\Resources\TransactionResource\Widgets;

use App\Enums\StatusTypes;
use App\Models\Transaction;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TransactionStatsOverview extends BaseWidget
{

    protected static bool $isDiscovered = true; // في كلاس الـ Widget

    protected function getStats(): array
    {
        $designerId = Auth::id();

        $pendingTotal = Transaction::where('designer_id', $designerId)
            ->where('status', StatusTypes::Pending->value)
            ->sum('amount');

        $finishedTotal = Transaction::where('designer_id', $designerId)
            ->where('status', StatusTypes::Finished->value)
            ->sum('amount');

        $totalOrders = Order::where('designer_id', $designerId)
            ->count();

        return [
            Stat::make('الأرباح المعلقة', number_format($pendingTotal, 2) . ' ر.س')
                ->description('في انتظار التحويل')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('الأرباح المنتهية', number_format($finishedTotal, 2) . ' ر.س')
                ->description('تم تحويلها لحسابك')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('إجمالي الأوردرات', $totalOrders)
                ->description('عدد الطلبات الكلي')
                ->color('primary')
                ->icon('heroicon-o-document-text'),
        ];
    }
}
