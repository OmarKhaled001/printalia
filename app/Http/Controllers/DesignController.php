<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class DesignController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'sale_price'    => 'required|numeric|min:0',
            'is_published'  => 'boolean',
            'logo_front'    => 'nullable|image|max:2048',
            'logo_back'     => 'nullable|image|max:2048',
            'image_front'   => 'required|image|max:4096',
            'image_back'    => 'nullable|image|max:4096'
        ]);

        $designer = auth('designer')->user();
        $product = Product::find($request->product_id);
        $data['profit'] = $request->sale_price - $product->price;
        $data['designer_id'] =  auth('designer')->user()->id;

        $remainingDesigns = $designer->remainingDesigns();

        if (!is_null($remainingDesigns) && $remainingDesigns <= 0) {
            $message = "لقد استهلكت عدد التصاميم المتاحة لك في الاشتراك الحالي";

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $message,
                ], 422);
            }

            Notification::make()
                ->title('حدث خطأ')
                ->body($message)
                ->danger()
                ->send();

            return back()->withInput();
        }



        // Upload images
        $imageFields = ['logo_front', 'logo_back', 'image_front', 'image_back'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store("designs/{$field}", 'public');
            }
        }

        // Create design
        $design = Design::create($data);

        // Send success notification
        $remainingAfterCreation = $designer->remainingDesigns();
        Notification::make()
            ->title('تم الإنشاء بنجاح')
            ->body("تم إضافة التصميم بنجاح. التصاميم المتبقية لك: {$remainingAfterCreation}")
            ->success()
            ->send();

        return redirect()->route('filament.designer.resources.designs.index');
    }
}
