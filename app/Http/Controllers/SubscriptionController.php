<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
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

        return view('site.checkout', compact('plan'));
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
            $receiptPath = $request->file('receipt')->store('receipts', 'public');

            $startDate = now();
            $endDate = $startDate->copy()->addDays((int) $plan->duration);

            $subscription = $designer->subscriptions()->create([
                'plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'pending',
                'receipt' => $receiptPath,
                'is_approved' => false,
                'notes' => null,
            ]);

            foreach (\App\Models\User::all() as $admin) {


                \Filament\Notifications\Notification::make()
                    ->title('طلب اشتراك جديد')
                    ->body("قام المصمم {$designer->name} بإرسال طلب اشتراك جديد")
                    ->success()
                    ->actions([
                        Action::make('عرض المصمم')
                            ->url(route('filament.admin.resources.designers.edit', $designer))
                            ->button()
                            ->color('primary'),

                    ])
                    ->sendToDatabase($admin);
            }
        });

        return redirect()->route('designer.verification.wait');
    }
}
