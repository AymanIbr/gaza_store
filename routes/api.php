<?php



// Api Test route

use App\Http\Controllers\Api\ApiTestController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;


// Test API

Route::get('test-products',[ApiTestController::class, 'test_products']);
Route::get('weather',[ApiTestController::class, 'weather']);



// API Project
    // php artisan make:con Api/ProductController -r --api

Route::apiResource('products',ProductController::class);






















//  DumyJson => https://dummyjson.com/
// open wether map



//  JSON

// {
//     "key" : "value",
//     "key" : "value",
//     "key" : "value",
//     "key" : "value",
// },
// {

//     "key" : "value",
//     "key" : "value",
// }


// A program that deals with databases
// tinker => php artisan tinker
// App\Models\Product::all()
