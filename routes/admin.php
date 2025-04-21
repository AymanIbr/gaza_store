<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::middleware('auth','is_admin','verified')->prefix(LaravelLocalization::setLocale())->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('categories', CategoryController::class);
    });
});
