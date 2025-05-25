<?php

use Illuminate\Support\Facades\Route;
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


Route::get('/', function () {
    return view('site.index');
})->name('home');

Route::middleware(['auth:designer'])->name('designer.')->group(function () {

    Route::prefix('verification')->group(function () {
        Route::get('/', function () {
            return view('site.verification');
        })->name('verification');

        Route::get('/wait', function () {
            return view('site.verification-wait');
        })->name('verification.wait');

        Route::get('/subscription', function () {
            return view('site.subscription');
        })->name('subscription');
    });

    Route::prefix('subscription')->group(function () {
        Route::get('/{id}', [SubscriptionController::class, 'index'])
            ->name('subscribe.form');

        Route::post('/', [SubscriptionController::class, 'store'])
            ->name('subscribe');
    });
});
