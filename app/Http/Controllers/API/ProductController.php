<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function addProductApi(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:191',
        'qty' => 'required|integer|min:0',
        'regular_price' => 'required|numeric',
        'sale_price' => 'required|numeric',
        'size' => 'required|array',
        'color' => 'required|array',
        'category' => 'required|integer|exists:category,id',
        'thumbnail' => 'nullable|image|max:2048',
        'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 422, 'error' => $validator->errors()], 422);
    }

    try {
        $fileName = '';
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = rand(1000, 9999) . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $fileName); // Save to: storage/app/public/uploads
        }

        $product = DB::table('product')->insert([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'quantity' => $request->qty,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'attribute_size' => implode(',', $request->size), // array of attribute ID
            'attribute_color' => implode(',', $request->color), // array of attribute ID
            'category' => $request->category,
            'thumbnail' => $fileName,
            'viewer' => 0,
            'author' => Auth::id(),
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Product added successfully.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'Error creating product',
            'error' => $e->getMessage()
        ]);
    }
}

}
