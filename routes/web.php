<?php

use App\Common\Common;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\comment\CommentController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\AuthController as LoginController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\product\ProductColorController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\product\ProductMaterialController;
use App\Http\Controllers\product\ProductSizeController;
use App\Http\Controllers\product\ProductStoneController;
use App\Http\Controllers\product\ProductTagController;
use App\Http\Controllers\product\ProductVariantController;
use App\Http\Controllers\statistic\StatisticController;
use App\Http\Controllers\user\AdminController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\voucher\VoucherController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckStatusUser;
use App\Models\Material;
use Illuminate\Support\Facades\Route;

Common::autoUpdateStatus();
Common::deleteToken();
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



// Route::get('/test', function () {
//     return view('test');
// })->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::get('/forgot', function () {
    return view('auth.forgot');
})->name('forgot');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'postLogin']);

Route::get('/signup', [LoginController::class, 'register'])->name('signup');
Route::post('/signup', [LoginController::class, 'postRegister']);

Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('/forgot', [AuthController::class, 'sendPassword']);


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['namespace' => 'App\Http\Controllers'], function () {


    Route::middleware(['auth', AdminMiddleware::class, CheckStatusUser::class])->group(function () {
        Route::redirect('', 'dashboard');
        Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
        Route::resource('category', CategoryController::class);
        Route::resource('comment', CommentController::class);
        Route::patch('comment/status/{id}', [CommentController::class, 'status'])->name('comment_status');

        Route::post('/order/{id}', [OrderController::class, 'updateStatus']);

        Route::resource('order', OrderController::class);
        Route::resource('statistic', StatisticController::class);
        Route::prefix('user')->group(function () {
            Route::resource('/user', UserController::class);
            Route::patch('/user/status/{id}', [UserController::class, 'status'])->name('user_status');
            Route::resource('/admin', AdminController::class);
            Route::patch('/admin/status/{id}', [AdminController::class, 'status'])->name('admin_status');
            Route::get('/admin/changepassword/{id}', [AdminController::class, 'changePassword']);
            Route::post('/admin/changepassword/{id}', [AdminController::class, 'updatechangePassword'])->name('changePassword');
        });


        Route::prefix('products')->group(function () {
            Route::resource('/product_management', ProductController::class);
            Route::resource('/product_color', ProductColorController::class);
            Route::resource('/product_size', ProductSizeController::class);
            Route::get('/variant/{id}', [ProductVariantController::class, 'delete']);
            Route::get('/{id}/image', [ProductVariantController::class, 'destroy'])->name('delImage');
            Route::prefix('product_tag')->group(function () {
                Route::get('/', [ProductTagController::class, 'index'])->name('product_tag.index');
                Route::resource('material', ProductMaterialController::class);
                Route::resource('stone', ProductStoneController::class);
            });
        });

        Route::resource('voucher', VoucherController::class);

    });
});
