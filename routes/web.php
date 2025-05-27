<?php

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Middleware\IsDesigner;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\EnsureDesignerIsVerified;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', fn() => view('site.index'))->name('home');

// Routes خاصة بالمصممين
Route::prefix('designer')->name('designer.')->middleware([IsDesigner::class])->group(function () {

    // التحقق من الحساب والاشتراك
    Route::prefix('verification')->group(function () {
        Route::get('/', fn() => view('site.verification'))->name('verification');
        Route::get('/wait', fn() => view('site.verification-wait'))->name('verification.wait');
        Route::get('/subscription', fn() => view('site.subscription'))->name('subscription');
    });

    // إدارة الاشتراكات
    Route::prefix('subscription')->group(function () {
        Route::get('/plans', [SubscriptionController::class, 'showPlans'])->name('subscription-plans');
        Route::get('/{id}', [SubscriptionController::class, 'showSubscriptionForm'])->name('subscribe.form');
        Route::post('/', [SubscriptionController::class, 'processSubscription'])->name('subscribe');
    });
});
