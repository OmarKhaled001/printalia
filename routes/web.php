<?php

use App\Models\Design;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Middleware\IsDesigner;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\DesignController;
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
Route::get('/api/mockups', [SubscriptionController::class, 'getMockups']);

Route::get('/editor', function () {
    $products = Product::all();
    return view('site.editor', compact('products'));
})->name('editor')->middleware([IsDesigner::class]);

Route::post('/design/store', [DesignController::class, 'store'])->name('designs.store');
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


// Route لجلب بيانات المنتج
Route::get('/api/designer/product/{product}', [ImageController::class, 'getProductForDesigner'])
    ->middleware('auth') // تأكد من وجود صلاحيات مناسبة
    ->name('api.designer.product');

// Route لحفظ التصميم
Route::post('/filament-custom/save-design', [ImageController::class, 'saveDesign'])
    ->middleware('auth') // تأكد من وجود صلاحيات مناسبة
    ->name('filament.custom.save-design');


Route::get('/designs/{design}/share', function (Design $design) {
    // This is a simple example. You'd likely have a dedicated Blade view for sharing.
    // This view would display the design image and details.
    return view('share-design', compact('design'));
})->name('view-design');

// New API route for fetching mockup product
Route::get('/products/mockup/{identifier}', function ($identifier) {
    // Use the findMockupProduct method from your Product model
    $product = Product::findMockupProduct($identifier);

    if ($product) {
        // Assuming 'image_front' stores the path relative to public storage or a URL
        // Make sure the image_front path is publicly accessible (e.g., via storage:link)
        // Or, if it's a full URL, ensure it's correct.
        $imageUrl = $product->image_front ? asset('storage/app/public/' . $product->image_front) : null;

        if ($imageUrl && file_exists(public_path('storage/app/public/' . $product->image_front))) {
            return response()->json([
                'success' => true,
                'name' => $product->name,
                'image_url' => $imageUrl,
            ]);
        } else {
            // Handle case where image file doesn't exist
            return response()->json([
                'success' => false,
                'message' => 'Product found, but image file not found or accessible.',
            ], 404);
        }
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Product not found with the provided ID or SKU.',
        ], 404);
    }
})->name('api.products.mockup');
