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
                'order_id'   => $order->id,
                'factory_id' => $factory->id,
                'status'     => StatusTypes::Pending->value,
            ]);

            Notification::make()
                ->title('طلب جديد للتصنيع')
                ->body("تم إرسال طلب تصنيع لمنتج: {$order->name} بعدد: {$order->quantity} قطعة.")
                ->success()
                ->actions([
                    Action::make('عرض التفاصيل')
                        ->url(route('filament.factory.resources.factory-orders.view', ['record' => $newOrder]))
                        ->button()
                        ->color('primary'),


                ])
                ->sendToDatabase($factory);
        } else {
            Notification::make()
                ->title('لم يتم العثور على مصنع')
                ->body('عذراً، لا يوجد مصنع متاح حالياً لاستلام هذا الطلب.')
                ->danger()
                ->sendToDatabase(auth()->user());
        }
    }
}
