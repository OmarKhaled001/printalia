<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDesignerIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // السماح بمرور صفحات الدخول والتسجيل
        if ($request->routeIs('filament.designer.auth.login') || $request->routeIs('filament.designer.auth.register')) {
            return $next($request);
        }

        $designer = auth('designer')->user();

        // لو مش مسجل دخول
        if (!$designer) {
            return redirect()->route('filament.designer.auth.login');
        }

        // جلب آخر اشتراك
        $latestSubscription = $designer->subscriptions()->latest()->first();

        // لو مفيش اشتراك خالص → روح لصفحة الاشتراكات
        if (!$latestSubscription) {
            return redirect()->route('designer.subscription-plans')
                ->with('warning', 'يرجى الاشتراك في إحدى الباقات للوصول إلى لوحة التحكم');
        }

        // لو عنده اشتراك لكن لسه تحت المراجعة → روح لصفحة الانتظار
        if (!$latestSubscription->is_approved) {
            return redirect()->route('designer.verification.wait')
                ->with('info', 'جاري مراجعة اشتراكك من قبل الإدارة');
        }

        // لو كل شيء تمام
        return $next($request);
    }
}