<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function getProductForDesigner(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'image_front_url' => $product->image_front ? Storage::url($product->image_front) : null,
            'image_back_url' => $product->image_back ? Storage::url($product->image_back) : null,
            'is_double_sided' => (bool) $product->is_double_sided,
        ]);
    }

    public function saveDesign(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'design_id' => 'nullable|exists:designs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sale_price' => 'nullable|numeric|min:0',
            'is_published' => 'nullable|boolean',

            'logo_front_json' => 'nullable|json',
            'logo_back_json' => 'nullable|json',

            'image_front_data_url' => 'nullable|string', // شعار أمامي شفاف
            'image_back_data_url' => 'nullable|string',  // شعار خلفي شفاف

            'full_preview_front_data_url' => 'nullable|string', // تصميم أمامي كامل
            'full_preview_back_data_url' => 'nullable|string',  // تصميم خلفي كامل
        ]);

        $designerId = Auth::user('designer')->id; // أو من مصدر آخر

        $designData = [
            'product_id' => $validated['product_id'],
            'designer_id' => $designerId,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'sale_price' => $validated['sale_price'] ?? 0,
            'is_published' => $validated['is_published'] ?? false,
            'logo_front' => $validated['logo_front_json'] ? json_decode($validated['logo_front_json'], true) : null,
            'logo_back' => $validated['logo_back_json'] ? json_decode($validated['logo_back_json'], true) : null,
        ];

        // حفظ صور الشعارات الشفافة (التي ستُستخدم في Design->image_front و Design->image_back)
        if (!empty($validated['image_front_data_url'])) {
            $designData['image_front'] = $this->storeBase64Image($validated['image_front_data_url'], 'designs/final_logos');
        }
        if (!empty($validated['image_back_data_url'])) {
            $designData['image_back'] = $this->storeBase64Image($validated['image_back_data_url'], 'designs/final_logos');
        }

        // يمكنك أيضًا حفظ صور المعاينة الكاملة إذا كان لديك حقول لها في المودل
        // $fullPreviewFrontPath = null;
        // if (!empty($validated['full_preview_front_data_url'])) {
        //     $fullPreviewFrontPath = $this->storeBase64Image($validated['full_preview_front_data_url'], 'designs/full_previews');
        //      $designData['preview_image_front'] = $fullPreviewFrontPath; // مثال لحقل إضافي
        // }
        // ... وهكذا للـ full_preview_back_data_url

        if (!empty($validated['design_id'])) {
            $design = Design::find($validated['design_id']);
            if (!$design) {
                return response()->json(['message' => 'التصميم المطلوب غير موجود.'], 404);
            }
            // حذف الصور القديمة إذا تم رفع صور جديدة
            // ...
            $design->update($designData);
        } else {
            $design = Design::create($designData);
        }

        return response()->json([
            'message' => 'تم حفظ التصميم بنجاح!',
            'design_id' => $design->id,
            'front_image_url' => $design->front_image_url, // من Accessor في المودل
            'back_image_url' => $design->back_image_url,   // من Accessor في المودل
            // يمكنك إعادة مسارات صور المعاينة الكاملة أيضًا
        ]);
    }

    private function storeBase64Image($base64Image, $directory)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \InvalidArgumentException('نوع صورة غير صالح.');
            }
            $base64Image = base64_decode($base64Image);
            if ($base64Image === false) {
                throw new \RuntimeException('فشل فك ترميز base64.');
            }
        } else {
            throw new \InvalidArgumentException('Data URL غير صالح.');
        }

        $fileName = Str::random(20) . '.' . $type;
        $path = "{$directory}/" . date('Y/m') . "/{$fileName}"; // تنظيم الملفات حسب السنة والشهر
        Storage::disk('public')->put($path, $base64Image);
        return $path;
    }
}
