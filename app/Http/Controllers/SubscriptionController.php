<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Actions\Action;

class SubscriptionController extends Controller
{


    public function showPlans()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('site.subscription-plans', compact('plans'));
    }

    public function showSubscriptionForm($id)
    {
        if (auth('designer')->user()->has_active_subscription) {
            return redirect()->route('filament.designer.pages.dashboard')
                ->with('info', 'لديك اشتراك نشط بالفعل');
        }
        $plan = Plan::find($id);
        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('site.checkout', compact('plan', 'bankAccounts'));
    }

    public function processSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'receipt' => 'required|image|max:2048',
        ]);

        $designer = auth('designer')->user();
        $plan = \App\Models\Plan::findOrFail($request->plan_id);

        DB::transaction(function () use ($request, $designer, $plan) {
            $receiptFile = $request->file('receipt');
            if (!$receiptFile || !$receiptFile->isValid()) {
                // يمكنك رمي استثناء هنا ليتم التعامل معه بواسطة معالج الاستثناءات العام
                // أو إعادة توجيه مع خطأ. بما أننا داخل transaction، رمي استثناء أفضل.
                throw new \Illuminate\Http\Exceptions\HttpResponseException(
                    response()->json(['message' => 'ملف الإيصال غير صالح أو تالف.'], 422)
                );
            }
            $receiptPath = $receiptFile->store('receipts', 'public');
            if (!$receiptPath) {
                throw new \Illuminate\Http\Exceptions\HttpResponseException(
                    response()->json(['message' => 'فشل تخزين ملف الإيصال.'], 500)
                );
            }

            $startDate = now();
            $endDate = $startDate->copy()->addDays((int) $plan->duration);

            $subscription = $designer->subscriptions()->create([
                'plan_id'           => $plan->id,
                'start_date'        => $startDate,
                'end_date'          => $endDate,
                'status'            => \App\Enums\StatusTypes::Pending,
                'receipt'           => $receiptPath,
                'is_approved'       => false,
                'notes'             => null,
            ]);


            $adminUsers = \App\Models\User::get();

            if ($designer->referred_by && $designer->referrer) { // التأكد من وجود المُحيل
                $subscriptionsCount = $designer->subscriptions()->count();
                $commission = 0; // تهيئة المتغير

                if ($subscriptionsCount === 1) { // عمولة لأول اشتراك فقط
                    $percentageSetting = Setting::where('key', 'present_earn')->value('value');
                    $percentage = (float)($percentageSetting ?? 20);
                    $commission = round($plan->price * ($percentage / 100), 2);

                    if ($commission > 0) {
                        // إنشاء معاملة للمُحيل
                        $designer->referrer->transactions()->create([
                            'amount'       => $commission,
                            'status'       => \App\Enums\StatusTypes::Pending,
                            'type'         => \App\Enums\TransactionType::REFERRAL,
                        ]);

                        // إشعار المسؤولين بالعمولة
                        foreach ($adminUsers as $admin) {
                            \Filament\Notifications\Notification::make()
                                ->title('إحالة جديدة مع عمولة')
                                ->body("المصمم {$designer->name} (مُحال من {$designer->referrer->name}) اشترك في باقة. عمولة المُحيل: {$commission} " . config('app.currency', 'ر.س'))
                                ->success()
                                ->sendToDatabase($admin);
                        }

                        // إشعار المُحيل بالعمولة
                        \Filament\Notifications\Notification::make()
                            ->title('🎉 تهانينا! لقد ربحت عمولة إحالة')
                            ->body("لقد حصلت على مبلغ {$commission} " . config('app.currency', 'ر.س') . " كمكافأة لإحالتك للمصمم {$designer->name}.")
                            ->success()
                            ->sendToDatabase($designer->referrer);
                    }
                }
            }

            // إشعار المسؤولين بالاشتراك الجديد العام
            foreach ($adminUsers as $admin) {
                \Filament\Notifications\Notification::make()
                    ->title('طلب اشتراك جديد')
                    ->body("قام المصمم {$designer->name} بإرسال طلب اشتراك جديد في باقة ({$plan->name}).") // إضافة اسم الباقة قد يكون مفيدًا
                    ->success()
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('عرض الاشتراك') // أو عرض المصمم
                            ->url(route('filament.admin.resources.designers.edit', $designer)) // أو رابط الاشتراك إذا كان لديك صفحة له
                            ->button()
                            ->color('primary'),
                    ])
                    ->sendToDatabase($admin);
            }
        });

        return redirect()->route('designer.verification.wait');
    }
}
