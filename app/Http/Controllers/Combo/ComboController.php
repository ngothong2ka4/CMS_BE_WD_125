<?php

namespace App\Http\Controllers\Combo;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::all();
        return view('combo.index', compact('combos'));
    }
    public function create()
    {
        $combos = Combo::all();
        $products = Product::all();
        return view('combo.add', compact('combos', 'products'));
    }
    public function store(Request $request)
    {
        try {
            $params = $request->validate([
                'name' => 'required|min:3 ',
                'id_product' => 'required|min:2',
                'price' => 'required',
                'description' => 'nullable',
                'quantity' => 'required',
            ], [
                'name.required' => 'Tên combo là bắt buộc.',
                'name.min' => 'Tên combo phải có ít nhất 3 ký tự.',


                'id_product.required' => 'Sản phẩm là bắt buộc.',
                'id_product.min' => 'Phải có 2 sản phẩm trở lên.',


                'price.required' => 'Giá là bắt buộc',

                'quantity.required' => 'Giá là bắt buộc',

            ]);

            if (isset($params['id_product']) && !is_array($params['id_product'])) {
                $params['id_product'] = explode(',', $params['id_product']);
            }

            $combos = Combo::create($params);

            if (!empty($params['id_product'])) {
                $combos->products()->sync($params['id_product']);
            }
            toastr()->success('Thêm combo thành công!');
            return redirect()->route('combo.index');
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function show($id)
    {
        $combos = Combo::findOrFail($id);
        $products = Product::all();
        $selectedProductIds = DB::table('combo_products')
            ->where('id_combo', $id)
            ->pluck('id_product')
            ->toArray();

        return view('combo.show', compact('combos', 'products', 'selectedProductIds'));
    }
    public function edit($id)
    {
        $combos = Combo::findOrFail($id);
        $products = Product::all();
        $selectedProductIds = DB::table('combo_products')
            ->where('id_combo', $id)
            ->pluck('id_product')
            ->toArray();

        return view('combo.edit', compact('combos', 'products', 'selectedProductIds'));
    }
    public function update(Request $request, Combo $combo)
    {
        try {
            $params = $request->validate([
                'name' => 'required|min:3 ',
                'id_product' => 'required|min:2',
                'price' => 'required',
                'description' => 'nullable',
                'quantity' => 'required',
            ], [
                'name.required' => 'Tên combo là bắt buộc.',
                'name.min' => 'Tên combo phải có ít nhất 3 ký tự.',


                'id_product.required' => 'Sản phẩm là bắt buộc.',
                'id_product.min' => 'Phải có 2 sản phẩm trở lên.',

                'price.required' => 'Giá là bắt buộc',

                'quantity.required' => 'Giá là bắt buộc',

            ]);

            if (isset($params['id_product']) && !is_array($params['id_product'])) {
                $params['id_product'] = explode(',', $params['id_product']);
            }

            $combo->update($params);
            if (!empty($params['id_product'])) {
                $combo->products()->sync($params['id_product']);
            }
            toastr()->success('Sửa combo thành công!');
            return redirect()->back()->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function destroy( $id)
    {
        $combo = Combo::findOrFail($id);
        // $combo->products()->detach();
        $combo->delete();
        toastr()->success('Xoá combo thành công!');
        return redirect()->back();
    }
}
