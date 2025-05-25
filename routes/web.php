<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\EnsureDesignerIsVerified;

Route::get('/', function () {
    return view('site.index');
})->name('home');

Route::get('/verification', function () {
    return view('site.verification');
})->name('verification')->middleware('auth:designer', EnsureDesignerIsVerified::class);

Route::get('/verification-wait', function () {
    return view('site.verification-wait');
})->name('verification-wait')->middleware('auth:designer', EnsureDesignerIsVerified::class);
// عرض صفحة الاشتراك بالخطة
Route::get('/designer/{id}/subscribe', [SubscriptionController::class, 'index'])->name('designer.subscribe.form')->middleware('auth:designer', EnsureDesignerIsVerified::class);

// تنفيذ الاشتراك بعد تعبئة النموذج
Route::post('/designer/subscribe', [SubscriptionController::class, 'store'])->name('designer.subscribe')->middleware('auth:designer', EnsureDesignerIsVerified::class);
