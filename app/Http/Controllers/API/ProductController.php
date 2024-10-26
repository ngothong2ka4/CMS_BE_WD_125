<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\Product\ListCommentResource;
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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $id_category = $request->input('id_category');
        $sortBy = $request->input('sort_by', 'price');
        $sortOrder = $request->input('sort', 'asc');
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
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");  // Tìm kiếm theo tên sản phẩm
            })
            ->when($id_category, function ($query, $id_category) {
                return $query->where('id_category', $id_category);  // Lọc theo danh mục
            })
            ->orderBy('created_at', 'desc')
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

    // public function productByCate(Request $request)
    // {
    //     $cate = $request->input('cate');

    //     $products_cate = Product::with(['variants' => function ($query) {
    //         $query->select('id_product', 'selling_price', 'list_price')
    //             // ->limit(1)
    //             ->whereIn('id_product', function ($subQuery) {
    //                 $subQuery->select('id_product')
    //                     ->from('variants')
    //                     ->whereNull('deleted_at')
    //                     ->groupBy('id_product')
    //                     ->havingRaw('selling_price = MIN(selling_price)');
    //             });
    //     }])
    //         ->where('id_category', $cate)
    //         ->get(['id', 'name', 'thumbnail']);

    //     return response()->json($products_cate, 200);
    // }

    // public function filterProducts(Request $request) // Lọc sản phẩm
    // {
    //     $sortBy = $request->input('sort_by', 'price');
    //     $sortOrder = $request->input('sort', 'asc');

    //     $products = Product::with(['variants' => function ($query) {
    //         $query->select('id_product', 'selling_price', 'list_price')
    //             // ->limit(1)
    //             ->whereIn('id_product', function ($subQuery) {
    //                 $subQuery->select('id_product')
    //                     ->from('variants')
    //                     ->whereNull('deleted_at')
    //                     ->groupBy('id_product')
    //                     ->havingRaw('selling_price = MIN(selling_price)');
    //             });
    //     }])
    //         ->get(['id', 'name', 'thumbnail']);

    //     if ($sortBy === 'price') {
    //         $products = $products->sortBy(function ($product) {
    //             return $product->variants->min('selling_price');
    //         });
    //     } elseif ($sortBy === 'name') {
    //         $products = $products->sortBy('name');
    //     }

    //     if ($sortOrder === 'desc') {
    //         $products = $products->reverse();
    //     }

    //     $page = $request->input('page', 1);
    //     $perPage = $request->input('per_page', 12);
    //     $total = count($products);
    //     $totalPages = ceil($total / $perPage);

    //     $products = $products->slice(($page - 1) * $perPage, $perPage)->values();

    //     return response()->json([
    //         'current_page' => $page,
    //         'total_pages' => $totalPages,
    //         'data' => [
    //             'products' => $products,  // Danh sách sản phẩm
    //         ],
    //     ], 200);
    // }


    // public function searchProductsByName(Request $request)
    // {
    //     $query = $request->input('name');
    //     if (!$query) {
    //         return response()->json([
    //             'message' => 'Tên sản phẩm không được bỏ trống!'
    //         ], 400);
    //     }

    //     $products = Product::with(['variants' => function ($query) {
    //         $query->select('id_product', 'selling_price', 'list_price')
    //             // ->limit(1)
    //             ->whereIn('id_product', function ($subQuery) {
    //                 $subQuery->select('id_product')
    //                     ->from('variants')
    //                     ->whereNull('deleted_at')
    //                     ->groupBy('id_product')
    //                     ->havingRaw('selling_price = MIN(selling_price)');
    //             });
    //     }])
    //         ->where('name', 'like', '%' . $query . '%')
    //         ->get(['id', 'name', 'thumbnail']);

    //     if ($products->isEmpty()) {
    //         return response()->json([
    //             'message' => 'Không tìm thấy sản phẩm nào!'
    //         ], 404);
    //     }

    //     return response()->json($products, 200);
    // }



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
            },
            'comments.user'
        ])->find($id);

        if (!$product) {
            return $this->jsonResponse('Không tìm thấy sản phẩm');
        }

        $imageLinks = $product->images->pluck('link_image')->toArray();
        foreach ($product->variants as $variant) {
            if (!empty($variant->image_color)) {
                $imageLinks[] = $variant->image_color;
            }
        }

        $product->slideImages = collect($imageLinks)->map(function ($link) {
            return ['link_image' => $link];
        });

        $averageRating = $product->comments->avg('rating'); 
        $product->average_rating = $averageRating ? number_format($averageRating, 2) : null;
        
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

    // method: POST
    // API: /api/addCommentProduct
    // parram: (id_order, id_product, content,rating)
    // response:200
    //              {
    //                  "status": true,
    //                  "message": "Thêm đánh giá thành công",
    //                  "data": {
    //                      "id_product": 3,
    //                      "id_user": 3,
    //                      "content": "không biết nói gì",
    //                      "rating": 3,
    //                      "status": 1,
    //                      "updated_at": "2024-10-19T08:34:35.000000Z",
    //                      "created_at": "2024-10-19T08:34:35.000000Z",
    //                      "id": 1
    //                  }
    //              }

    public function addCommentProduct(StoreCommentRequest $request)
    {
        try {
            $user = Auth::user();
            $id_product = $request->id_product;
            $id_variant = $request->id_variant;
            $id_order = $request->id_order;
            if (!$user) {
                return $this->jsonResponse('Bạn phải đăng nhập mới có thể Đánh giá');
            }
            
            $hasPurchased = OrderDetail::whereHas('order', function ($query) use ($user,$id_order) {
                $query->where('id', $id_order)
                        ->where('id_user', $user->id)
                        ->where('status', 6)
                        ->where('status_payment', 2);
            })->where('id_product', $id_product)
                ->where('id_variant', $id_variant)
                ->exists();

            if (!$hasPurchased) {
                return $this->jsonResponse('Bạn cần phải mua sản phẩm này trước khi đánh giá.');
            }
            DB::beginTransaction();
                $comment = Comment::create([
                    'id_product' => $request->id_product,
                    'id_variant' => $request->id_variant,
                    'id_user' => $user->id,
                    'content' => $request->content,
                    'rating' => $request->rating ?? null, 
                    'status' => 1, 
                ]);
            DB::commit();

            return $this->jsonResponse('Thêm đánh giá thành công', true, $comment);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Có lỗi xảy ra');
        }
    }

    // method: GET
    // API: /api/listCommentUser
    // response:200
    //              {
    //                  "content": "đ biết nói gì",
    //                  "rating": 3,
    //                  "created_at": "2024-10-19T08:34:35.000000Z",
    //                  "product_name": "Nhẫn cưới Vàng 18K& Platinum 950 Kim cương tự nhiên",
    //                  "color": "xanh dương",
    //                  "size": "1.7"
    //              },...

    public function listCommentUser(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->jsonResponse('Bạn phải đăng nhập mới có thể xem Đánh giá');
            }

            $comments = Comment::with([
                'variant.product',
                'variant.color',
                'variant.size',
                ])
                ->where('id_user', $user->id)
                ->get();

            return $this->jsonResponse('Lấy danh sách đánh giá thành công', true, ListCommentResource::collection($comments));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Có lỗi xảy ra');
        }
    }
}
