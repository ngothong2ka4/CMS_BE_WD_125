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
        return view('product.product_management.add', 
        compact('categories','materials','stones','colors','sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|min:6|regex:/^[\p{L}\p{N}\s]+$/u|unique:products,name,',
            'thumbnail' => 'required|file|image|max:2048',
            'id_category' => 'required',
            'id_materials' => 'required',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.min' => 'Tên danh mục phải có ít nhất 6 ký tự.',
            'name.regex' => 'Tên danh mục chỉ được chứa chữ cái, số và khoảng trắng.',
            'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

            'thumbnail.required' => 'Hình sản phẩm là bắt buộc.',
            'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
            'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

            'id_category.required' => 'Danh mục của sản phẩm là bắt buộc.',
            'id_materials.required' => 'Chất liệu của sản phẩm là bắt buộc.',
            // 'id_stones.required' => 'Hình sản phẩm là bắt buộc.',

        ]);
       if($request->hasFile('thumbnail')){
        $image = $request->file('thumbnail');
        $nameImage = time().".".$image->getClientOriginalExtension();
        $image->move('img/products', $nameImage);
       }
        $data_pro = [
            'name' => $request->name,
            'id_category' => $request->id_category,
            'id_materials' => $request->id_materials,
            'id_stones' => $request->id_stones,
            'description' => $request->description,
            'thumbnail' => 'img/products/'.$nameImage,
        ];
       
        $product = Product::create($data_pro);
        if($request->id_attribute_color){
            foreach($request->id_attribute_color as $key => $color){
                $data_var = [
                    'id_product' => $product->id,
                    'id_attribute_color' => $color,
                    'id_attribute_size' => $request->id_attribute_size[$key],
                    'import_price' => $request->import_price[$key],
                    'list_price' => $request->list_price[$key],
                    'selling_price' => $request->selling_price[$key],
                    'quantity' => $request->quantity[$key],
                ];
    
                Variant::create($data_var);
            }
        }
      
  

       toastr()->success('Thêm mới sản phẩm thành công!');
       return redirect()->route('product_management.index');
       
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFAil($id);
        $variants = Variant::where('id_product',$id)->get();
        $categories = Category::all();
        $materials = Material::all();
        $stones = Stone::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        $images = ProductImage::where('id_product', $id)->get();
        return view('product.product_management.show', 
        compact('product','variants','categories','materials','stones','colors','sizes','images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFAil($id);
        $variants = Variant::where('id_product',$id)->get();
        $categories = Category::all();
        $materials = Material::all();
        $stones = Stone::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        return view('product.product_management.edit', 
        compact('product','variants','categories','materials','stones','colors','sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
        'name.min' => 'Tên danh mục phải có ít nhất 6 ký tự.',
        'name.regex' => 'Tên danh mục chỉ được chứa chữ cái, số và khoảng trắng.',
        'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

        'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
        'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

        'id_category.required' => 'Danh mục của sản phẩm là bắt buộc.',
        'id_materials.required' => 'Chất liệu của sản phẩm là bắt buộc.',
      
    ]);
   if($request->hasFile('thumbnail')){
    $image = $request->file('thumbnail');
    $nameImage = time().".".$image->getClientOriginalExtension();
    $image->move('img/products', $nameImage);
    $path = 'img/products/'.$nameImage;
    unlink($img_old);
   }else{
    $path = $img_old;
   }
    $data_pro = [
        'name' => $request->name,
        'id_category' => $request->id_category,
        'id_materials' => $request->id_materials,
        'id_stones' => $request->id_stones,
        'description' => $request->description,
        'thumbnail' => $path,
    ];
   
    $product->update($data_pro);
    if($request->id_var){
        foreach($request->id_var as $key => $item){
            $data_var = [
      
                'id_attribute_color' => $request->id_attribute_color[$key],
                'id_attribute_size' => $request->id_attribute_size[$key],
                'import_price' => $request->import_price[$key],
                'list_price' => $request->list_price[$key],
                'selling_price' => $request->selling_price[$key],
                'quantity' => $request->quantity[$key],
            ];
    
            $variant =Variant::findOrFail($item);
            $variant->update($data_var);
        }
    
    }
    if($request->new_id_attribute_color){
        foreach($request->new_id_attribute_color as $key => $color){
            $data_var = [
                'id_product' => $id,
                'id_attribute_color' => $color,
                'id_attribute_size' => $request->new_id_attribute_size[$key],
                'import_price' => $request->new_import_price[$key],
                'list_price' => $request->new_list_price[$key],
                'selling_price' => $request->new_selling_price[$key],
                'quantity' => $request->new_quantity[$key],
            ];

            Variant::create($data_var);
        }
    }
   

   toastr()->success('Cập nhật sản phẩm thành công!');
   return redirect()->route('product_management.index');
   
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        toastr()->success('Xoá thành công!');
        return redirect()->route('product_management.index');
    }
}
