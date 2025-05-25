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

        // If authenticated but not verified, redirect to verification pending page
        if (!$designer->is_verified && !$designer->is_verified) {
            return redirect()->route('verification');
        }
        // If authenticated but not verified, redirect to verification pending page
        if (!$designer->has_active_subscription) {
            return redirect()->route('designer.subscribe.form');
        }

        $subscription = $designer->subscriptions()->latest()->first();

        if ($subscription && !$subscription->is_approved) {
            return redirect()->route('verification-wait');
        }

        return $next($request);
    }
}
