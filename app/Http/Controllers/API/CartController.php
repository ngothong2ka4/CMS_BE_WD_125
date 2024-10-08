<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductToCart(Request $request) {
        
        $productToCart = $request->all();


        CartController::create($productToCart);

    }
}
