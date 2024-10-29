<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        if (!$voucher->isValid()) {
            return $this->jsonResponse('Voucher không hợp lệ hoặc không đủ điều kiện');
        }

        $discount = $voucher->calculateDiscount($request->order_amount);

        $finalAmount = max(0, $request->order_amount - $discount);

        $data = [
            'voucherId' => $voucher->id,
            'discount' => $discount,
            'final_amount' => $finalAmount,
        ];

        return $this->jsonResponse('Voucher áp dụng thành công', true, $data);
    }

    public function listVoucher()
    {
        $now = Carbon::now();
        Voucher::where('end_date', '<', $now)
            ->where('status', 1)
            ->update(['status' => 2]);
        $user = Auth::user();

        $vouchers = Voucher::leftJoin('voucher_user', 'vouchers.id', '=', 'voucher_user.voucher_id')
            ->where('vouchers.status', '=', 1)
            ->where(function ($query) use ($user) {
                $query->where('voucher_user.user_id', $user->id)
                    ->whereRaw('voucher_user.usage_count < vouchers.usage_per_user')
                    ->orWhereNull('voucher_user.user_id');
            })
            ->select('vouchers.code', 'vouchers.description', 'vouchers.start_date', 'vouchers.end_date', 'voucher_user.usage_count', 'vouchers.usage_per_user')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $vouchers
        ]);
    }
}
