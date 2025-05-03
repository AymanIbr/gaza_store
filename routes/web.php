<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// service container => These are the values ​​that are passed to functions.
// facade =>Private classes in Laravel in general

// provider => Public Service Provider

// Route::name('site.')->controller(SiteController::class)->group(function () {
//     Route::get('/','index')->name('index');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// test notification
Route::get('/send', [NotificationController::class, 'send']);



// Magic Method

require __DIR__.'/auth.php';
