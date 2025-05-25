<?php

namespace App\Filament\Factory\Resources\FactoryOrderResource\Pages;

use App\Filament\Factory\Resources\FactoryOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFactoryOrder extends CreateRecord
{
    protected static string $resource = FactoryOrderResource::class;
}
