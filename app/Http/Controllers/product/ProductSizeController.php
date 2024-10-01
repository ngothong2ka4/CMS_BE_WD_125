<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = ProductSize::all();
        return view('product.product_size.index',compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.product_size.add');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:25|min:1|regex:/^[\p{L}\p{N}\s]+$/u|unique:attribute_size,name,',
        ], [
            'name.required' => 'Tên kích thước là bắt buộc.',
            'name.max' => 'Tên kích thước không được vượt quá 25 ký tự.',
            'name.min' => 'Tên kích thước phải có ít nhất 1 ký tự.',
            'name.regex' => 'Tên kích thước chỉ được chứa chữ cái, số và khoảng trắng.',
            'name.unique' => 'Tên kích thước đã tồn tại, vui lòng chọn tên khác.',
        ]);
        ProductSize::create($data);
        return redirect()->route('product_size.index')->with('success', 'Thêm kích thước thành công');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSize $ProductSize)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSize $ProductSize)
    {
        return view('product.product_size.edit', compact('ProductSize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSize $ProductSize)
    {
        $data = $request->validate([
            'name' => 'required|max:25|min:1|regex:/^[\p{L}\p{N}\s]+$/u|unique:attribute_size,name,' . $ProductSize->id,
        ], [
            'name.required' => 'Tên kích thước là bắt buộc.',
            'name.max' => 'Tên kích thước không được vượt quá 25 ký tự.',
            'name.min' => 'Tên kích thước phải có ít nhất 1 ký tự.',
            'name.regex' => 'Tên kích thước chỉ được chứa chữ cái, số và khoảng trắng.',
            'name.unique' => 'Tên kích thước đã tồn tại, vui lòng chọn tên khác.',
        ]);

        $ProductSize->update($data);

        return redirect()->route('product_size.index')->with('success', 'Chỉnh sửa kích thước thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $ProductSize)
    {
        $ProductSize->delete();

        return redirect()->route('product_size.index')->with('success', 'Xóa kích thước thành công!');
    }
}
