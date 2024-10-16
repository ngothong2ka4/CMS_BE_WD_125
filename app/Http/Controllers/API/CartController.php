<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Variant;
use Auth;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // method: POST
    // require: authToken
    // API: /api/addCart
    // parram: (id_variant,quantity)
    // example: 
    //     {
    //         "id_variant": 9,
    //         "quantity": 10
        
    //     }
    // response:200
    //            {
    //                "status": true,
    //                "message": "Success",
    //                "data": cart
    //            } 
    public function addProductToCart(Request $request) 
    {
        try {
            $id_variant = $request->id_variant;
            $quantity = $request->quantity;
            $id_user = Auth::id();

            $variant = Variant::find($id_variant);
            if ($quantity > $variant->quantity) {
                return $this->jsonResponse('Sản phẩm ' . $variant->product->name . ' không đủ hàng trong kho.');
            }
    
            DB::beginTransaction();
            
            $cart = Cart::where('id_variant', $id_variant)
                        ->where('id_user', $id_user)
                        ->first();
    
            if (!$cart) {
                $cart = Cart::create([
                    'id_variant' => $id_variant,
                    'quantity' => $quantity,
                    'id_user' => $id_user,
                ]);
            } else {
                $newQuantity = $cart->quantity + $quantity;

                if ($newQuantity > $cart->variant->quantity) {
                    return $this->jsonResponse('Số lượng yêu cầu vượt quá số lượng có trong kho.');
                }

                $cart->quantity = $newQuantity;
                $cart->save();
            }
    
            DB::commit();
    
            return $this->jsonResponse('Thêm vào giỏ hàng thành công', true, $cart);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }

    // method: DELETE
    // require: authToken
    // API: /api/deleteCart
    // parram: (id_cart)
    // example: 
    //     {
    //         "id" : 6
    //     }
    // response:200
    //             {
    //                 "status": true,
    //                 "message": "Xoá sản phẩm trong giỏ hàng thành công",
    //                 "data": null
    //             }
    public function deleteProductInCart(Request $request) 
    {
        try {
            $userId = Auth::id();
            $productInCart = Cart::find($request->id);

            if (!$productInCart || $productInCart->id_user != $userId) {
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

    // method: DELETE
    // require: authToken
    // API: /api/deleteMutipleCart
    // parram: (cart_ids(mảng id cần xoá), id_user)
    // example: 
    //          {
    //            "cart_ids" :[4,5],
    //            "id_user" : 5
    //          }
    // response:200
    //             {
    //                 "status": true,
    //                 "message": "Xóa sản phẩm được chọn thành công",
    //                 "data": null
    //             }
    public function deleteMutipleProductInCart(Request $request){
        $cartIds = $request->input('cart_ids', []);
        $userId = Auth::id();
        $userIdCart =  $request->input('id_user');
        try {
            if ($userIdCart != $userId) {
                return $this->jsonResponse('Bạn không có sản phẩm này trong giỏ hàng');
            }

            if (empty($cartIds)) {
                return $this->jsonResponse('Không có sản phẩm nào được xoá!');
            }
    
            Cart::whereIn('id', $cartIds)->where('id_user', $userId)->delete();
            return $this->jsonResponse('Xóa sản phẩm được chọn thành công', true);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }

    // method: GET
    // require: authToken
    // API: /api/listCart
    // response:200
    //             {
    //                 "status": true,
    //                 "message": "Lấy sản phẩm trong giỏ hàng thành công",
    //                 "data": list cart
    //             }
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
    // method: PUT
    // require: authToken
    // API: /api/choseProductInCart
    // parram: (cartItems(mảng các product đã chọn và thay đổi số lượng cần xoá))
    // example:
    //          {
    //              "cartItems": [
    //                  {
    //                  "cart_id": 3,
    //                  "id_variant": 2, 
    //                  "quantity": 8
    //                  }
    //              ]
    //          }
    // response:200
    //             {
    //                 "status": true,
    //                 "message": "Cập nhật giỏ hàng thành công",
    //                 "data": null
    //             }
    public function choseProductInCart(Request $request) 
    {
        try {
            DB::beginTransaction();
            $cartItems = $request->input('cartItems');
            $userId = Auth::id();

            if (!$userId) {
                return $this->jsonResponse('Bạn chưa đăng nhập');
            }
    
            $valid = collect($cartItems)->every(function ($item) {
                $variant = Variant::find($item['id_variant']);
                return $variant && $item['quantity'] <= $variant->quantity;
            });
            
            if (!$valid) {
                return $this->jsonResponse('Số lượng sản phẩm không đủ.', false);
            }
            
            $data = collect($cartItems)->map(function ($item) use ($userId) {
                return [
                    'id' => $item['cart_id'],
                    'id_variant' => $item['id_variant'],
                    'id_user' => $userId,
                    'quantity' => $item['quantity'],
                ];
            })->toArray();
    
            Cart::upsert($data, ['id', 'id_user', 'id_variant'], ['quantity', 'updated_at']);
    
            DB::commit();
            return $this->jsonResponse('Cập nhật giỏ hàng thành công', true);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }
}
