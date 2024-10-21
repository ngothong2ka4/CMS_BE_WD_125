<?php

namespace App\Http\Controllers\voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('voucher.index', compact('vouchers'));
    }
    public function create()
    {
        return view('voucher.add');
    }
    public function store(Request $request)
    {
        // dd($request);
        try {
            $params = $request->validate([
                'code' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:vouchers,code,',
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'usage_limit' => 'required',
                'usage_per_user' => 'required',
            ], [
                'code.required' => 'Mã code là bắt buộc.',
                'code.max' => 'Mã code không được vượt quá 25 ký tự.',
                'code.min' => 'Mã code phải có ít nhất 3 ký tự.',
                'code.regex' => 'Mã code chỉ được chứa chữ cái, số và khoảng trắng.',
                'code.unique' => 'Mã code đã tồn tại, vui lòng chọn tên khác.',
            ]);

            Voucher::create($params);
            toastr()->success('Thêm voucher thành công!');
            return redirect()->route('voucher.index');
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function show($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('voucher.show', compact('voucher'));
    }
    public function destroy($id)
    {
        $voucher= Voucher::findOrFail($id);
        $voucher->delete();
        toastr()->success('Xoá voucher thành công!');
        return redirect()->back();
    }

    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('voucher.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        try {
            $params = $request->validate([
                'code' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:vouchers,code,'. $voucher->id,
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'usage_limit' => 'required',
                'usage_per_user' => 'required',
            ], [
                'code.required' => 'Mã code là bắt buộc.',
                'code.max' => 'Mã code không được vượt quá 25 ký tự.',
                'code.min' => 'Mã code phải có ít nhất 3 ký tự.',
                'code.regex' => 'Mã code chỉ được chứa chữ cái, số và khoảng trắng.',
                'code.unique' => 'Mã code đã tồn tại, vui lòng chọn tên khác.',
            ]);

            $voucher->update($params);
            toastr()->success('Sửa voucher thành công!');
            return redirect()->route('voucher.index');
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
