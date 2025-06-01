<?php

namespace App\Filament\Designer\Resources\TransactionResource\Pages;

use App\Filament\Designer\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;



    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Designer\Resources\TransactionResource\Widgets\TransactionStatsOverview::class,
        ];
    }
}
