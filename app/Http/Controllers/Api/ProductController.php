<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return Product::all();
        // return json_encode($products);
        return [
            'status' => true,
            'message' => 'All Products',
            'products' => ProductResource::collection(Product::all())
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => 'required|image',
            'gallery' => 'required',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'description_en' => 'required',
            'description_ar' => 'required',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id'
        ]);

        // $data = $request->except('_token', 'image', 'gallery');

        $name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ];

        $description = [
            'en' => $request->description_en,
            'ar' => $request->description_ar,
        ];

        $product = Product::create([
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
            'description' => json_encode($description, JSON_UNESCAPED_UNICODE),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);

        $path = $request->file('image')->store('uploads', 'custom');
        $product->image()->create([
            'path' => $path,
        ]);

        foreach ($request->gallery as $img) {
            $path = $img->store('uploads', 'custom');
            $product->image()->create([
                'path' => $path,
                'type' => 'gallery'
            ]);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'New Product added',
            'product' => new ProductResource($product)
        ],201);
        // flash()->success('Product created successfully!');
        // return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if($product) {
            return response()->json([
                'status' => 'true',
                'message' => 'Product found',
                'product' => new ProductResource($product)
            ],201);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Not Found"
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
