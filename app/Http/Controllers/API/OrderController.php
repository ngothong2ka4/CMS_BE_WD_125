<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function listInformationOrder(Request $request) 
    {
        $cartIds = $request->input('cartIds');
        $user = Auth::user();

        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập ');
        }

        $productInCart = Cart::with([
            'variant.product',
            'variant.color',
            'variant.size'
            ])->whereIn('id',$cartIds)->where('id_user', $user->id)->get();
        
        if ($productInCart->isEmpty()) {
            return $this->jsonResponse('Không tìm thấy sản phẩm trong giỏ hàng.');
        }

        $totalAmount = $productInCart->map(function ($item) {
            return $item->variant->selling_price * $item->quantity;
        })->sum();
        
        $data = [
            "productInCart" => $productInCart,
            "totalAmount" => $totalAmount,
        ];
        return $this->jsonResponse('Lấy thông tin thành công', true, new OrderResource((object) $data));
    }

    public function payment(Request $request)
    {
        $id_user = Auth::id();
        $payment_role = $request->payment_role;

        $order = Order::create([
            'id_user' => $id_user,
            'recipient_name' => $request->recipient_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'recipient_address' => $request->recipient_address,
            'order_date' => now(),
            'total_payment' => $request->total_payment,
            'payment_role' => $payment_role,
            'status_payment' => 1,
            'status' => 1,
        ]);



        // OrderDetail::insert($data);


    }


}
