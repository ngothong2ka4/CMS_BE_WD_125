<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function delete(string $id){
        Variant::findOrFail($id)->delete();
        toastr()->success('Xoá thành công!');
        return back();
    }
}
