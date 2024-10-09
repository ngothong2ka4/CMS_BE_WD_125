<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AuthController as LoginController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\product\ProductColorController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\product\ProductSizeController;
use App\Http\Controllers\product\ProductVariantController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController as LoginController;
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



// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/signup', function () {
//     return view('auth.signup');
// })->name('signup');

// Route::get('/forgot', function () {
//     return view('auth.forgot');
// })->name('forgot');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'postLogin']);

// Route::get('/signup', [LoginController::class, 'register'])->name('signup');
// Route::post('/signup', [LoginController::class, 'postRegister']);

Route::get('/forgot', [LoginController::class, 'forgot'])->name('forgot');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('/user', UserController::class);
    Route::patch('/user/status/{id}', [UserController::class, 'status'])->name('user_status');

    Route::prefix('products')->group(function () {
        Route::resource('/product_management', ProductController::class);
        Route::resource('/product_color', ProductColorController::class);
        Route::resource('/product_size', ProductSizeController::class);
        Route::get('/variant/{id}', [ProductVariantController::class, 'delete']);
        Route::get('/{id}/image', [ProductVariantController::class, 'destroy'])->name('delImage');
    });

    });
});
