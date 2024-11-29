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
        $products = Product::with(['variants'])->get();

        // Xử lý để tìm giá và số lượng nhỏ nhất của từng sản phẩm
        $productsWithMinValues = $products->map(function ($product) {
            $minPrice = $product->variants->min('list_price');
            $minQuantity = $product->variants->min('quantity');

            return [
                'id' => $product->id,
                'name' => $product->name,
                'min_price' => $minPrice,
                'min_quantity' => $minQuantity,
            ];
        });

        return view('combo.add', compact('combos', 'productsWithMinValues'));
    }
    public function store(Request $request)
    {
        try {
            $params = $request->validate([
                'name' => 'required|min:3 ',
                'id_product' => 'required|min:2',
                'image' => 'required|file|image|mimes:jpg,jpeg,png,gif',
                'price' => 'required|min:0',
                'description' => 'nullable',
                'quantity' => 'required|min:1',
            ], [
                'name.required' => 'Tên combo là bắt buộc.',
                'name.min' => 'Tên combo phải có ít nhất 3 ký tự.',

                'image.required' => 'Ảnh combo là bắt buộc.',
                'image.mimes' => 'Ảnh phải là định dạng jpg, jpeg, png hoặc gif.',

                'id_product.required' => 'Sản phẩm là bắt buộc.',
                'id_product.min' => 'Phải có 2 sản phẩm trở lên.',

                'price.min' => 'Giá combo phải lớn hơn hoặc bằng 0.',
                'price.required' => 'Giá là bắt buộc',

                'quantity.required' => 'Số lượng là bắt buộc',
                'quantity.min' => 'Số lượng combo phải ít nhất là 1.',

            ]);
            // Lấy danh sách sản phẩm được chọn
            $selectedProducts = Product::whereIn('id', $params['id_product'])->with('variants')->get();

            // Tính tổng giá sản phẩm (min_price) và tổng số lượng nhỏ nhất (min_quantity)
            $totalPrice = $selectedProducts->sum(function ($product) {
                return $product->variants->min('list_price') ?? 0;
            });
            // Validate giá combo
            if ($params['price'] > $totalPrice) {
                toastr()->error('Giá combo không được lớn hơn tổng giá sản phẩm (' . number_format($totalPrice) . ').');
                return redirect()->back()->withInput();
            }

            // Tìm số lượng nhỏ nhất trong các sản phẩm
            $minQuantity = $selectedProducts->map(function ($product) {
                return $product->variants->min('quantity') ?? 0;
            })->min();

            // Kiểm tra nếu số lượng combo lớn hơn số lượng nhỏ nhất
            if ($params['quantity'] > $minQuantity) {
                toastr()->error('Số lượng combo không được lớn hơn số lượng nhỏ nhất của sản phẩm được chọn (' . $minQuantity . ').');
                return redirect()->back()->withInput();
            }


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = time() . "_" . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move('img/combo', $nameImage);
                $path = 'img/combo/' . $nameImage;
            }
            $params['image'] = $path ? url($path) : null;

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
        // $products = Product::all();
        $selectedProductIds = DB::table('combo_products')
            ->where('id_combo', $id)
            ->pluck('id_product')
            ->toArray();
        $products = Product::with(['variants'])->get();

        // Xử lý để tìm giá và số lượng nhỏ nhất của từng sản phẩm
        $productsWithMinValues = $products->map(function ($product) {
            $minPrice = $product->variants->min('list_price');
            $minQuantity = $product->variants->min('quantity');

            return [
                'id' => $product->id,
                'name' => $product->name,
                'min_price' => $minPrice,
                'min_quantity' => $minQuantity,
            ];
        });

        return view('combo.show', compact('combos', 'selectedProductIds', 'productsWithMinValues'));
    }
    public function edit($id)
    {
        $combos = Combo::findOrFail($id);
        $selectedProductIds = DB::table('combo_products')
            ->where('id_combo', $id)
            ->pluck('id_product')
            ->toArray();
        $products = Product::with(['variants'])->get();

        // Xử lý để tìm giá và số lượng nhỏ nhất của từng sản phẩm
        $productsWithMinValues = $products->map(function ($product) {
            $minPrice = $product->variants->min('list_price');
            $minQuantity = $product->variants->min('quantity');

            return [
                'id' => $product->id,
                'name' => $product->name,
                'min_price' => $minPrice,
                'min_quantity' => $minQuantity,
            ];
        });

        return view('combo.edit', compact('combos', 'selectedProductIds', 'productsWithMinValues'));
    }
    public function update(Request $request, Combo $combo)
    {
        try {
            $params = $request->validate([
                'name' => 'required|min:3 ',
                'id_product' => 'required|array|min:2',
                'image' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
                'price' => 'required|min:0',
                'description' => 'nullable',
                'quantity' => 'required|min:1',
            ], [
                'name.required' => 'Tên combo là bắt buộc.',
                'name.min' => 'Tên combo phải có ít nhất 3 ký tự.',

                'image.required' => 'Ảnh combo là bắt buộc.',
                'image.mimes' => 'Ảnh phải là định dạng jpg, jpeg, png hoặc gif.',

                'id_product.required' => 'Sản phẩm là bắt buộc.',
                'id_product.min' => 'Phải có 2 sản phẩm trở lên.',

                'price.min' => 'Giá combo phải lớn hơn hoặc bằng 0.',
                'price.required' => 'Giá là bắt buộc',

                'quantity.required' => 'Số lượng là bắt buộc',
                'quantity.min' => 'Số lượng combo phải ít nhất là 1.',

            ]);
            // Lấy danh sách sản phẩm được chọn
            $selectedProducts = Product::whereIn('id', $params['id_product'])->with('variants')->get();

            // Tính tổng giá sản phẩm (min_price) và tổng số lượng nhỏ nhất (min_quantity)
            $totalPrice = $selectedProducts->sum(function ($product) {
                return $product->variants->min('list_price') ?? 0;
            });
            // Validate giá combo
            if ($params['price'] > $totalPrice) {
                toastr()->error('Giá combo không được lớn hơn tổng giá sản phẩm (' . number_format($totalPrice) . ').');
                return redirect()->back()->withInput();
            }

            // Tìm số lượng nhỏ nhất trong các sản phẩm
            $minQuantity = $selectedProducts->map(function ($product) {
                return $product->variants->min('quantity') ?? 0;
            })->min();

            // Kiểm tra nếu số lượng combo lớn hơn số lượng nhỏ nhất
            if ($params['quantity'] > $minQuantity) {
                toastr()->error('Số lượng combo không được lớn hơn số lượng nhỏ nhất của sản phẩm được chọn (' . $minQuantity . ').');
                return redirect()->back()->withInput();
            }

            $old_image = $combo->image;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = $combo->id . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move('img/combo', $nameImage);
                $path = 'img/combo/' . $nameImage;
                if ($old_image && file_exists(public_path($old_image))) {
                    unlink(public_path($old_image));
                }
            } else {
                $path = $old_image;
            }
            $params['image'] = $path;

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
    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);
        // $combo->products()->detach();
        $combo->delete();
        toastr()->success('Xoá combo thành công!');
        return redirect()->back();
    }
}
