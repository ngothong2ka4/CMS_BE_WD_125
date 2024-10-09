<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\RelatedProductsResource;
use App\Models\Comment;
use App\Models\OrderDetail;
use App\Models\Product;
use Auth;
use DB;
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
                // ->limit(1)
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

        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 12);
        $total = count($products);
        $totalPages = ceil($total / $perPage);

        $products = $products->slice(($page - 1) * $perPage, $perPage)->values();

        return response()->json([
            'current_page' => $page,
            'total_pages' => $totalPages,
            'data' => $products,
        ], 200);
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
                // ->limit(1)
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


    public function filterProducts(Request $request) // Lọc sản phẩm
    {
        $sortBy = $request->input('sort_by', 'price');
        $sortOrder = $request->input('sort', 'asc');
        $cate = $request->input('cate');

        $products_cate = Product::with(['variants' => function ($query) {
            $query->select('id_product', 'selling_price', 'list_price')
                // ->limit(1)
                ->whereIn('id_product', function ($subQuery) {
                    $subQuery->select('id_product')
                        ->from('variants')
                        ->whereNull('deleted_at')
                        ->groupBy('id_product')
                        ->havingRaw('selling_price = MIN(selling_price)');
                });
        }])
            ->where('id_category', $cate)
            ->get(['id', 'name', 'thumbnail']);

        $products = Product::with(['variants' => function ($query) {
            $query->select('id_product', 'selling_price', 'list_price')
                // ->limit(1)
                ->whereIn('id_product', function ($subQuery) {
                    $subQuery->select('id_product')
                        ->from('variants')
                        ->whereNull('deleted_at')
                        ->groupBy('id_product')
                        ->havingRaw('selling_price = MIN(selling_price)');
                });
        }])
            ->get(['id', 'name', 'thumbnail']);

        if ($sortBy === 'price') {
            $products = $products->sortBy(function ($product) {
                return $product->variants->min('selling_price');
            });
        } elseif ($sortBy === 'name') {
            $products = $products->sortBy('name');
        }

        if ($sortOrder === 'desc') {
            $products = $products->reverse();
        }

        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 12);
        $total = count($products);
        $totalPages = ceil($total / $perPage);

        $products = $products->slice(($page - 1) * $perPage, $perPage)->values();

        return response()->json([
            'current_page' => $page,
            'total_pages' => $totalPages,
            'data' => [
                'products' => $products,  // Danh sách sản phẩm
                'products_cate' => $products_cate  // Danh sách sản phẩm theo danh mục
            ],
        ], 200);
    }


    public function searchProductsByName(Request $request)
    {
        $query = $request->input('name');
        if (!$query) {
            return response()->json([
                'message' => 'Tên sản phẩm không được bỏ trống!'
            ], 400);
        }

        $products = Product::with(['variants' => function ($query) {
            $query->select('id_product', 'selling_price', 'list_price')
                // ->limit(1)
                ->whereIn('id_product', function ($subQuery) {
                    $subQuery->select('id_product')
                        ->from('variants')
                        ->whereNull('deleted_at')
                        ->groupBy('id_product')
                        ->havingRaw('selling_price = MIN(selling_price)');
                });
        }])
            ->where('name', 'like', '%' . $query . '%')
            ->get(['id', 'name', 'thumbnail']);

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy sản phẩm nào!'
            ], 404);
        }

        return response()->json($products, 200);
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
            'variants.size',
            'images',
            'material',
            'stone',
            'comments' => function ($query) {
                $query->where('status', 1);
            }
        ])->find($id);
        $imageLinks = $product->images->pluck('link_image')->toArray();
        foreach ($product->variants as $variant) {
            if (!empty($variant->image_color)) {
                $imageLinks[] = $variant->image_color;  
            }
        }
        
        $product->slideImages = collect($imageLinks)->map(function($link) {
            return ['link_image' => $link]; 
        });

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
        $currentProduct = Product::find($id);

        if (!$currentProduct) {
            return $this->jsonResponse('Sản phẩm không tồn tại', false);
        }

        $relatedProducts = Product::where('id_category', $currentProduct->id_category)
                                ->where('id', '!=', $id) 
                                ->with('variants')
                                ->limit(5)
                                ->get();

        return $this->jsonResponse('Success', true, RelatedProductsResource::collection($relatedProducts));
    }

    // public function addCommentProduct(Request $request)
    // {
    //     try {
    //         $user = Auth::user();
    //         $productId = $request->input('product_id');

    //         if (!$user) {
    //             return $this->jsonResponse('Bạn phải đăng nhập mới có thể bình luận');
    //         }

    //         $hasPurchased = OrderDetail::whereHas('order', function ($query) use ($user) {
    //             $query->where('id_user', $user->id)
    //                 ->where('status', 4); 
    //         })->where('product_id', $productId)->exists();

    //         if (!$hasPurchased) {
    //             return $this->jsonResponse('Bạn cần phải mua sản phẩm này trước khi bình luận.');
    //         }

    //         DB::beginTransaction();
    //             $comment = Comment::create($request->all());
    //         DB::commit();
    //         return $this->jsonResponse('Success', true,$comment);
    //     } catch (\Exception $exception) {
    //         DB::rollBack();
    //         \Log::error($exception->getMessage());
    //         return $this->jsonResponse('Common Exception');
    //     }
    // }
}
