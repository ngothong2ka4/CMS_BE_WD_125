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
        $user = Auth::user();

        $vouchers = Voucher::leftJoin('voucher_user', 'vouchers.id', '=', 'voucher_user.voucher_id')
            ->where('vouchers.status', '=', 1)
            ->where(function ($query) use ($user) {
                $query->where('voucher_user.user_id', $user->id)
                    ->where('voucher_user.usage_count', '<', 'vouchers.usage_per_user')
                    ->orWhereNull('voucher_user.user_id');
            })
            ->select('vouchers.code', 'vouchers.description', 'vouchers.start_date', 'vouchers.end_date', 'voucher_user.usage_count')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $vouchers
        ]);
    }
    public function detailProduct($id, $userID)
    {
        $product = Product::with([
            'variants.color',
            'variants.size',
            'images',
            'material',
            'stone',
            'comments' => function ($query) {
                $query->where('status', 1);
            },
            'comments.user',
            'comments.variant.color',
            'comments.variant.size',
        ])->find($id);
    
        if (!$product) {
            return $this->jsonResponse('Không tìm thấy sản phẩm');
        }
    
        if (!$userID) {
            return response()->json(['error' => 'Người dùng không tồn tại'], 400);
        }
    
        // Tăng số lượt xem sản phẩm bằng cách tạo một bản ghi mới trong `product_views`
        ProductView::create([
            'id_product' => $id,
            'viewed_at' => now(),
            'id_user' => $userID,
        ]);
    
        // Tạo mảng chứa các liên kết ảnh
        $imageLinks = $product->images ? $product->images->pluck('link_image')->toArray() : [];
    
        foreach ($product->variants as $variant) {
            if (!empty($variant->image_color)) {
                $imageLinks[] = $variant->image_color;
            }
        }
    
        // Tạo danh sách ảnh cho slide
        $product->slideImages = collect($imageLinks)->map(function ($link) {
            return ['link_image' => $link];
        });
    
        // Tính toán đánh giá trung bình
        $averageRating = $product->comments->avg('rating');
        $product->average_rating = $averageRating ? number_format($averageRating, 2) : null;
    
        return $this->jsonResponse('Success', true, new ProductDetailResource($product));
    }
    
}
