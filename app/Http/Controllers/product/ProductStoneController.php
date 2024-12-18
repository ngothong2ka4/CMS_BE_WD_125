<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stone;
use Illuminate\Http\Request;

class ProductStoneController extends Controller
{
    public function index()
    {
        
    }
    public function create()
    {
        return view('product.product_tag.product_stone.add');
    }
    public function store(Request $request)
    {
        try {
            $params = $request->validate([
                'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:categories,name,',
            ], [
                'name.required' => 'Tên đá là bắt buộc.',
                'name.max' => 'Tên đá không được vượt quá 25 ký tự.',
                'name.min' => 'Tên đá phải có ít nhất 3 ký tự.',
                'name.regex' => 'Tên đá chỉ được chứa chữ cái, số và khoảng trắng.',
                'name.unique' => 'Tên đá đã tồn tại, vui lòng chọn tên khác.',
            ]);

            Stone::create($params);
            toastr()->success('Thêm đá thành công!');
            return redirect()->route('product_tag.index');
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function show(string $id)
    {
        $stone = Stone::findOrFail($id);
        return view('product.product_tag.product_stone.edit', compact('stone'));
    }
    public function update(Request $request, $id)
    {
        try {
            $stone = Stone::findOrFail($id);
            $params = $request->validate([
                'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:categories,name,' . $stone->id,
            ], [
                'name.required' => 'Tên chất liệu là bắt buộc.',
                'name.max' => 'Tên chất liệu không được vượt quá 25 ký tự.',
                'name.min' => 'Tên chất liệu phải có ít nhất 3 ký tự.',
                'name.regex' => 'Tên chất liệu chỉ được chứa chữ cái, số và khoảng trắng.',
                'name.unique' => 'Tên chất liệu đã tồn tại, vui lòng chọn tên khác.',
            ]);

            $stone->update($params);
            toastr()->success('Cập nhật chất liệu thành công!');
            return redirect()->route('product_tag.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lấy tất cả các lỗi xác thực và hiển thị qua Toastr
            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }

            // Quay lại trang trước với dữ liệu cũ và lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function destroy(Request $request,$id)
    {
        if ($request->isMethod('DELETE')) {
            if(!Product::where('id_stones',$id)->first() == []){
                toastr()->error('Không thể xóa: Bản ghi đã được sử dụng!');
                return redirect()->back();
            }else{
            $stone = Stone::query()->findOrFail($id);

            $stone->delete();
            toastr()->success('Xoá chất liệu thành công!');

            return redirect()->back();
            }
        }
    }
}
