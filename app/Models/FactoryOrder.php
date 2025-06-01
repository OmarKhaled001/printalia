<?php

namespace App\Models;

use App\Enums\StatusTypes;
use App\Enums\FactoryOrderStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'factory_id', 'status'];


    protected $casts = [
        'status' => StatusTypes::class,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    protected static function booted()
    {
        static::updated(function ($factoryOrder) {
            $order = $factoryOrder->order;
            $designer = $order->designer;
            $factory = $factoryOrder->factory;

            if ($factoryOrder->isDirty('status') && $factoryOrder->status->isConfirmed()) {
                Notification::make()
                    ->title('تم قبول الطلب من المصنع')
                    ->body("تم قبول طلب التصميم رقم #{$order->id} من قبل المصنع {$factory->name}")
                    ->success()
                    ->sendToDatabase($designer);
            }

            // 2. عند انتهاء التنفيذ - تسجيل حوالة + إشعارات
            if ($factoryOrder->isDirty('status') && $factoryOrder->status->isFinished()) {
                $profit = ($order->price - $order->design->product->price) * $order->quantity;

                // تسجيل حوالة معلقة
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'factory_id' => $factoryOrder->factory_id,
                    'designer_id' => $order->designer_id,
                    'amount' => $profit,
                    'status' => \App\Enums\StatusTypes::Pending,
                ]);


                // إشعار للمصمم
                Notification::make()
                    ->title('تم تحويل الربح للمنصة')
                    ->body("تم تحويل ربحك من الطلب #{$order->id} إلى المنصة. الربح: {$profit} ريال.")
                    ->success()
                    ->sendToDatabase($designer);
                foreach (\App\Models\User::all() as $admin) {

                    if ($admin) {
                        Notification::make()
                            ->title('ربح جديد لمصمم')
                            ->body("للمصمم {$designer->name} ربح بقيمة {$profit} ريال من الطلب رقم #{$order->id}")
                            ->success()
                            ->actions([
                                Action::make('عرض المصمم')
                                    ->url(route('filament.admin.resources.designers.edit', $designer))
                                    ->button()
                                    ->color('primary'),
                            ])
                            ->sendToDatabase($admin);
                    }
                }
            }
        });
    }
}
