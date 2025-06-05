<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Setting;
use App\Enums\StatusTypes;
use App\Models\Subscription;
use App\Enums\TransactionType;
use Filament\Notifications\Notification;

class SubscriptionObserver
{
    public function updated(Subscription $subscription)
    {
        $designer = $subscription->subscribable;

        // حالة الاشتراك المقبول والمفعل
        if ($subscription->isDirty('is_approved') && $subscription->is_approved && $subscription->end_date >= Carbon::now()) {
            $designer->has_active_subscription = true;
            $designer->save();

            // إنشاء التحويل المالي للمحيل إذا كان هناك عمولة
            $this->createReferralTransaction($subscription);
        }

        // حالة إلغاء الموافقة أو انتهاء الصلاحية
        if (($subscription->isDirty('is_approved') && !$subscription->is_approved) || $subscription->end_date < Carbon::now()) {
            $designer->has_active_subscription = false;
            $designer->save();
        }
    }

    protected function createReferralTransaction(Subscription $subscription)
    {
        $designer = $subscription->subscribable;

        // فقط إذا كان هناك محيل وكان هذا أول اشتراك
        if ($designer->referred_by && $designer->referrer && $designer->subscriptions()->count() === 1) {
            $percentageSetting = Setting::where('key', 'present_earn')->value('value') ?? 20;
            $percentage = (float)$percentageSetting;
            $commission = round($subscription->plan->price * ($percentage / 100), 2);

            if ($commission > 0) {
                $designer->referrer->transactions()->create([
                    'amount' => $commission,
                    'status' => StatusTypes::Pending,
                    'type' => TransactionType::REFERRAL,
                    'subscription_id' => $subscription->id,
                ]);

                // إرسال إشعارات
                $this->sendReferralNotifications($designer, $commission);
            }
        }
    }

    protected function sendReferralNotifications($designer, $commission)
    {
        // إشعار المحيل
        Notification::make()
            ->title('🎉 تم تفعيل عمولة الإحالة')
            ->body("تم تفعيل عمولة إحالتك للمصمم {$designer->name} بمبلغ {$commission} " . config('app.currency', 'ر.س'))
            ->success()
            ->sendToDatabase($designer->referrer);

        // إشعار المسؤولين
        foreach (\App\Models\User::all() as $admin) {
            Notification::make()
                ->title('تم تفعيل عمولة إحالة')
                ->body("تم تفعيل عمولة {$commission} " . config('app.currency', 'ر.س') . " للمحيل {$designer->referrer->name} لإحالته المصمم {$designer->name}")
                ->success()
                ->sendToDatabase($admin);
        }
    }
}
