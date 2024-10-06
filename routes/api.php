<?php

use App\Http\Controllers\API\CategoryController;
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

Route::get('/products/filter', [ProductController::class, 'filterProductsByPrice']);
// giá cao -> thấp : /api/products/filter?sort=desc
// giá thấp -> cao : /api/products/filter?sort=asc
Route::get('/products', [ProductController::class, 'index']);

Route::get('/detailProduct/{id}',[ProductController::class, 'detailProduct']);
Route::get('/relatedProducts/{id}',[ProductController::class, 'relatedProducts']);
