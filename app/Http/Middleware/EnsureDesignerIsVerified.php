<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDesignerIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $designer = auth('designer')->user();

        // 1. Not verified
        if (!$designer->is_verified) {
            return redirect()->route('designer.verification');
        }

        // 2. No active subscription
        if (!$designer->has_active_subscription) {
            return redirect()->route('designer.subscribe.form', ['designer' => $designer->id]);
        }

        // 3. Subscription not approved
        $subscription = $designer->subscriptions()->latest()->first();
        if ($subscription && !$subscription->is_approved) {
            return redirect()->route('designer.verification.wait');
        }

        return $next($request);
    }
}
