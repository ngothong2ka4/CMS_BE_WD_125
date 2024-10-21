<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class ProductMaterialController extends Controller
{
    public function index()
    {
      
    }
    public function create()
    {
        return view('product.product_tag.product_material.add');
    }
    public function store(Request $request)
    {
        try {
            $params = $request->validate([
                'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:categories,name,',
            ], [
                'name.required' => 'Tên chất liệu là bắt buộc.',
                'name.max' => 'Tên chất liệu không được vượt quá 25 ký tự.',
                'name.min' => 'Tên chất liệu phải có ít nhất 3 ký tự.',
                'name.regex' => 'Tên chất liệu chỉ được chứa chữ cái, số và khoảng trắng.',
                'name.unique' => 'Tên chất liệu đã tồn tại, vui lòng chọn tên khác.',
            ]);

            Material::create($params);
            toastr()->success('Thêm chất liệu thành công!');
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
        $material = Material::findOrFail($id);
        return view('product.product_tag.product_material.edit', compact('material'));
    }
    public function update(Request $request, $id)
    {
        try {
            $material = Material::findOrFail($id);
            $params = $request->validate([
                'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:categories,name,' . $material->id,
            ], [
                'name.required' => 'Tên chất liệu là bắt buộc.',
                'name.max' => 'Tên chất liệu không được vượt quá 25 ký tự.',
                'name.min' => 'Tên chất liệu phải có ít nhất 3 ký tự.',
                'name.regex' => 'Tên chất liệu chỉ được chứa chữ cái, số và khoảng trắng.',
                'name.unique' => 'Tên chất liệu đã tồn tại, vui lòng chọn tên khác.',
            ]);

            $material->update($params);
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

            $material = Material::query()->findOrFail($id);

            $material->delete();
            toastr()->success('Xoá chất liệu thành công!');

            return redirect()->back();
        }
    }
}
