<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    function index()
    {
        $categories = Category::with('products')->get();
        return view('website.index',compact('categories'));
    }

    function about()
    {
        return view('website.about');
    }

    function products()
    {
        $products = Product::latest('id')->Paginate(9);
        return view('website.products',compact('products'));
    }

    function category(Category $category)
    {
        $products = $category->products()->latest('id')->paginate(9);
        return view('website.category',compact('products','category'));
    }

    function product_single(Product $product)
    {
        return view('website.single-product',compact('product'));
    }

    function contact()
    {
        return view('website.contact');
    }
}
