<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    // public function __construct()
    // {
    //     $this->authorizeResource(Product::class, 'product');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('products')) {
            return abort(403, 'Don\'t have Permission');
        }
        $products = Product::latest('id')->with('category')->paginate(2);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create-product')) {
            return abort(403, 'Don\'t have Permission');
        }
        $categories = Category::select('id', 'name')->get();
        $product = new product();
        return view('dashboard.products.create', compact('categories', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create-product')) {
            return abort(403, 'Don\'t have Permission');
        }
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
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean',
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
            'is_featured' => $request->input('is_featured',0)
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

        flash()->success('Product created successfully!');
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (Gate::denies('update-product')) {
            return abort(403, 'Don\'t have Permission');
        }
        $categories = Category::select('id', 'name')->get();
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (Gate::denies('update-product')) {
            return response()->json(['message' => 'Don\'t have Permission'], 403);
        }

        $validatore = Validator($request->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'price' => 'required|numeric',
            'description_en' => 'required',
            'description_ar' => 'required',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        if ($validatore->fails()) {
            return response()->json([
                'message' => $validatore->errors()->first()
            ], 422);
        }

        $name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ];

        $description = [
            'en' => $request->description_en,
            'ar' => $request->description_ar,
        ];

        $product->update([
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
            'description' => json_encode($description, JSON_UNESCAPED_UNICODE),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'is_featured' => $request->input('is_featured', 0)
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                File::delete('storage/' . $product->image->path);
                $product->image()->delete();
            }

            $path = $request->file('image')->store('uploads', 'custom');
            $product->image()->create([
                'path' => $path,
            ]);
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $img->store('uploads', 'custom');
                $product->image()->create([
                    'path' => $path,
                    'type' => 'gallery'
                ]);
            }
        }

        return response()->json([
            'message' => 'Product updated successfully!'
        ], 200);


        // flash()->info('Product updated successfully!');
        // return redirect()->route('admin.products.index', ['page' => $request->page]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Gate::denies('delete-product')) {
            return abort(403, 'Don\'t have Permission');
        }
        if ($product->image) {
            File::delete('storage/' . $product->image->path);
        }
        foreach ($product->gallery as $img) {
            File::delete('storage/' . $img->path);
        }
        $product->image()->delete();
        $product->gallery()->delete();
        $product->delete();

        flash()->success('Product deleted successfully!');
        return redirect()->route('admin.products.index');
    }

    function delete_img($id)
    {
        $img = Image::find($id);
        File::delete('storage/' . $img->path);
        return Image::destroy($id);
    }
}
