<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategory = Category::get();
        return view('category.index', compact('listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $params = $request->validate([
                'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:categories,name,',
            ], [
                'name.required' => 'Tên danh mục là bắt buộc.',
                'name.max' => 'Tên danh mục không được vượt quá 25 ký tự.',
                'name.min' => 'Tên danh mục phải có ít nhất 3 ký tự.',
                'name.regex' => 'Tên danh mục chỉ được chứa chữ cái, số và khoảng trắng.',
                'name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
            ]);

            Category::create($params);
            toastr()->success('Thêm danh mục thành công!');
            return redirect()->route('category.index');
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $category = Category::findOrFail($id);
            $params = $request->validate([
                'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:categories,name,' . $category->id,
            ], [
                'name.required' => 'Tên danh mục là bắt buộc.',
                'name.max' => 'Tên danh mục không được vượt quá 25 ký tự.',
                'name.min' => 'Tên danh mục phải có ít nhất 3 ký tự.',
                'name.regex' => 'Tên danh mục chỉ được chứa chữ cái, số và khoảng trắng.',
                'name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
            ]);

            $category->update($params);
            toastr()->success('Cập nhật danh mục thành công!');
            return redirect()->route('category.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lấy tất cả các lỗi xác thực và hiển thị qua Toastr
            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }

            // Quay lại trang trước với dữ liệu cũ và lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function destroy(Request $request, string $id)
    {
        if ($request->isMethod('DELETE')) {

            $category = Category::query()->findOrFail($id);

            $category->delete();
            Product::where('id_category', $category->id)
                    ->update(['id_category' => 0]);
            toastr()->success('Xoá danh mục thành công!');

            return redirect()->route('category.index');
        }
    }

    // public function destroy(Request $request, string $id)
    // {
    //     // Kiểm tra nếu có action từ request
    //     $action = $request->input('action'); // Lấy hành động từ frontend
    //     $category = Category::findOrFail($id);

    //     switch ($action) {
    //         case '1':
    //             // Giữ nguyên sản phẩm nhưng không phân loại
    //             Product::where('id_category', $category->id)
    //                 ->update(['id_category' => null]);
    //             break;

    //         case '2':
    //             // Xóa toàn bộ sản phẩm trong danh mục
    //             Product::where('id_category', $category->id)
    //                 ->delete();
    //             break;

    //         default:
    //             toastr()->error('Hành động không hợp lệ!');
    //             return redirect()->route('category.index');
    //     }

    //     // Xóa danh mục
    //     $category->delete();

    //     toastr()->success('Xóa danh mục và xử lý sản phẩm thành công!');
    //     return redirect()->route('category.index');
    // }
}
