<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\RelatedProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //tất cả sản phẩm
    {
        $products = Product::with(['variants' => function ($query) {
            $query->select('id_product', 'selling_price', 'list_price')
                ->whereIn('id_product', function ($subQuery) {
                    $subQuery->select('id_product')
                        ->from('variants')
                        ->whereNull('deleted_at')
                        ->groupBy('id_product')
                        ->havingRaw('selling_price = MIN(selling_price)');
                });
        }])
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'thumbnail']);

        return response()->json($products, 200);
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
    public function getNewProducts() //5 sản phẩm mới nhất
    {
        $products = Product::with(['variants' => function ($query) {
            $query->select('id_product', 'selling_price', 'list_price')
                ->whereIn('id_product', function ($subQuery) {
                    $subQuery->select('id_product')
                        ->from('variants')
                        ->whereNull('deleted_at')
                        ->groupBy('id_product')
                        ->havingRaw('selling_price = MIN(selling_price)');
                });
        }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(['id', 'name', 'thumbnail']);

        return response()->json($products, 200);
    }


    // public function filterProductsByPrice(Request $request) //Sắp xếp theo giá
    // {
    //     $sort = $request->input('sort', 'asc');
    //     $products = Product::with(['variants' => function ($query) {
    //         $query->select('id_product', 'selling_price', 'list_price')
    //             ->whereIn('id_product', function ($subQuery) {
    //                 $subQuery->select('id_product')
    //                     ->from('variants')
    //                     ->whereNull('deleted_at')
    //                     ->groupBy('id_product')
    //                     ->havingRaw('selling_price = MIN(selling_price)');
    //             });
    //     }])
    //         ->get(['id', 'name', 'thumbnail'])
    //         ->sortBy(function ($product) {
    //             return $product->variants->min('selling_price');
    //         });

    //     if ($request->input('sort') === 'desc') {
    //         $products = $products->reverse();
    //     }

    //     return response()->json($products, 200);
    // }


    // public function filterProductsByName(Request $request) //Sắp xếp theo tên
    // {
    //     $sort = $request->input('sort', 'asc');
    //     $products = Product::with(['variants' => function ($query) {
    //         $query->select('id_product', 'selling_price', 'list_price')
    //             ->whereIn('id_product', function ($subQuery) {
    //                 $subQuery->select('id_product')
    //                     ->from('variants')
    //                     ->whereNull('deleted_at')
    //                     ->groupBy('id_product')
    //                     ->havingRaw('selling_price = MIN(selling_price)');
    //             });
    //     }])
    //         ->get(['id', 'name', 'thumbnail'])
    //         ->sortBy('name');

    //     if ($request->input('sort') === 'desc') {
    //         $products = $products->reverse();
    //     }

    //     return response()->json($products, 200);
    // }


    public function filterProducts(Request $request)
    {
        // Lấy tham số 'sort_by' để xác định sắp xếp theo tên hay giá
        $sortBy = $request->input('sort_by', 'price'); // Mặc định sắp xếp theo giá
        $sortOrder = $request->input('sort', 'asc'); // Mặc định sắp xếp tăng dần

        // Truy vấn sản phẩm
        $products = Product::with(['variants' => function ($query) {
            $query->select('id_product', 'selling_price', 'list_price')
                ->whereIn('id_product', function ($subQuery) {
                    $subQuery->select('id_product')
                        ->from('variants')
                        ->whereNull('deleted_at')
                        ->groupBy('id_product')
                        ->havingRaw('selling_price = MIN(selling_price)');
                });
        }])
            ->get(['id', 'name', 'thumbnail']);

        // Sắp xếp sản phẩm
        if ($sortBy === 'price') {
            // Sắp xếp theo giá bán thấp nhất của biến thể
            $products = $products->sortBy(function ($product) {
                return $product->variants->min('selling_price');
            });
        } elseif ($sortBy === 'name') {
            // Sắp xếp theo tên
            $products = $products->sortBy('name');
        }

        // Kiểm tra nếu sắp xếp giảm dần
        if ($sortOrder === 'desc') {
            $products = $products->reverse();
        }

        $page = $request->input('page', 1); // Số trang
        $perPage = $request->input('per_page', 12); // Số mục mỗi trang
        $total = count($products); // Tổng số sản phẩm
        $totalPages = ceil($total / $perPage); // Tính tổng số trang

        // Chia sản phẩm thành các trang
        $products = $products->slice(($page - 1) * $perPage, $perPage)->values();

        return response()->json([
            'current_page' => $page,
            'total_pages' => $totalPages,
            'data' => $products,
        ], 200);
    }


    // method: GET
    // API: /api/detailProduct/{id}
    // parram: (id)
    // response:200
    //            {
    //                "status": true,
    //                "message": "Success",
    //                "data": productDetail
    //            } 

    public function detailProduct($id)
    {
        $product = Product::with([
            'variants.color',
            'variants.size'
        ])->find($id);

        if (!$product) {
            return $this->jsonResponse('Không tìm thấy sản phẩm');
        }

        return $this->jsonResponse('Success', true, new ProductDetailResource($product));
    }

    // method: GET
    // API: /api/relatedProducts/{id category}
    // parram: (id category)
    // response:200
    //            {
    //                "status": true,
    //                "message": "Success",
    //                "data": relatedProducts
    //            } 

    public function relatedProducts($id)
    {
        $relatedProducts = Product::where('id_category', $id)->with('variants')->limit(5)->get();
        if (!$relatedProducts) {
            return $this->jsonResponse('Không có sản phẩm liên quan');
        }
        return $this->jsonResponse('Success', true, RelatedProductsResource::collection($relatedProducts));
    }
}
