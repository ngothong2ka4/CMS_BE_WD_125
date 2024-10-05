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
        if($request->hasFile('image')){
           
            $image = $request->file('image');
            $nameImage = time()."_".$image->getClientOriginalName();
            $image->move('img/products', $nameImage);
            $path = 'img/products/'. $nameImage;
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
