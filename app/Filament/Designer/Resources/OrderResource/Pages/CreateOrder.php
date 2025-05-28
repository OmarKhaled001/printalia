<?php

namespace App\Filament\Designer\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Models\Factory;
use App\Enums\StatusTypes;
use App\Models\FactoryOrder;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Designer\Resources\OrderResource;
use Filament\Notifications\Notification;

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
            $newOrder = FactoryOrder::create([
                'order_id' => $order->id,
                'factory_id' => $factory->id,
                'status' => StatusTypes::Pending->value,
            ]);

            Notification::make()
                ->title('طلب اشتراك جديد')
                ->body("تصنيع عدد {$newOrder->order->name} من {$newOrder->quantity} بسعر {$newOrder->price} للواحد")
                ->success()
                ->actions([
                    Action::make('عرض الطلب')
                        ->url(route('filament.factory.resources.factory-orders.view', ['record' => $newOrder]))
                        ->button()
                        ->color('primary'),
                    Action::make('accept')
                        ->label('قبول')
                        ->action(function () use ($newOrder) {
                            $newOrder->update(['status' => StatusTypes::Accepted]);
                            $newOrder->order->update(['factory_id' => $newOrder->factory_id]);
                        })
                        ->button()
                        ->color('primary'),
                ])
                ->sendToDatabase($factory);
        }
    }
}
