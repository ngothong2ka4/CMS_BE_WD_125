<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\Variant;
use Auth;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // method: GET
    // require: authToken
    // API: /api/listInformationOrder
    // parram: (cart_ids(mảng id cart thanh toán) || id_variant,quantity)
    // example: 
    //          Mua ở giỏ hàng
    //          {
    //            "cart_ids" : [4,5]
    //          }
    //          mua ở trang chi tiết
    //          {
    //            "variantId" : 7
    //            "quantity" : 2
    //          }
    // response:200
    //             {
    //                 "status": true,  
    //                 "message": "Lấy thông tin thành công",
    //                 "data": order information
    //             }
    public function listInformationOrder(Request $request)
    {
        $cartIds = $request->input('cartIds'); 
        $variantId = $request->input('variantId'); 
        $quantity = $request->input('quantity'); 
        $user = Auth::user();

        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập');
        }

        $productInCart = []; 
        $totalAmount = 0; 

        if ($cartIds) {
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

            $productInCart = $productInCart->map(function ($item) {
                return [
                    'variant' => $item->variant,
                    'quantity' => $item->quantity,
                ];
            })->values()->toArray(); 
        } elseif ($variantId) {
            $product = Variant::with(['product', 'color', 'size'])
                ->where('id', $variantId)
                ->first();

            if (!$product) {
                return $this->jsonResponse('Không tìm thấy sản phẩm.');
            }

            $totalAmount = $product->selling_price * $quantity;

            $productInCart = [new OrderResource((object)[
                'variant' => $product,
                'quantity' => $quantity,
            ])]; 
        }

        $data = [
            "productpayment" => $productInCart,
            "totalAmount" => $totalAmount,
        ];

        return $this->jsonResponse('Lấy thông tin thành công', true, $data);
    }

    
    // method: POST
    // require: authToken
    // API: /api/payment
    // example: 
    //       Mua ở giỏ hàng(truyền payment_role thích hợp )
    //          {
    //              "cartIds": [6, 7],
    //              "recipient_name": "Nguyễn Văn A",
    //              "email": "example@example.com",
    //              "phone_number": "0123456789",
    //              "recipient_address": "123 Đường ABC, Quận 1, TP HCM",
    //              "note": "Giao hàng vào buổi chiều",
    //              "total_payment": 500000,
    //              "payment_role": payment_role
    //          }
    //        mua ở trang chi tiết(truyền payment_role thích hợp )
    //          {
    //              "variantId": 5,
    //              "quantity": 2,
    //              "recipient_name": "Nguyễn Văn A",
    //              "email": "example@example.com",
    //              "phone_number": "0123456789",
    //              "recipient_address": "123 Đường ABC, Quận 1, TP HCM",
    //              "note": "Giao hàng vào buổi chiều",
    //              "total_payment": 200000,
    //              "payment_role": payment_role
    //          }
    // response:200
    //             {
    //                 "status": true,  
    //                 "message": "Lấy thông tin thành công",
    //                 "data": order information
    //             }
    public function payment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập');
        }

        $data = $request->all();

        try {
            DB::beginTransaction();

            if (!empty($data['cartIds'])) {

                $res = $this->processCartPayment($data, $user->id);
                if ($res['payment_role'] == 2) {
                    $url = $this->createPaymentUrl($res);
                    return$this->jsonResponse('Đặt hàng thành công',true, $url);
                }

                return $this->jsonResponse('Đặt hàng thành công',true,data: $res);
            } elseif (!empty($data['variantId']) && !empty($data['quantity'])) {

                $res = $this->processDirectPayment($data, $user->id);
                if ($res['payment_role'] == 2) {
                    $url = $this->createPaymentUrl($res);
                    return$this->jsonResponse('Đặt hàng thành công',true, $url);
                }

                return $this->jsonResponse('Đặt hàng thành công',true,$res);
            } else {
                return $this->jsonResponse('Thiếu dữ liệu cần thiết để thanh toán');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Đã xảy ra lỗi trong quá trình thanh toán');
        }
    }

    private function processCartPayment($data, $userId)
    {
        $productPayment = Cart::with(['variant.product'])
            ->whereIn('id', $data['cartIds'])
            ->where('id_user', $userId)
            ->get();

        $order = Order::create([
            'id_user' => $userId,
            'recipient_name' => $data['recipient_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'recipient_address' => $data['recipient_address'],
            'note' => $data['note'],
            'total_payment' => $data['total_payment'],
            'payment_role' => $data['payment_role'],
            'status_payment' => Order::STATUS_PAYMENT_PENDING,
            'status' => Order::STATUS_PENDING,
        ]);

        $insertData = $productPayment->map(function ($cart) use ($order) {
            return [
                'id_order' => $order->id,
                'id_product' => $cart->variant->id_product,
                'id_variant' => $cart->variant->id,
                'import_price' => $cart->variant->import_price,
                'list_price' => $cart->variant->list_price,
                'selling_price' => $cart->variant->selling_price,
                'product_name' => $cart->variant->product->name,
                'product_image' => $cart->variant->product->thumbnail,
                'quantity' => $cart->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        OrderDetail::insert($insertData);
        Cart::whereIn('id', $data['cartIds'])->delete(); 
        DB::commit();
        
        return [
            'id_order' => $order->id,
            'payment_role' => $order->payment_role,
            'totalAmount' => $order->total_payment,
        ];
    }

    private function processDirectPayment($data, $userId)
    {
        $variant = Variant::with('product')->find($data['variantId']);
        if (!$variant) {
            return $this->jsonResponse('Sản phẩm không tồn tại', false);
        }

        $order = Order::create([
            'id_user' => $userId,
            'recipient_name' => $data['recipient_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'recipient_address' => $data['recipient_address'],
            'note' => $data['note'],
            'total_payment' => $data['total_payment'],
            'payment_role' => $data['payment_role'],
            'status_payment' => Order::STATUS_PAYMENT_PENDING,
            'status' => Order::STATUS_PENDING,
        ]);

        $insertData = [
            'id_order' => $order->id,
            'id_product' => $variant->id_product,
            'id_variant' => $variant->id,
            'import_price' => $variant->import_price,
            'list_price' => $variant->list_price,
            'selling_price' => $variant->selling_price,
            'product_name' => $variant->product->name,
            'product_image' => $variant->product->thumbnail,
            'quantity' => $data['quantity'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        OrderDetail::create($insertData);
        DB::commit();
        
        return [
            'id_order' => $order->id,
            'payment_role' => $order->payment_role,
            'totalAmount' => $order->total_payment,
        ];
    }

    public function createPaymentUrl($res)
    {

        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURNURL');
        $vnp_TmnCode = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASHSECRET');

        $vnp_TxnRef = $res['id_order'];
        $vnp_OrderInfo = "Thanh toán hoá đơn";
        $vnp_OrderType = "Shine Shop";
        $vnp_Amount = $res['totalAmount'] * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);

        $query = "";
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $hashdata = rtrim($hashdata, '&');
        $query = rtrim($query, '&');

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;
        }

        \Log::info('Hash Data: ' . $hashdata);
        \Log::info('Secure Hash: ' . $vnpSecureHash);
        \Log::info('Payment URL: ' . $vnp_Url);

        return $vnp_Url;
    }

    // method: GET
    // require: authToken
    // API: /api/paymentResult

    public function paymentResult(Request $request)
    {
        // $vnp_SecureHash = $request->input('vnp_SecureHash');
        // $vnp_HashSecret = env('VNP_HASHSECRET');

        // \Log::debug('Received vnp_SecureHash: ' . $vnp_SecureHash);
        // \Log::debug('VNP_HASHSECRET from .env: ' . $vnp_HashSecret);
        // \Log::debug('Request all params: ', $request->all());

        // $params = $request->except('vnp_SecureHash');
        // ksort($params);

        // $hashData = http_build_query($params);
        // \Log::debug('Generated hashData: ' . $hashData);

        // $vnpSecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        // \Log::debug('Generated vnpSecureHash for comparison: ' . $vnpSecureHash);

        $orderId = $request->input('vnp_TxnRef');
        \Log::debug('Order ID from vnp_TxnRef: ' . $orderId);
        $order = Order::find($orderId);

        if (!$order) {
            \Log::error('Order not found with ID: ' . $orderId);
            return $this->jsonResponse(message: 'Đơn hàng không tồn tại');
        }

        // if ($request->input('vnp_ResponseCode') == '00' && $vnpSecureHash == $vnp_SecureHash) {
        if ($request->input('vnp_ResponseCode') == '00') {
            $order->status_payment = Order::STATUS_PAYMENT_COMPLETED;
            $order->save();
            \Log::info("Thanh toán thành công cho đơn hàng ID: " . $orderId);
            return $this->jsonResponse('Thanh toán thành công!', true, $order);
        } else {
            $order->status_payment = Order::STATUS_PAYMENT_CANCELED;
            $order->save();
            \Log::warning("Thanh toán thất bại cho đơn hàng ID: " . $orderId);
            return $this->jsonResponse('Thanh toán thất bại', false, $order);
        }
    }


    public function cancelOrder(Request $request)
    {
        $id_order = $request->id;
        $note = $request->note;
        $id_user = Auth::id();

        if (!$note) {
            return $this->jsonResponse('Vui lòng nhập lý do huỷ đơn hàng !!');
        }

        $order = Order::where('id', $id_user)->find($id_order);

        if (!$order || $order->status != Order::STATUS_PENDING) {
            return $this->jsonResponse('Không thể huỷ đơn hàng này!');
        }

        $order->update(["status" => Order::STATUS_CANCELED]);

        OrderHistory::create([
            'id_order' => $id_order,
            'from_status' => Order::STATUS_PENDING,
            'to_status' => Order::STATUS_CANCELED,
            'note' => $note,
            'id_user' => $id_user,
            'at_date_time' => now(),
        ]);

        return $this->jsonResponse('Huỷ đơn hàng thành công', true);
    }

    public function listStatusOrderHistory(Request $request)
    {
        $id_order = $request->id;
        $id_user = Auth::id();

        $orderHistory = OrderHistory::where('id_order', $id_order)->orWhere('id_user', $id_user)->get();

        if (!$orderHistory) {
            return $this->jsonResponse('Không tìm thấy lịch sử đơn hàng này!');
        }

        return $this->jsonResponse('Lấy lịch sử thay đổi trạng thái đơn hàng thành công', true, $orderHistory);
    }

    public function purchasedOrders(Request $request)
    {

        $id_user = Auth::id();
        $note = $request->note;
        if (!$id_user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập']);
        }
        $orders = Order::with(['orderDetail' => function ($query) {
            $query->select('id', 'id_order', 'id_product', 'id_variant', 'import_price', 'list_price', 'selling_price', 'product_name', 'product_image', 'quantity')
                ->with(['productVariant' => function ($query) {
                    $query->select('id', 'id_attribute_color', 'id_attribute_size')
                        ->with(['color' => function ($query) {
                            $query->select('id', 'name');
                        }, 'size' => function ($query) {
                            $query->select('id', 'name');
                        }]);
                }]);
        }])
            ->select('id', 'id_user', 'recipient_name', 'email', 'phone_number', 'recipient_address', 'note', 'total_payment', 'payment_role', 'status_payment', 'status')
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
                if ($order->status == 2) {
                    return response()->json(['message' => 'Đơn hàng đã xác nhận, không thể huỷ'], 400);
                }
                if ($order->status == 7) {
                    return response()->json(['message' => 'Đơn hàng đã bị huỷ trước đó'], 400);
                }
                if ($order->status == 3) {
                    return response()->json(['message' => 'Đơn hàng đang giao đến bạn, không thể huỷ'], 400);
                }

                if ($order->status == 4) {
                    return response()->json(['message' => 'Đơn hàng đã giao thành công, không thể huỷ'], 400);
                }

                if ($order->status == 5) {
                    return response()->json(['message' => 'Đơn hàng đã giao thất bại, không thể huỷ'], 400);
                }

                if ($order->status == 6) {
                    return response()->json(['message' => 'Đơn hàng đã hoàn thành, không thể huỷ'], 400);
                }


                if ($order->status == 1) {
                    if (empty($note)) {
                        return response()->json(['message' => 'Lý do huỷ không được để trống'], 400);
                    }
                    $order->status = 7;
                    // $order->note = $note;
                    OrderHistory::create([
                        'id_order' => $order->id,
                        'from_status' => 1,
                        'to_status' => 7,
                        'note' => $note,
                        'id_user' => $id_user,
                        'created_at' => now(),
                    ]);
                    $order->save();
                    return response()->json(['message' => 'Đơn hàng đã được hủy thành công với lý do: ' . $note]);
                }
            }
        }

        return response()->json($orders);
    }
}
