<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Auth;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductToCart(Request $request) 
    {
        try {
            $data = $request->all();
            $data['id_user'] = Auth::id();

            DB::beginTransaction();
                $cart = Cart::create($data);
            DB::commit();

            return $this->jsonResponse('Thêm vào giỏ hàng thành công', true, $cart);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }

    public function deleteProductInCart(Request $request) 
    {
        try {
            $user = Auth::id();
            $productInCart = Cart::find($request->id);

            if (!$productInCart || $productInCart->id_user != $user) {
                return $this->jsonResponse('Bạn không có sản phẩm này trong giỏ hàng');
            }
    
            $productInCart->delete();
    
            return $this->jsonResponse('Xoá sản phẩm trong giỏ hàng thành công', true);
        }catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }

    public function listProductInCart() 
    {
        try {
            $user = Auth::id();

            if (!$user) {
                return $this->jsonResponse('Bạn chưa đăng nhập ');
            }

            $productInCart = Cart::with([
                'variant.product',
                'variant.color',
                'variant.size',
                ])->where("id_user", $user)->get();
            
            return $this->jsonResponse('Lấy sản phẩm trong giỏ hàng thành công', 
                                        true, 
                                        CartResource::collection($productInCart));
        }catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }
}
