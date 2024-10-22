<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
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

        $voucher->incrementUsage(Auth::id());

        $data = [
            'discount' => $discount,
            'final_amount' => $request->order_amount - $discount,
        ];

        return $this->jsonResponse('Voucher áp dụng thành công',true, $data);
    }
}
