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

            // 1. عند قبول الطلب من المصنع
            if ($factoryOrder->isDirty('status') && $factoryOrder->status->isConfirmed()) {
                Notification::make()
                    ->title('تم قبول الطلب من المصنع')
                    ->body("تم قبول طلب التصميم رقم #{$order->id} من قبل المصنع {$factory->name}")
                    ->success()
                    ->sendToDatabase($designer);
            }

            // 2. عند رفض الطلب من المصنع
            if ($factoryOrder->isDirty('status') && $factoryOrder->status->isRejected()) {
                // البحث عن مصنع عشوائي آخر
                $newFactory = Factory::where('id', '!=', $factory->id)
                    ->inRandomOrder()
                    ->first();

                if ($newFactory) {
                    // إنشاء طلب جديد للمصنع الجديد
                    $newFactoryOrder = self::create([
                        'order_id' => $order->id,
                        'factory_id' => $newFactory->id,
                        'status' => StatusTypes::Pending,
                    ]);

                    // إشعار للمصمم
                    Notification::make()
                        ->title('تم إعادة توجيه الطلب')
                        ->body("تم رفض الطلب #{$order->id} من المصنع {$factory->name} وتم إرساله إلى المصنع {$newFactory->name}")
                        ->warning()
                        ->sendToDatabase($designer);

                    // إشعار للمصنع الجديد
                    Notification::make()
                        ->title('طلب جديد يحتاج إلى مراجعة')
                        ->body("تم إرسال طلب جديد رقم #{$order->id} إليك")
                        ->success()
                        ->sendToDatabase($newFactory->user);
                } else {
                    // في حالة عدم وجود مصانع أخرى
                    Notification::make()
                        ->title('لا يوجد مصانع متاحة')
                        ->body("تم رفض الطلب #{$order->id} من المصنع {$factory->name} ولا يوجد مصانع أخرى متاحة")
                        ->danger()
                        ->sendToDatabase($designer);
                }
            }

            // 3. عند انتهاء التنفيذ
            if ($factoryOrder->status->isFinished()) {
                $profit = ($order->price - $order->design->product->price) * $order->quantity;

                // تسجيل حوالة معلقة
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'factory_id' => $factoryOrder->factory_id,
                    'designer_id' => $order->designer_id,
                    'amount' => $profit,
                    'status' => \App\Enums\StatusTypes::Pending,
                    'type' => \App\Enums\TransactionType::PROFIT,
                ]);

                // إشعار للمصمم
                Notification::make()
                    ->title('تم تحويل الربح للمنصة')
                    ->body("تم تحويل ربحك من الطلب #{$order->id} إلى المنصة. الربح: {$profit} ريال.")
                    ->success()
                    ->sendToDatabase($designer);

                // إشعار للمدراء
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
