<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function delete(string $id){
        Variant::findOrFail($id)->delete();
        toastr()->success('Xoá thành công!');
        return back();
    }

    public function index(string $id){
        $product = Product::findOrFail($id);
        $colors = ProductColor::all();
        $images = ProductImage::where('id_product', $id)->get();
        return view('product.product_management.product_images.index', compact('product','images','colors'));
    }

    public function addImage(Request $request, $id){
        $request->validate([        
            'thumbnail' => 'nullable|file|image|max:2048',
        ], [
            'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
            'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',
        ]);

        if($request->hasFile('image')){
           
            $image = $request->file('image');
            $nameImage = time()."_".$image->getClientOriginalName();
            $image->move('img/products', $nameImage);
            $path = 'http://127.0.0.1:8000/img/products/'. $nameImage;
            $data = [
                'id_product' => $id,
                'id_attribute_color' => $request->id_attribute_color,
                'link_image' => $path,
            ];
             
           ProductImage::create($data);

           }
      
           return back();
    }

    public function destroy(string $id){
        ProductImage::findOrFail($id)->delete();
        toastr()->success('Xoá thành công!');
        return back();
    }
}
