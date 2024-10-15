<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Stone;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.product_management.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $materials = Material::all();
        $stones = Stone::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        return view(
            'product.product_management.add',
            compact('categories', 'materials', 'stones', 'colors', 'sizes')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        DB::beginTransaction();
       
        $request->validate([
            'name' => 'required|max:255|min:6|regex:/^[\p{L}\p{N}\s]+$/u|unique:products,name,',
            'thumbnail' => 'required|file|image|max:2048',
            'id_category' => 'required',
            'id_materials' => 'required',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
            'name.regex' => 'Tên sản phẩm chỉ được chứa chữ cái, số và khoảng trắng.',
            'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

            'thumbnail.required' => 'Hình sản phẩm là bắt buộc.',
            'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
            'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

            'id_category.required' => 'Danh mục của sản phẩm là bắt buộc.',
            'id_materials.required' => 'Chất liệu của sản phẩm là bắt buộc.',

        ]);
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $nameImage =  time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move('img/products', $nameImage);
            $path='img/products/' . $nameImage;
        }
        $data_pro = [
            'name' => $request->name,
            'id_category' => $request->id_category,
            'id_materials' => $request->id_materials,
            'id_stones' => $request->id_stones,
            'description' => $request->description,

            'thumbnail' => url('img/products/' . $nameImage),

        ];
        if(!$request->id_attribute_color ){
            toastr()->error('Sản phẩm phải có ít nhất một biến thể!');
            return redirect()->back();
        }

        $product = Product::create($data_pro);


        if ($request->hasFile('link_image')) {
            foreach($request->file('link_image') as $key => $image){
            // $image = $request->file('link_image');
            $nameImage = time()."_".$image->getClientOriginalName();
            $image->move('img/products/slide/', $nameImage);
            $path = '/img/products/slide/'. $nameImage;
            $data = [
                'id_product' => $product->id,
                'link_image' => url($path),
            ];
             
           ProductImage::create($data);
        }
        }


        if ($request->id_attribute_color) {
            foreach ($request->id_attribute_color as $key => $color) {

                if ($request->hasFile('image_color')) {
                    $image = $request->file('image_color')[$key];  // Lấy file image_color tại vị trí $key
                    $image_Color =$product->id .time() . "_" . $key . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                    $image->move('img/products/variant', $image_Color);
                    $path = 'img/products/variant/' . $image_Color;
                }

                $data_var = [
                    'id_product' => $product->id,
                    'id_attribute_color' => $color,
                    'id_attribute_size' => $request->id_attribute_size[$key] ? $request->id_attribute_size[$key] : 1,
                    'import_price' => $request->import_price[$key],
                    'list_price' => $request->list_price[$key],
                    'selling_price' => $request->selling_price[$key],
                    'quantity' => $request->quantity[$key],
                    'image_color' => url($path),
                ];
                Variant::create($data_var);
            }
        }


        DB::commit();
        toastr()->success('Thêm mới sản phẩm thành công!');
        return redirect()->route('product_management.index');
    } catch (\Exception $e) {
        toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        return redirect()->back();
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $variants = Variant::where('id_product', $id)->get();
        $categories = Category::all();
        $materials = Material::all();
        $stones = Stone::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        $images = ProductImage::where('id_product', $id)->get();
        return view(
            'product.product_management.show',
            compact('product', 'variants', 'categories', 'materials', 'stones', 'colors', 'sizes', 'images')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $variants = Variant::where('id_product', $id)->get();
        $categories = Category::all();
        $materials = Material::all();
        $stones = Stone::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        $images = ProductImage::where('id_product', $id)->get();
        return view(
            'product.product_management.edit',
            compact('product', 'variants', 'categories', 'materials', 'stones', 'colors', 'sizes','images')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
        DB::beginTransaction();
        $product = Product::findOrFail($id);
        $img_old = $product->thumbnail;
        $request->validate([
            'name' => 'required|max:255|min:6|regex:/^[\p{L}\p{N}\s]+$/u|unique:products,name,' . $id,
            'thumbnail' => 'nullable|file|image|max:2048',
            'id_category' => 'required',
            'id_materials' => 'required',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
            'name.regex' => 'Tên sản phẩm chỉ được chứa chữ cái, số và khoảng trắng.',
            'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

            'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
            'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

            'id_category.required' => 'Danh mục của sản phẩm là bắt buộc.',
            'id_materials.required' => 'Chất liệu của sản phẩm là bắt buộc.',

        ]);
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $nameImage =$product->id .time() . "_" . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move('img/products', $nameImage);
            $path = 'img/products/' . $nameImage;

            if (file_exists(public_path($img_old))) {
                unlink(public_path($img_old));
            }
        } else {
            $path = $img_old;
        }

        $data_pro = [
            'name' => $request->name,
            'id_category' => $request->id_category,
            'id_materials' => $request->id_materials,
            'id_stones' => $request->id_stones,
            'description' => $request->description,
            'thumbnail' => url($path),
        ];
        if(!$request->new_id_attribute_color ){
            toastr()->error('Sản phẩm phải có ít nhất một biến thể!');
            return redirect()->back();
        }

        $product->update($data_pro);

        if ($request->hasFile('link_image')) {
            foreach($request->file('link_image') as $key => $image){
            // $image = $request->file('link_image');
            $nameImage = time()."_".$image->getClientOriginalName();
            $image->move('img/products/slide/', $nameImage);
            $path = 'img/products/slide/'. $nameImage;
            $data = [
                'id_product' => $product->id,
                'link_image' => url($path),
            ];
             
           ProductImage::create($data);
        }
        }

        if ($request->id_var) {
            foreach ($request->id_var as $key => $item) {
                $variant = Variant::findOrFail($item);
                $imgcolor_old = $variant->image_color;

                if ($request->hasFile('image_color') && isset($request->file('image_color')[$key])) {
                    $image = $request->file('image_color')[$key];
                    $colorImage = $product->id .time() . "_" . $key . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                    $image->move('img/products/variant', $colorImage);

                    $path = 'img/products/variant/' . $colorImage;


                    if (file_exists(($imgcolor_old))) {
                        unlink(($imgcolor_old));
                    }
                } else {
                    $path = $imgcolor_old;
                }

                $data_var = [

                    'id_attribute_color' => $request->id_attribute_color[$key],
                    'id_attribute_size' => $request->id_attribute_size[$key] ? $request->id_attribute_size[$key] : 1,
                    'import_price' => $request->import_price[$key],
                    'list_price' => $request->list_price[$key],
                    'selling_price' => $request->selling_price[$key],
                    'quantity' => $request->quantity[$key],
                    'image_color' => url($path),
                ];

                $variant->update($data_var);
            }

        }
        if ($request->new_id_attribute_color) {
            foreach ($request->new_id_attribute_color as $key => $color) {

                if ($request->hasFile('new_image_color') && isset($request->file('new_image_color')[$key])) {
                    $image = $request->file('new_image_color')[$key];
                    $image_Color = $product->id .time() . "_" . $key . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                    $image->move('img/products/variant', $image_Color);
                    $path = 'img/products/variant/' . $image_Color;
                }

                $data_var = [
                    'id_product' => $product->id,
                    'id_attribute_color' => $color,
                    'id_attribute_size' => $request->new_id_attribute_size[$key] ? $request->new_id_attribute_size[$key] : 1 ,
                    'import_price' => $request->new_import_price[$key],
                    'list_price' => $request->new_list_price[$key],
                    'selling_price' => $request->new_selling_price[$key],
                    'quantity' => $request->new_quantity[$key],
                    'image_color' => url($path),
                ];
                // dd($path);
                Variant::create($data_var);
            }
        }

        DB::commit();
        toastr()->success('Cập nhật sản phẩm thành công!');
        return redirect()->back();
    } catch (\Exception $e) {
        toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        return redirect()->back();
    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->variants()->delete();
        $product->delete();

        toastr()->success('Xoá thành công!');
        return redirect()->route('product_management.index');
    }
}
