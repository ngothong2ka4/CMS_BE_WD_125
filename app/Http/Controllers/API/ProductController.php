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
        $sortPrice=$request->get('sortPrice','asc');
        $sortDirectionPrice = in_array($sortPrice, ['asc', 'desc']) ? $sortPrice : 'asc';

        $sortName = $request->get('sortName', 'asc');
        $sortDirectionName = in_array($sortName, ['asc', 'desc']) ? $sortName : 'asc';
        $products = Product::select('id', 'name', 'thumbnail', 'list_price', 'selling_price')
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
}
