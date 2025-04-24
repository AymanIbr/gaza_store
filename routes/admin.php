<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::middleware('auth', 'is_admin', 'verified')->prefix(LaravelLocalization::setLocale())->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'profile_save']);
        Route::post('/check-password', [AdminController::class, 'check_password'])->name('check_password');


        Route::resource('categories', CategoryController::class);
    });
});
