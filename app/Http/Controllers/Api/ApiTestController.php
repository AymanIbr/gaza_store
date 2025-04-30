<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTestController extends Controller
{
    function test_products()
    {
        $products = Http::get('https://dummyjson.com/products')->json();
        $products = $products['products'];
        // dd($products);
        return view('dashboard.api.products',compact('products'));
    }

    function weather() {
        return view('dashboard.api.weather');
    }
}
