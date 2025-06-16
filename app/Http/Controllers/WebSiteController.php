<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\Review;
use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    function index()
    {
        $categories = Category::with('products')->get();

        // get product view by user ip
        $ip = request()->ip();
        $productView = ProductView::with('product')->where('ip_address', $ip)->latest()->paginate(6);
        return view('website.index', compact('categories', 'productView'));
    }

    function about()
    {
        return view('website.about');
    }

    function products()
    {
        $products = Product::latest('id')->Paginate(9);
        return view('website.products', compact('products'));
    }

    function category(Category $category)
    {
        $products = $category->products()->latest('id')->paginate(9);
        return view('website.category', compact('products', 'category'));
    }

    function product_single(Request $request, Product $product)
    {
        // $ip = $_SERVER['REMOTE_ADDR'];
        $ip =  $request->ip();
        ProductView::firstOrCreate([
            'product_id' => $product->id,
            'ip_address' => $ip,
        ]);

        // rating count
        $ratings = Review::where('product_id', $product->id)->get();
        // rating sum
        $ratings_sum = Review::where('product_id', $product->id)->sum('stars_rated');
        if ($ratings->count() > 0) {
            $ratings_value = $ratings_sum / $ratings->count();
        } else {
            $ratings_value = 0;
        }
        // user rating
        $user_rating = Review::where('product_id', $product->id)->where("ip_address",$ip)->first();
        return view('website.single-product', compact('product', 'ratings', 'ratings_value','user_rating'));
    }

    function contact()
    {
        return view('website.contact');
    }
}
