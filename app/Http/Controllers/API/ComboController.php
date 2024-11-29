<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\ComboResource;
use App\Http\Resources\Product\VariantResource;
use App\Jobs\SendEmailAfterOrder;
use App\Models\Combo;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Variant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComboController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $combos = Combo::all();
        return response()->json($combos, 200);
    }

    public function detailCombos($id)
    {
        $combo = Combo::with([
            'products.variants.color',
            'products.variants.size',
        ])->find($id);

        if (!$combo) {
            return $this->jsonResponse('Không tìm thấy combo');
        }

        return $this->jsonResponse('Success', true, new ComboResource($combo));
    }


    // method: GET
    // require: authToken
    // API: /api/listInformationOrderCombo
    // parram: (cart_ids(mảng id cart thanh toán) || id_variant,quantity)
    // example:
    // {
    //     "comboId": 3,
    //     "quantity": 2,
    //     "variantIds": {
    //         "9": 15,     => 9 là id_product, 15 là id_variant của product 9
    //         "10": 17     => 10 là id_product, 17 là id_variant của product 10
    //     }
    // }
    // response:200
    //             {
    //                 "status": true,
    //                 "message": "Lấy thông tin thành công",
    //                 "data": order information
    //             }
    public function listInformationOrder(Request $request)
    {
        $comboId = $request->input('comboId');
        $quantity = $request->input('quantity');
        $variantIds = $request->input('variantIds');
        $user = Auth::user();

        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập');
        }

        $totalAmount = 0;

        if ($comboId) {
            $combo = Combo::find($comboId);

            if (!$combo) {
                return $this->jsonResponse('Không tìm thấy sản phẩm.');
            }

            // Kiểm tra variant_ids hợp lệ
            $selectedProducts = $combo->products->map(function ($product) use ($variantIds) {
                $variantId = $variantIds[$product->id] ?? null; // Lấy variant_id cho sản phẩm
                $selectedVariant = $product->variants->where('id', $variantId)->first();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail' => $product->thumbnail,
                    'selectedVariant' => $selectedVariant ? new VariantResource($selectedVariant) : null,
                    'quantity' => 1,
                ];
            });

            $totalAmount = $combo->price * $quantity;
        }

        $data = [
            'productpayment' => [
                'id' => $combo->id,
                'name' => $combo->name,
                'image' => $combo->image,
                'price' => $combo->price,
                'quantity' => $quantity,
                'description' => $combo->description,
                'products' => $selectedProducts,
            ],
            'totalAmount' => $totalAmount,
            'user' => $user,
        ];

        return $this->jsonResponse('Lấy thông tin thành công', true, $data);
    }


    // method: POST
    // require: authToken
    // API: /api/paymentCombo
    // example:
    //          {
    //              "comboId":3,
    //              "quantity": 2,
    //              "voucherId": 1,
    //              "variantIds": {
    //                  "9": 15,
    //                  "10": 17
    //              },
    //              "recipient_name": "Nguyễn Văn A",
    //              "email": "example@example.com",
    //              "phone_number": "0123456789",
    //              "recipient_address": "123 Đường ABC, Quận 1, TP HCM",
    //              "note": "Giao hàng vào buổi chiều",
    //              "total_payment": 200000,
    //              "discount_amount": 10000,
    //              "payment_role": payment_role
    //          }
    // response:200
    //             {
    //                 "status": true,
    //                 "message": "Đặt hàng thành công",
    //                 "data": order information
    //             }
    public function payment(OrderRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập');
        }

        $data = $request->all();

        $voucher = !empty($data['voucherId']) ? Voucher::find($data['voucherId']) : null;

        try {
            DB::beginTransaction();

            if ($request->used_accum > $user->accum_point) {
                return $this->jsonResponse('Điểm tiêu dùng không đủ');
            }

            if (!empty($data['variantIds']) && !empty($data['comboId']) && !empty($data['quantity'])) {

                $res = $this->processDirectPayment($data, $user->id);
                if ($res['payment_role'] == 2) {
                    $res['id_voucher'] = $voucher ? $voucher->id : null;
                    $res['email'] = $data['email'];
                    $url = $this->createPaymentUrl($res);
                    return $this->jsonResponse('Đặt hàng thành công', true, $url);
                }

                $information = [
                    'order' => $res['order'],
                    'orderDetails' => $res['order_details'],
                ];

                if ($voucher) {
                    $voucher->incrementUsage($user->id);
                }
                SendEmailAfterOrder::dispatch(
                    'emails.information-order',
                    $information,
                    $data['email'],
                    'Thông tin đơn hàng'
                );

                return $this->jsonResponse('Đặt hàng thành công', true, $res);
            } else {
                return $this->jsonResponse('Thiếu dữ liệu cần thiết để thanh toán');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->jsonResponse('Dữ liệu không hợp lệ', false, $e->errors());
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    private function processDirectPayment($data, $userId)
    {
        $order = Order::create([
            'id_user' => $userId,
            'recipient_name' => $data['recipient_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'recipient_address' => $data['recipient_address'],
            'note' => $data['note'],
            'used_accum' => $data['used_accum'] ?? 0,
            'total_payment' => $data['total_payment'],
            'discount_amount' => $data['discount_amount'] ?? 0,
            'discount_value' => ($data['used_accum'] ?? 0) * 1000 + ($data['discount_amount'] ?? 0),
            'payment_role' => $data['payment_role'],
            'status_payment' => Order::STATUS_PAYMENT_PENDING,
            'status' => Order::STATUS_PENDING,
        ]);

        $user = User::find($userId);
        $user->update(['accum_point' => $user->accum_point - $order->used_accum]);

        $orderDetails = [];
        foreach ($data['variantIds'] as $productId => $variantId) {
            // Lấy thông tin biến thể từ bảng Variant dựa trên $variantId
            $variant = Variant::find($variantId);
            if (!$variant) {
                throw new \Exception('Sản phẩm không tồn tại.');
            }
            if ($variant->quantity - $data['quantity'] < 0) {
                throw new \Exception('Sản phẩm ' . $variant->product->name . ' không đủ hàng trong kho.');
            }

            if ($variant) { // Kiểm tra nếu variant tồn tại
                $insertData = [
                    'id_order' => $order->id,
                    'id_product' => $variant->id_product,
                    'id_variant' => $variantId,
                    'import_price' => $variant->import_price,
                    'list_price' => $variant->list_price,
                    'selling_price' => $variant->selling_price,
                    'product_name' => $variant->product->name,
                    'product_image' => $variant->product->thumbnail,
                    'quantity' => $data['quantity'], // vì mỗi biến thể trong 1 combo chỉ được mua 1
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Chèn dữ liệu vào OrderDetail
                OrderDetail::create($insertData);
                $orderDetails[] = $insertData;

                $quantityInStock = $variant->quantity - 1;
                $variant->update([
                    "quantity" => $quantityInStock
                ]);
            }
        }
        DB::commit();

        return [
            'id_order' => $order->id,
            'payment_role' => $order->payment_role,
            'totalAmount' => $order->total_payment,
            'discount_amount' => $order->discount_amount,
            'order_details' => $orderDetails,
            'order' => $order,
        ];
    }
    public function createPaymentUrl($res)
    {
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURNURL');
        $vnp_TmnCode = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASHSECRET');

        $vnp_TxnRef = $res['id_order'];
        $vnp_OrderInfo = serialize([
            'vnp_VoucherId' => $res['id_voucher'],
            'vnp_email' => $res['email']
        ]);
        $vnp_OrderType = "Shine Shop";
        $vnp_Amount = $res['totalAmount'] * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "VNBANK";
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
            "vnp_TxnRef" => $vnp_TxnRef,
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
        $value = unserialize(urldecode($request->input('vnp_OrderInfo')));
        $orderId = $request->input('vnp_TxnRef');
        \Log::debug('Order ID from vnp_TxnRef: ' . $orderId);
        $order = Order::with(['orderDetail', 'user'])->find($orderId);

        if (!$order) {
            \Log::error('Order not found with ID: ' . $orderId);
            return $this->jsonResponse(message: 'Đơn hàng không tồn tại');
        }

        // if ($request->input('vnp_ResponseCode') == '00' && $vnpSecureHash == $vnp_SecureHash) {
        if ($request->input('vnp_ResponseCode') == '00') {
            $order->status_payment = Order::STATUS_PAYMENT_COMPLETED;
            $order->save();

            $information = [
                'order' => $order,
                'orderDetails' => $order->orderDetail->toArray(),
            ];

            $voucher = Voucher::find($value['vnp_VoucherId']);
            if ($voucher) {
                $voucher->incrementUsage(Auth::id());
            }

            SendEmailAfterOrder::dispatch(
                'emails.information-order',
                $information,
                $value['vnp_email'],
                'Thông tin đơn hàng'
            );

            \Log::info("Thanh toán thành công cho đơn hàng ID: " . $orderId);
            return $this->jsonResponse('Thanh toán thành công!', true, $order);
        } else {
            $order->status_payment = Order::STATUS_PAYMENT_PENDING;
            $order->status = Order::STATUS_CANCELED;
            $order->save();
            $user = User::find($order->id_user);
            $user->update(['accum_point' => $user->accum_point + $order->used_accum]);
            $variantDatas = $order->orderDetail->mapWithKeys(function ($detail) {
                return [$detail->id_variant => $detail->quantity];
            })->toArray();

            if (!empty($variantDatas)) {
                foreach ($variantDatas as $key => $value) {
                    Variant::where('id', $key)
                        ->increment('quantity', $value);
                }
            }

            \Log::warning("Thanh toán thất bại cho đơn hàng ID: " . $orderId);
            return $this->jsonResponse('Thanh toán thất bại', false, $order);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
