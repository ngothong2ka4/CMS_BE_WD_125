<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use App\Models\Variant;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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
        try {
            $data = $request->validate([
                'name' => 'required|max:25|unique:attribute_size,name,',
            ], [
                'name.required' => 'Tên kích thước là bắt buộc.',
                'name.max' => 'Tên kích thước không được vượt quá 25 ký tự.',
                'name.unique' => 'Tên kích thước đã tồn tại, vui lòng chọn tên khác.',
            ]);
            ProductSize::create($data);
            toastr()->success('Thêm mới kích thước thành công!');
            return redirect()->route('product_size.index');
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back();
        }
       
    
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
        try {
        $data = $request->validate([
            'name' => 'required|max:25|unique:attribute_size,name,' . $ProductSize->id,
        ], [
            'name.required' => 'Tên kích thước là bắt buộc.',
            'name.max' => 'Tên kích thước không được vượt quá 25 ký tự.',
            'name.unique' => 'Tên kích thước đã tồn tại, vui lòng chọn tên khác.',
        ]);

        $ProductSize->update($data);
        toastr()->success('Chỉnh sửa kích thước thành công!');
        return redirect()->route('product_size.index');

    } catch (\Exception $e) {
        toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        return redirect()->back();
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $ProductSize)
    { 
        if(!Variant::where('id_attribute_size',$ProductSize->id)->first() == []){
            toastr()->error('Không thể xóa: Bản ghi đã được sử dụng!');
            return redirect()->back();
        }else{
            $ProductSize->delete();
            toastr()->success('Xoá thành công!');
            return redirect()->route('product_size.index');
        }
       
    }
}
