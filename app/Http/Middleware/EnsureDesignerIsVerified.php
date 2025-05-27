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


        // إذا لم يكن لديه اشتراك فعال
        if (!$designer->is_verified && !$designer->has_active_subscription) {
            return redirect()->route('designer.subscription-plans')
                ->with('warning', 'يجب الاشتراك في إحدى الباقات للوصول إلى لوحة التحكم');
        }

        // إذا انتهت صلاحية الاشتراك
        $activeSubscription = $designer->activeSubscription();
        if (!$activeSubscription) {
            return redirect()->route('designer.subscription-plans')
                ->with('error', 'انتهت صلاحية اشتراكك، يرجى تجديده');
        }

        return $next($request);
    }
}
