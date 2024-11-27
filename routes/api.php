<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\VoucherController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Common\common;
use App\Http\Controllers\API\AdsServiceController;
use App\Http\Controllers\API\ComboController;
use App\Http\Controllers\API\FavoriteProductController;
use App\Http\Controllers\AuthController as ControllersAuthController;

common::autoUpdateStatus();
common::deleteToken();
common::autoStopAds();

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('forgotpassword', [AuthController::class, 'forgotPassword']);
Route::post('resetpassword/{token}', [AuthController::class, 'resetPassword']);
Route::get('/search-user', [AuthController::class, 'searchUser']);
Route::get('getConfig', [AdsServiceController::class,'getAllConfig']); // chạy quảng cáo ở trang chủ
Route::get('visits/{id}', [AdsServiceController::class,'visits']); // tăng lượt truy cập


Route::apiResource('category',CategoryController::class);
// API sản phẩm mới (5 cái)
Route::get('/products/new', [ProductController::class, 'getNewProducts']);
Route::get('/search-product', [ProductController::class, 'searchProduct']);
// Route::get('/products/search', [ProductController::class, 'searchProductsByName']);
// Route::get('/products/filter_cate', [ProductController::class, 'productByCate']);
// Route::get('/products/filter', [ProductController::class, 'filterProducts']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/detailProduct/{id}',[ProductController::class, 'detailProduct']);
Route::get('/relatedProducts/{id}',[ProductController::class, 'relatedProducts']);
Route::get('detailCombos/{id}',[ComboController::class, 'detailCombos']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/addCommentProduct',[ProductController::class, 'addCommentProduct']);
    Route::get('/listCommentUser',[ProductController::class, 'listCommentUser']);
    Route::get('/view',[ProductController::class,'getRecentViewedProducts']);


    Route::get('/listCart',[CartController::class, 'listProductInCart']);
    Route::post('/addCart',[CartController::class, 'addProductToCart']);
    Route::delete('/deleteCart',[CartController::class, 'deleteProductInCart']);
    Route::delete('/deleteMutipleCart',[CartController::class, 'deleteMutipleProductInCart']);

    Route::put('/choseProductInCart',[CartController::class, 'choseProductInCart']);
    Route::get('/listInformationOrder',[OrderController::class, 'listInformationOrder']);
    Route::get('/purchasedOrders',[OrderController::class, 'purchasedOrders']);
    Route::post('/payment',[OrderController::class, 'payment']);
    Route::get('/paymentResult',[OrderController::class, 'paymentResult']);
    Route::post('/cancelOrder',[OrderController::class, 'cancelOrder']);
    Route::get('/listStatusOrderHistory',[OrderController::class, 'listStatusOrderHistory']);

    Route::post('/vouchers/apply', [VoucherController::class, 'applyVoucher']);
    Route::get('/vouchers/list', [VoucherController::class, 'listVoucher']);
    
    Route::get('favoriteProduct/check', [FavoriteProductController::class, 'isFavorite']);
    Route::resource('favoriteProduct', FavoriteProductController::class);

    Route::post('updateUser', [AuthController::class, 'updateUser']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);

    // Route::post('addAdsService', [AdsServiceController::class,'addAdsService']); // đăng ký dịch vụ
    // Route::post('addConfig', [AdsServiceController::class,'addConfig']);  // chi tiết quảng cáo
    // Route::get('getAds', [AdsServiceController::class,'getConfigUser']); // chi tiết dịch vụ
    // Route::post('adsPayment', [AdsServiceController::class,'paymentResult']);

    Route::get('/listInformationOrderCombo',[ComboController::class, 'listInformationOrder']);
    Route::post('/paymentCombo',[ComboController::class, 'payment']);

    Route::resource('combo', ComboController::class);
    
});