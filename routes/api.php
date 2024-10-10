<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('category',CategoryController::class);
// API sản phẩm mới (5 cái)
Route::get('/products/new', [ProductController::class, 'getNewProducts']);

Route::get('/products/search', [ProductController::class, 'searchProductsByName']);
Route::get('/products/filter_cate', [ProductController::class, 'productByCate']);
Route::get('/products/filter', [ProductController::class, 'filterProducts']);
// lọc theo giá: /api/products/filter?sort_by=price
// lọc theo tên : /api/products/filter?sort_by=name
Route::get('/products', [ProductController::class, 'index']);

Route::get('/detailProduct/{id}',[ProductController::class, 'detailProduct']);
Route::get('/relatedProducts/{id}',[ProductController::class, 'relatedProducts']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/addCommentProduct',[ProductController::class, 'addCommentProduct']);

    Route::get('/listCart',[CartController::class, 'listProductInCart']);
    Route::post('/addCart',[CartController::class, 'addProductToCart']);
    Route::delete('/deleteCart',[CartController::class, 'deleteProductInCart']);
    Route::delete('/deleteMutipleCart',[CartController::class, 'deleteMutipleProductInCart']);

    Route::put('/choseProductInCart',[CartController::class, 'choseProductInCart']);
    Route::get('/listInformationOrder',[OrderController::class, 'listInformationOrder']);

});