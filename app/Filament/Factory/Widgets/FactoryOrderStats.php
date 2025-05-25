<?php

namespace App\Filament\Factory\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Enums\StatusTypes;
use App\Models\FactoryOrder;


class FactoryOrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        $factoryId = auth('factory')->id();

        return [
            Stat::make(
                'إجمالي الطلبات',
                FactoryOrder::where('factory_id', $factoryId)->count()
            )
                ->icon('heroicon-o-inbox'),

            Stat::make(
                'الطلبات المعلقة',
                FactoryOrder::where('factory_id', $factoryId)
                    ->where('status', StatusTypes::Pending->value)->count()
            )
                ->icon('heroicon-o-clock')
                ->color('info'),

            Stat::make(
                'الطلبات المقبولة',
                FactoryOrder::where('factory_id', $factoryId)
                    ->where('status', StatusTypes::Accepted->value)->count()
            )
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(
                'الطلبات المنتهية',
                FactoryOrder::where('factory_id', $factoryId)
                    ->where('status', StatusTypes::Finished->value)->count()
            )
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
