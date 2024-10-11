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
        ])->whereIn('id', $cartIds)->where('id_user', $user->id)->get();

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


    public function purchasedOrders(Request $request)
    {
        $id_user = Auth::id();
        if (!$id_user) {
            return $this->jsonResponse('Bạn chưa đăng nhập');
        }
        $orders = Order::with('orderDetail')
            ->where('id_user', $id_user)
            ->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Không có đơn hàng nào'], 404);
        }

        if ($request->has('cancel_id')) {
            $cancel_id = $request->input('cancel_id');
            $order = $orders->where('id', $cancel_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
            } else {
                if ($order->status == 'Đã xác nhận') {
                    return response()->json(['message' => 'Đơn hàng đã xác nhận, không thể huỷ'], 400);
                }
                if ($order->status == 'Đã huỷ') {
                    return response()->json(['message' => 'Đơn hàng đã bị huỷ trước đó'], 400);
                }
                if ($order->status == 'Đang giao') {
                    return response()->json(['message' => 'Đơn hàng đang giao đến bạn, không thể huỷ'], 400);
                }

                if ($order->status == 'Giao hàng thành công') {
                    return response()->json(['message' => 'Đơn hàng đã giao thành công, không thể huỷ'], 400);
                }

                if ($order->status == 'Giao hàng thất bại') {
                    return response()->json(['message' => 'Đơn hàng đã giao thất bại, không thể huỷ'], 400);
                }

                if ($order->status == 'Hoàn thành') {
                    return response()->json(['message' => 'Đơn hàng đã hoàn thành, không thể huỷ'], 400);
                }


                if ($order->status == 'Chờ xác nhận') {
                    $order->status = 'Đã huỷ';
                    $order->save();
                    return response()->json(['message' => 'Đơn hàng đã được hủy thành công']);
                }
            }
        }
        return response()->json($orders);
    }
}
