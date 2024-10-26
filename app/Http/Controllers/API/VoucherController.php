<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    // method: POST
    // API: //vouchers/apply
    // parram: (voucher_code, order_amount, user_id)
    // response:200
    //              {
    //                  "status": true,
    //                  "message": "Voucher áp dụng thành công",
    //                  "data": {
    //                      "voucherId": 1,
    //                      "discount": 10000,
    //                      "final_amount": 90000
    //              }
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string',
            'order_amount' => 'required|numeric|min:0',
            'user_id' => 'required|integer',
        ]);

        $voucher = Voucher::where('code', $request->voucher_code)->first();

        if (!$voucher) {
            return $this->jsonResponse('Mã voucher không hợp lệ');
        }

        if (!$voucher->isValid($request->order_amount, $request->user_id)) {
            return response()->json(['error' => 'Voucher không hợp lệ hoặc không đủ điều kiện'], 400);
        }

        $discount = $voucher->calculateDiscount($request->order_amount);

        $data = [
            'voucherId' => $voucher->id,
            'discount' => $discount,
            'final_amount' => $request->order_amount - $discount,
        ];

        return $this->jsonResponse('Voucher áp dụng thành công', true, $data);
    }

    public function listVoucher()
    {
        $user = Auth::user();

        $vouchers = Voucher::join('voucher_user', 'vouchers.id', '=', 'voucher_user.voucher_id')
            ->where('voucher_user.user_id', $user->id)
            ->where('vouchers.status', '=', 1)
            ->whereColumn('voucher_user.usage_count', '<', 'vouchers.usage_per_user')
            ->select('vouchers.code','vouchers.description','vouchers.start_date','vouchers.end_date', 'voucher_user.usage_count')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $vouchers
        ]);
    }
}
