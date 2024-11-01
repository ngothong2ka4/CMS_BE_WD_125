<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductDetailResource;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = Auth::id();
        if (!$id_user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
        } else {
            $favoriteProduct = FavoriteProduct::with(['product' => function ($query) {
                $query->select('id', 'name', 'thumbnail');
            }, 'product.variants' => function ($query) {
                $query->select('id_product', 'selling_price', 'list_price')
                    ->whereIn('id_product', function ($subQuery) {
                        $subQuery->select('id_product')
                            ->from('variants')
                            ->whereNull('deleted_at')
                            ->groupBy('id_product')
                            ->havingRaw('selling_price = MIN(selling_price)');
                    });
            }])
                ->where('id_user', auth()->id())
                ->select('id', 'id_user', 'id_product')
                ->get();
            return response()->json($favoriteProduct, 200);
            if ($favoriteProduct->isEmpty()) {
                return response()->json(['message' => 'Không có sản phẩm yêu thích nào'], 404);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_user = Auth::id();
        if (!$id_user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
        } else {
            $exists = Product::where('id', $request->product_id)->exists();
            if (!$exists) {
                return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
            }
            FavoriteProduct::firstOrCreate([
                'id_user' => auth()->id(),
                'id_product' => $request->product_id,
            ]);
            return response()->json(['message' => 'Sản phẩm đã được thêm vào yêu thích'], 200);
        }
    }


    public function isFavorite(Request $request)
    {
        $id_user = Auth::id();
        if (!$id_user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
        } else {
            $product_id = $request->input('product_id');
            $isFavorite = FavoriteProduct::where('id_user', $id_user)
                ->where('id_product', $product_id)
                ->exists();

            return response()->json([
                'is_favorite' => $isFavorite
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
    public function destroy(Request $request, string $productId)
    {
        if ($request->isMethod('DELETE')) {
            $deletedRows = FavoriteProduct::where('id_user', auth()->id())
                ->where('id_product', $productId)
                ->delete();

            if ($deletedRows === 0) {
                return response()->json(['message' => 'Sản phẩm không có trong danh sách yêu thích'], 404);
            }
            return response()->json(['message' => 'Sản phẩm đã được xóa khỏi yêu thích'], 200);
        }
    }
}
