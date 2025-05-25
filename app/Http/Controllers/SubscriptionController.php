<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SubscriptionController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'receipt' => 'required|image|max:2048',
        ]);

        $designer = auth('designer')->user();
        $plan = \App\Models\Plan::findOrFail($request->plan_id);

        DB::transaction(function () use ($request, $designer, $plan) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');

            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addDays($plan->duration);

            $designer->subscriptions()->create([
                'plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'pending',
                'receipt' => $receiptPath,
                'is_approved' => false,
                'notes' => null,
            ]);
        });

        return back()->with('success', 'تم إرسال طلب الاشتراك بنجاح، سيتم مراجعته قريباً.');
    }
}
