<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\product_color\StoreRequest;
use App\Http\Requests\product_color\UpdateRequest;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productColors = ProductColor::all();
        return view('product.product_color.index', compact('productColors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // toastr()->success('Data has been saved successfully!');
        // toastr()->error('An error has occurred please try again later.');
        // toastr()->warning('An error has occurred please try again later.');
        return view('product.product_color.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            ProductColor::create($request->all());
            DB::commit();
            toastr()->success('Thêm mới thành công!');
            return redirect()->route('product_color.index');
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductColor $productColor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductColor $productColor)
    {
        return view('product.product_color.edit', compact('productColor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ProductColor $productColor)
    {
        try {
            DB::beginTransaction();
            $productColor->update($request->all());
            DB::commit();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('product_color.index');
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductColor $productColor)
    {
        $productColor->delete();
        toastr()->success('Xoá thành công!');
        return redirect()->route('product_color.index');
    }
}
