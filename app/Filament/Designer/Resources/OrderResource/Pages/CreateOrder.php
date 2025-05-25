<?php

namespace App\Filament\Designer\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Models\Factory;
use App\Enums\StatusTypes;
use App\Models\FactoryOrder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Designer\Resources\OrderResource;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function afterCreate(): void
    {
        $this->sendToRandomFactory($this->record);
    }

    protected function sendToRandomFactory($order): void
    {
        $factory = Factory::inRandomOrder()->first();

        if ($factory) {
            FactoryOrder::create([
                'order_id' => $order->id,
                'factory_id' => $factory->id,
                'status' =>  StatusTypes::Pending->value,
            ]);
        }
    }
}
