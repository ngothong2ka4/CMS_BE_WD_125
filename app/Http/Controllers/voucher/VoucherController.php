<?php

namespace App\Http\Controllers\voucher;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use DB;
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
        
        $users= User::all();
        return view('voucher.add', compact('users'));
    }
     
    public function store(Request $request)
    {
        try {
            $params = $request->validate([
                // 'id_product' => 'nullable|array',
                'id_user' => 'nullable|array',
                'code' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:vouchers,code,',
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required|numeric|min:1',
                'start_date' => 'required',
                'end_date' => 'required',
                'usage_limit' => 'required|integer|min:1',
                'usage_per_user' => 'required|integer|min:1',
                'description' => 'nullable',
                'user_voucher_limit' => 'nullable|in:1,2,3',
                'max_discount_amount' => 'nullable|numeric',
                'min_accumulated_points' => 'nullable|numeric',
                'max_accumulated_points' => 'nullable|numeric',
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
            if ($params['user_voucher_limit'] == 1) {
                $params['min_accumulated_points'] = null;
                $params['max_accumulated_points'] = null;

            }
            if ($params['discount_type'] == 2) {
                $params['max_discount_amount'] = null;
            }

            if ($params['discount_type'] == 2 && $params['min_accumulated_points'] < 0) {
                toastr()->error('Điểm tích lũy nhỏ phải lớn hơn hoặc bằng 0');
                return back()->withInput();
            }
            
            if ($params['discount_type'] == 2 && isset($params['max_accumulated_points']) && $params['min_accumulated_points'] > $params['max_accumulated_points']) {
                toastr()->error('Điểm tích lũy nhỏ phải nhỏ hơn hoặc bằng điểm tích lũy lớn');
                return back()->withInput();
            }
            
            if ($params['discount_type'] == 1 && $params['discount_value'] > 100) {
                toastr()->error('Mức ưu đãi theo phần trăm phải nhỏ hơn hoặc bằng 100');
                return back()->withInput();
            }
            if ($params['discount_type'] == 2 && $params['discount_value'] < 10000) {
                toastr()->error('Mức ưu đãi theo giá trị cố định phải lớn hoặc bằng 10000');
                return back()->withInput();
            }
            if ($request->start_date > $request->end_date) {
                toastr()->error('Ngày bắt đầu phải trước hoặc bằng ngày kết thúc');
                return back()->withInput();
            }
            // if (isset($params['id_product']) && !is_array($params['id_product'])) {
            //     $params['id_product'] = explode(',', $params['id_product']);
            // }
            if (isset($params['id_user'] ) && !is_array($params['id_user'])) {
                $params['id_user'] = explode(',', $params['id_user']);
            }

            $voucher = Voucher::create($params);
            // if (!empty($params['id_product'])) {
            //     $voucher->products()->sync($params['id_product']);
            // }
            if (!empty($params['id_user'])) {
                $voucher->users()->sync($params['id_user']);
            }
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
         
        $users = User::all(); // Lấy tất cả người dùng
        $selectedUserIds = DB::table('voucher_user_access')
            ->where('id_voucher', $id)
            ->pluck('id_user')
            ->toArray(); // Lấy danh sách id_user đã có trong voucher_user_access
    
        return view('voucher.show', compact('voucher', 'users', 'selectedUserIds'));
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
        
        $users = User::all(); // Lấy tất cả người dùng
        $selectedUserIds = DB::table('voucher_user_access')
            ->where('id_voucher', $id)
            ->pluck('id_user')
            ->toArray(); // Lấy danh sách id_user đã có trong voucher_user_access
    
        return view('voucher.edit', compact('voucher', 'users', 'selectedUserIds'));
    }

    public function update(Request $request, Voucher $voucher)
    {

        try {
            $params = $request->validate([
                // 'id_product' => 'nullable|array',
                'id_user' => 'nullable|array',
                'code' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:vouchers,code,'. $voucher->id,
                'discount_type' => 'required|in:1,2',
                'discount_value' => 'required|numeric|min:1',
                'start_date' => 'required',
                'end_date' => 'required',
                'usage_limit' => 'required|integer|min:1',
                'usage_per_user' => 'required|integer|min:1',
                'description' => 'nullable',
                'user_voucher_limit' => 'nullable|in:1,2,3',
                'max_discount_amount' => 'nullable|numeric',
                'min_accumulated_points' => 'nullable|numeric',
                'max_accumulated_points' => 'nullable|numeric',
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

            if ($params['user_voucher_limit'] == 1) {
                $params['min_accumulated_points'] = null;
                $params['max_accumulated_points'] = null;

            }
            if ($params['discount_type'] == 2) {
                $params['max_discount_amount'] = null;
            }
            if ($params['discount_type'] == 2 && $params['min_accumulated_points'] <= 0) {
                toastr()->error('Điển tích lũy nhỏ phải lớn hơn hoắc bằng 0');
                return back()->withInput();
            }
            if ($params['discount_type'] == 2 && $params['min_accumulated_points'] > $params['max_accumulated_points']) {
                toastr()->error('Điển tích lũy nhỏ phải nhỏ hơn điểm tích lũy lớn ');
                return back()->withInput();
            }
            if ($params['discount_type'] == 1 && $params['discount_value'] > 100) {
                toastr()->error('Mức ưu đãi theo phần trăm phải nhỏ hơn hoặc bằng 100');
                return back()->withInput();
            }
            if ($params['discount_type'] == 2 && $params['discount_value'] < 10000) {
                toastr()->error('Mức ưu đãi theo giá trị cố định phải lớn hoặc bằng 10000');
                return back()->withInput();
            }
            if ($request->start_date > $request->end_date) {
                toastr()->error('Ngày bắt đầu phải trước ngày kết thúc');
                return back()->withInput();
            }
            $voucher->update($params);
            if (!empty($params['id_user'])) {
                $voucher->users()->sync($params['id_user']);
            }
            toastr()->success('Sửa voucher thành công!');
            return redirect()->back()->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->errors() as $error) {
                toastr()->error(implode(' ', $error));
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
