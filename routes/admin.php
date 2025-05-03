<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::middleware('auth', 'is_admin', 'verified')->prefix(LaravelLocalization::setLocale())->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('index');


        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'settings_save']);
        Route::get('/delete-site-logo', [AdminController::class, 'delete_logo']);

        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'profile_save']);
        Route::post('/check-password', [AdminController::class, 'check_password'])->name('check_password');


        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);

        Route::get('/delete-image/{id?}',[ProductController::class, 'delete_img'])->name('delete_img');

        Route::get('/orders',[AdminController::class, 'orders'])->name('orders');
        Route::get('/notifications',[AdminController::class, 'notifications'])->name('notifications');


    });
});
