<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDesignerIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $designer = auth('designer')->user();

        if (!$designer->is_verified) {
            return redirect()->route('designer.verification');
        }

        $subscription = $designer->subscriptions()->latest()->first();

        if (!$subscription) {
            return redirect()->route('designer.subscribe.form', ['id' => 1]); // أو أي خطة افتراضية
        }

        if (!$subscription->is_approved) {
            return redirect()->route('designer.verification.wait');
        }

        if ($subscription->end_date < now()) {
            return redirect()->route('designer.subscribe.form', ['id' => $subscription->plan_id]);
        }

        return $next($request);
    }
}
