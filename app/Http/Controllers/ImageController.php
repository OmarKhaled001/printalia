<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->input('image');

        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $image = base64_decode($data);

        $filename = 'composed_' . time() . '.png';
        Storage::disk('public')->put('composed/' . $filename, $image);

        return response()->json([
            'path' => Storage::url('composed/' . $filename),
        ]);
    }
}
