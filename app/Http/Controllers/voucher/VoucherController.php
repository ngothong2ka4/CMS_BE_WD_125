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
        // $voucher = Voucher::all();
        try {
            $params = $request->validate([
                'code' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:vouchers,code,',
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required|numeric|min:1',
                'start_date' => 'required',
                'end_date' => 'required',
                'usage_limit' => 'required|integer|min:1',
                'usage_per_user' => 'required|integer|min:1',
                'description' => 'nullable',
                'max_discount_amount' => 'nullable|numeric',
                'min_accumulated_points' => 'nullable',
                'max_accumulated_points' => 'nullable',
            ], [
                'code.required' => 'Mã code là bắt buộc.',
                'code.max' => 'Mã code không được vượt quá 25 ký tự.',
                'code.min' => 'Mã code phải có ít nhất 3 ký tự.',
                'code.regex' => 'Mã code chỉ được chứa chữ cái, số và khoảng trắng.',
                'code.unique' => 'Mã code đã tồn tại, vui lòng chọn tên khác.',

                'discount_value.min' => 'Mức ưu đãi phải lớn hơn không',
                'usage_per_user.min' => 'Giới hạn sử dụng trên mỗi người dùng phải lớn hơn không',
                'usage_limit.min' => 'Giới hạn sử dụng mỗi mã giảm giá phải lớn hơn không',
            ]);
            // if ($request->min_accumulated_points <= 0) {
            //     toastr()->error('Điển tích lũy nhỏ phải lớn hơn hoắc bằng 0');
            //     return back()->withInput();
            // }
            // if ($request->min_accumulated_points > $request->max_accumulated_points) {
            //     toastr()->error('Điển tích lũy nhỏ phải nhỏ hơn điểm tích lũy lớn ');
            //     return back()->withInput();
            // }
            if ($request->discount_type == 2) {
                $request->max_discount_amount = null;
                // toastr()->error('Mức ưu đãi theo phần trăm phải nhỏ hơn hoặc bằng 100' );
                // return back()->withInput();
            }
            if ($request->discount_type == 1 && $request->discount_value > 100) {
                toastr()->error('Mức ưu đãi theo phần trăm phải nhỏ hơn hoặc bằng 100');
                return back()->withInput();
            }
            if ($request->discount_type == 2 && $request->discount_value < 10000) {
                toastr()->error('Mức ưu đãi theo giá trị cố định phải lớn hoặc bằng 10000');
                return back()->withInput();
            }
            if ($request->start_date >= $request->end_date) {
                toastr()->error('Ngày bắt đầu phải trước ngày kết thúc');
                return back()->withInput();
            }
            // dd($params);
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
        $voucher = Voucher::findOrFail($id);
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
        // dd($request);
        try {
            $params = $request->validate([
                'code' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:vouchers,code,' . $voucher->id,
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required|numeric|min:1',
                'start_date' => 'required',
                'end_date' => 'required',
                'usage_limit' => 'required|integer|min:1',
                'usage_per_user' => 'required|integer|min:1',
                'description' => 'nullable',
                'user_voucher_limit' => 'required',
                'max_discount_amount' => 'required',
                'min_accumulated_points' => 'required',
                'max_accumulated_points' => 'required'
            ], [
                'code.required' => 'Mã code là bắt buộc.',
                'code.max' => 'Mã code không được vượt quá 25 ký tự.',
                'code.min' => 'Mã code phải có ít nhất 3 ký tự.',
                'code.regex' => 'Mã code chỉ được chứa chữ cái, số và khoảng trắng.',
                'code.unique' => 'Mã code đã tồn tại, vui lòng chọn tên khác.',

                'discount_value.min' => 'Mức ưu đãi phải lớn hơn không',
                'usage_per_user.min' => 'Giới hạn sử dụng trên mỗi người dùng phải lớn hơn không',
                'usage_limit.min' => 'Giới hạn sử dụng mỗi mã giảm giá phải lớn hơn không',
            ]);

            if ($request->discount_type == 1 && $request->discount_value > 100) {
                toastr()->error('Mức ưu đãi theo phần trăm phải nhỏ hơn hoặc bằng 100');
                return back()->withInput();
            }
            if ($request->discount_type == 2 && $request->discount_value < 10000) {
                toastr()->error('Mức ưu đãi theo giá trị cố định phải lớn hoặc bằng 10000');
                return back()->withInput();
            }
            if ($request->start_date >= $request->end_date) {
                toastr()->error('Ngày bắt đầu phải trước ngày kết thúc');
                return back()->withInput();
            }
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
