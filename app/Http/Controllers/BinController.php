<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Combo;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Stone;
use App\Models\Voucher;
use Illuminate\Http\Request;

class BinController extends Controller
{
    // category, combo, product, size, color, material, stone, voucher,

    public function deleteCheck(Request $request)
    {
        try {

            if ($request->sub) {
                if ($request->category) {
                    foreach ($request->category as $val) {
                        $category = Category::withTrashed()->find($val);
                        $category->forceDelete();
                    }
                } else
            if ($request->combo) {
                    foreach ($request->combo as $val) {
                        $combo = Combo::withTrashed()->find($val);
                        $combo->forceDelete();
                    }
                } else
            if ($request->product) {
                    foreach ($request->product as $val) {
                        $product = Product::withTrashed()->find($val);
                        $product->forceDelete();
                    }
                } else
            if ($request->size) {
                    foreach ($request->size as $val) {
                        $size = ProductSize::withTrashed()->find($val);
                        $size->forceDelete();
                    }
                } else
            if ($request->color) {
                    foreach ($request->color as $val) {
                        $color = ProductColor::withTrashed()->find($val);
                        $color->forceDelete();
                    }
                } else
            if ($request->material) {
                    foreach ($request->material as $val) {
                        $material = Material::withTrashed()->find($val);
                        $material->forceDelete();
                    }
                } else
            if ($request->stone) {
                    foreach ($request->stone as $val) {
                        $stone = Stone::withTrashed()->find($val);
                        $stone->forceDelete();
                    }
                } else
            if ($request->voucher) {
                    foreach ($request->voucher as $val) {
                        $voucher = Voucher::withTrashed()->find($val);
                        $voucher->forceDelete();
                    }
                } else {
                    toastr()->error('Chưa có mục nào được chọn!');
                    return redirect()->back();
                }


                toastr()->success('Xóa thành công!');
                return redirect()->back();
            } else {
                if ($request->category) {
                    foreach ($request->category as $val) {
                        $category = Category::withTrashed()->find($val);
                        $category->restore();
                    }
                } else
            if ($request->combo) {
                    foreach ($request->combo as $val) {
                        $combo = Combo::withTrashed()->find($val);
                        $combo->restore();
                    }
                } else
            if ($request->product) {
                    foreach ($request->product as $val) {
                        $product = Product::withTrashed()->find($val);
                        $product->restore();
                    }
                } else
            if ($request->size) {
                    foreach ($request->size as $val) {
                        $size = ProductSize::withTrashed()->find($val);
                        $size->restore();
                    }
                } else
            if ($request->color) {
                    foreach ($request->color as $val) {
                        $color = ProductColor::withTrashed()->find($val);
                        $color->restore();
                    }
                } else
            if ($request->material) {
                    foreach ($request->material as $val) {
                        $material = Material::withTrashed()->find($val);
                        $material->restore();
                    }
                } else
            if ($request->stone) {
                    foreach ($request->stone as $val) {
                        $stone = Stone::withTrashed()->find($val);
                        $stone->restore();
                    }
                } else
            if ($request->voucher) {
                    foreach ($request->voucher as $val) {
                        $voucher = Voucher::withTrashed()->find($val);
                        $voucher->restore();
                    }
                } else {
                    toastr()->error('Chưa có mục nào được chọn!');
                    return redirect()->back();
                }

                toastr()->success('Khôi phục thành công!');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra!');
            return redirect()->back()->withInput();
        }
    }

    public function index(Request $request)
    {
        $categories = [];
        $products = [];
        $combos = [];
        $colors = [];
        $sizes = [];
        $materials = [];
        $stones = [];
        $vouchers = [];

        $key = $request->table;

        switch ($key) {
            case 'product':
                $products = Product::onlyTrashed()->get();
                break;
            case 'category':
                $categories = Category::onlyTrashed()->get();
                break;
            case 'combo':
                $combos = Combo::onlyTrashed()->get();
                break;
            case 'voucher':
                $vouchers = Voucher::onlyTrashed()->get();
                break;
            case 'color':
                $colors = ProductColor::onlyTrashed()->get();
                break;
            case 'size':
                $sizes = ProductSize::onlyTrashed()->get();
                break;
            case 'material':
                $materials = Material::onlyTrashed()->get();
                break;
            case 'stone':
                $stones = Stone::onlyTrashed()->get();
                break;
            case 'all':
                $categories = Category::onlyTrashed()->get();
                $products = Product::onlyTrashed()->get();
                $combos = Combo::onlyTrashed()->get();
                $colors = ProductColor::onlyTrashed()->get();
                $sizes = ProductSize::onlyTrashed()->get();
                $materials = Material::onlyTrashed()->get();
                $stones = Stone::onlyTrashed()->get();
                $vouchers = Voucher::onlyTrashed()->get();
                break;
            default:
                $categories = Category::onlyTrashed()->get();
                $products = Product::onlyTrashed()->get();
                $combos = Combo::onlyTrashed()->get();
                $colors = ProductColor::onlyTrashed()->get();
                $sizes = ProductSize::onlyTrashed()->get();
                $materials = Material::onlyTrashed()->get();
                $stones = Stone::onlyTrashed()->get();
                $vouchers = Voucher::onlyTrashed()->get();
                break;
        }


        return view('bin', compact('categories', 'products', 'combos', 'colors', 'sizes', 'materials', 'stones', 'vouchers'));
    }

    public function forceDelete($id, $key)
    {

        if ($key == 'category') {
            $category = Category::withTrashed()->find($id);
            $category->forceDelete();
        }
        if ($key == 'combo') {
            $combo = Combo::withTrashed()->find($id);
            $combo->forceDelete();
        }
        if ($key == 'product') {
            $product = Product::withTrashed()->find($id);
            $product->forceDelete();
        }
        if ($key == 'size') {
            $size = ProductSize::withTrashed()->find($id);
            $size->forceDelete();
        }
        if ($key == 'color') {
            $color = ProductColor::withTrashed()->find($id);
            $color->forceDelete();
        }
        if ($key == 'material') {
            $material = Material::withTrashed()->find($id);
            $material->forceDelete();
        }
        if ($key == 'stone') {
            $stone = Stone::withTrashed()->find($id);
            $stone->forceDelete();
        }
        if ($key == 'voucher') {
            $voucher = Voucher::withTrashed()->find($id);
            $voucher->forceDelete();
        }
        toastr()->success('Xóa thành công!');
        return redirect()->back();
    }

    public function restore($id, $key)
    {

        if ($key == 'category') {
            $category = Category::withTrashed()->find($id);
            $category->restore();
        }
        if ($key == 'combo') {
            $combo = Combo::withTrashed()->find($id);
            $combo->restore();
        }
        if ($key == 'product') {
            $product = Product::withTrashed()->find($id);
            $product->restore();
        }
        if ($key == 'size') {
            $size = ProductSize::withTrashed()->find($id);
            $size->restore();
        }
        if ($key == 'color') {
            $color = ProductColor::withTrashed()->find($id);
            $color->restore();
        }
        if ($key == 'material') {
            $material = Material::withTrashed()->find($id);
            $material->restore();
        }
        if ($key == 'stone') {
            $stone = Stone::withTrashed()->find($id);
            $stone->restore();
        }
        if ($key == 'voucher') {
            $voucher = Voucher::withTrashed()->find($id);
            $voucher->restore();
        }
        toastr()->success('Khôi phục thành công!');
        return redirect()->back();
    }
}
