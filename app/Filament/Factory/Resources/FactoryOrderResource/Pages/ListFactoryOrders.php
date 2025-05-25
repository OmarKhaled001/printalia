<?php

namespace App\Filament\Factory\Resources\FactoryOrderResource\Pages;

use App\Filament\Factory\Resources\FactoryOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFactoryOrders extends ListRecords
{
    protected static string $resource = FactoryOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
