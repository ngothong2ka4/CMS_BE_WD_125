<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $minPrice = 0;
        $maxPrice = 500000;
        $sortPrice=$request->get('sortPrice','asc');
        $sortDirectionPrice = in_array($sortPrice, ['asc', 'desc']) ? $sortPrice : 'asc';

        $sortName = $request->get('sortName', 'asc');
        $sortDirectionName = in_array($sortName, ['asc', 'desc']) ? $sortName : 'asc';
        $products = Product::select('id', 'name', 'thumbnail', 'list_price', 'selling_price')
            ->whereBetween('selling_price', [$minPrice, $maxPrice])
             ->orderBy('selling_price', $sortDirectionPrice)
            ->orderBy('name', $sortDirectionName)
            ->paginate(10);
        return response()->json($products);
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


    public function filterProductsByPrice(Request $request) //Sắp xếp theo giá
    {
        $sort = $request->input('sort', 'asc');
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
            ->get(['id', 'name', 'thumbnail'])
            ->sortBy(function ($product) {
                return $product->variants->min('selling_price');
            });

        if ($request->input('sort') === 'desc') {
            $products = $products->reverse();
        }

        return response()->json($products, 200);
    }
}