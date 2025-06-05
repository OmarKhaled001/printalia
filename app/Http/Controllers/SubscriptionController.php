<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Setting;
use App\Enums\StatusTypes;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
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
        // dd($request);
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'account_code' => 'required|exists:bank_accounts,code',
            'receipt' => 'required|image|max:2048',
        ]);

        $designer = auth('designer')->user();
        $plan = Plan::findOrFail($request->plan_id);
        $account = BankAccount::where('code', $request->account_code)->get()->first();

        DB::transaction(function () use ($request, $designer, $plan, $account) {
            $receiptPath = $this->handleReceiptUpload($request->file('receipt'));

            $startDate = now();
            $endDate = $plan->calculateEndDate($startDate);
            $adminUsers = \App\Models\User::all();
            if ($designer->referred_by && $designer->referrer) {
                $percentageSetting = Setting::where('key', 'present_earn')->value('value') ?? 20;
                $percentage = (float)$percentageSetting;
                $commission = round($plan->price * ($percentage / 100), 2);
                $amount = $plan->price - $commission;
            }
            $subscriptionData = [
                'plan_id' => $plan->id,
                'bank_account_id' => $account->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => \App\Enums\StatusTypes::Pending,
                'receipt' => $receiptPath,
                'amount' => $amount ?? $plan->price,
                'is_approved' => false,
            ];

            $designer->subscriptions()->create($subscriptionData);

            // إرسال إشعارات للمسؤولين
            $this->notifyAdminsAboutNewSubscription($adminUsers, $designer, $plan);
        });

        return redirect()->route('designer.verification.wait');
    }

    protected function handleReceiptUpload($receiptFile): string
    {
        if (!$receiptFile || !$receiptFile->isValid()) {
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

        return $receiptPath;
    }

    protected function notifyAdminsAboutNewSubscription($adminUsers, $designer, $plan)
    {
        foreach ($adminUsers as $admin) {
            Notification::make()
                ->title('طلب اشتراك جديد')
                ->body("قام المصمم {$designer->name} بإرسال طلب اشتراك جديد في باقة ({$plan->name}).")
                ->success()
                ->actions([
                    Action::make('عرض الاشتراك')
                        ->url(route('filament.admin.resources.designers.edit', $designer))
                        ->button()
                        ->color('primary'),
                ])
                ->sendToDatabase($admin);
        }
    }

    public function getMockups()
    {
        try {
            $mockups = Product::select('id', 'name', 'image_front', 'image_back', 'is_double_sided')->get();
            return response()->json($mockups);
        } catch (\Exception $e) {
            Log::error('Error fetching mockups: ' . $e->getMessage());
            return response()->json(['error' => 'Could not fetch mockups.'], 500);
        }
    }
}
