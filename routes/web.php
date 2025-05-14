<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebSiteController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::get('/', function () {
//     return view('welcome');
// });


// service container => These are the values ​​that are passed to functions.
// facade =>Private classes in Laravel in general
// provider => Public Service Provider
Route::prefix(LaravelLocalization::setLocale())->group(function () {


Route::name('site.')->controller(WebSiteController::class)->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/about-us', 'about')->name('about');
    Route::get('/products', 'products')->name('products');
    Route::get('/category/{category:slug}', 'category')->name('category');
    Route::get('/products/{product:slug}', 'product_single')->name('product_single');
    Route::get('contact-us', 'contact')->name('contact');

  Route::get('/cart', function () {
    return view('website.cart');
});

Route::resource('cart',CartController::class);


});




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// test notification
Route::get('/send', [NotificationController::class, 'send']);

});


// Magic Method

require __DIR__ . '/auth.php';
