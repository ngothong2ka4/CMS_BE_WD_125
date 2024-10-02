<?php

use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\product\ProductColorController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\product\ProductSizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::get('/forgot', function () {
    return view('auth.forgot');
})->name('forgot');


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::resource('category', CategoryController::class);

    Route::prefix('products')->group(function () {
        Route::resource('/product_size', ProductColorController::class);
        Route::resource('/product_color', ProductColorController::class);
        Route::resource('/product_size', ProductSizeController::class);
    });

    // });
});
