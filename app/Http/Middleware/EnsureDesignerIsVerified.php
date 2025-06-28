<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDesignerIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // إذا كان المستخدم في صفحة تسجيل الدخول أو التسجيل، لا تعمل إعادة توجيه
        if ($request->routeIs('filament.designer.auth.login') || $request->routeIs('filament.designer.auth.register')) {
            return $next($request);
        }

        $designer = auth('designer')->user();

        // إذا لم يكن مسجل دخول أصلاً
        if (!$designer) {
            return redirect()->route('filament.designer.auth.login');
        }

        // إذا لم يتم التحقق من الحساب أو لا يملك اشتراك
        if (!$designer->is_verified) {
            return redirect()->route('designer.verification.wait')
                ->with('warning', 'يجب الاشتراك في إحدى الباقات للوصول إلى لوحة التحكم');
        }

        // إذا انتهت صلاحية الاشتراك
        $activeSubscription = $designer->activeSubscription();
        if (!$activeSubscription) {
            return redirect()->route('designer.subscription-plan s')
                ->with('error', 'انتهت صلاحية اشتراكك، يرجى تجديده');
        }

        return $next($request);
    }
}
