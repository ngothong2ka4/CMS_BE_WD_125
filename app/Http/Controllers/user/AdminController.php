<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 2)->get();
        return view('user.admin.index', compact('users'));
    }
    public function create()
    {
        return view('user.admin.add');
    }
    // public function store(Request $request, $id)
    // {
    //     try {
    //         $admin = User::findOrFail($id);
    //         $request->validate([
    //             'name' => 'required|max:25|min:3|regex:/^[\p{L}\p{N}\s]+$/u|unique:user,name,' . $admin->id,
    //             'image' => 'nullable|file|image|max:2048',
    //             'email' => 'required|email',
    //             'password' => 'required|password|min:8',
    //             'address' => 'nullable',

    //         ]);
    //         if ($request->hasFile('image')) {
    //             $image = $request->file['image'];
    //             $nameImage = $admin->id . time() . "_" . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
    //             $image->move('img/user', $nameImage);
    //             $path = 'img/user/' . $nameImage;
    //         } 

    //         $data = [
    //             'name' => $request->name,
    //             'image' => url($path),
    //             'email' => $request->email,
    //             'password' => $request->password,
    //             'address' => $request->address,
    //             // 'role' => $request->role,
    //             // 'status' => $request->status,
    //         ];
    //         $admin->create($data);
    //         toastr()->success('Thêm thông tin thành công!');
    //         return redirect()->back();

    //     }catch (\Illuminate\Validation\ValidationException $e) {
    //         // Lấy tất cả các lỗi xác thực và hiển thị qua Toastr
    //         foreach ($e->errors() as $error) {
    //             toastr()->error(implode(' ', $error));
    //         }

    //         // Quay lại trang trước với dữ liệu cũ và lỗi
    //         return redirect()->back()->withErrors($e->errors())->withInput();
    //     }
    // }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|min:3|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed',
            'image' => 'nullable|file|image|max:2048',
            'phone_number' => 'nullable|regex:/^[0-9]{10,}$/',
            'address' => 'nullable',
            'role' => 'nullable|in:1,2',
            'status' => 'nullable|in:0,1',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
            'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác.',
            'email.email' => 'Email phải dạng email.',

            'phone_number.regex' => 'Số điện thoại phải có 10 số',

            'image.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
            'image.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.confirmed' => 'Mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = time() . "_" . "_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move('img/user', $nameImage);
            $path = 'img/user/' . $nameImage;
        }

        $data = [
            'name' => $request->name,
            'image' => url($path),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => $request->input('role', 2),
            'status' => $request->input('status', 1),
        ];
        dd($data);
        User::query()->create($data);
        // Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('admin.index');
    }
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('user.admin.show', compact('user'));
    }
    public function edit(Request $request, $id)
    {
        // $users= User::first($id);
        $user = User::findOrFail($id);
        return view('user.admin.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:255|min:3|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            'image' => 'nullable|file|image|max:2048',
            'phone_number' => 'nullable|regex:/^[0-9]{10,}$/',
            'address' => 'nullable',
            'role' => 'nullable|in:1,2',
            'status' => 'nullable|in:0,1',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
            'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

            'phone_number.regex' => 'Số điện thoại phải có 10 số',

            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác.',
            'email.email' => 'Email phải có định dạng hợp lệ.',

            'image.max' => 'Hình ảnh dung lượng vượt quá 2MB.',
            'image.image' => 'Hình ảnh phải là một file ảnh hợp lệ.',
        ]);

        $old_image = $user->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = $user->id . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move('img/user', $nameImage);
            $path = 'img/user/' . $nameImage;
            if ($old_image && file_exists(public_path($old_image))) {
                unlink(public_path($old_image));
            }
        } else {
            $path = $old_image;
        }
        $data = [
            'name' => $request->name,
            'image' => url($path),
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status,
        ];
        $user->update($data);
        $request->session()->regenerate();
        toastr()->success('Cập nhật thành công!');
        return redirect()->back();
    }

    public function status($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();
        toastr()->success('Tài khoản đã được cập nhật thành công !');
        return redirect()->back();
    }
    public function changePassword($id)
    {
        $user = User::findOrFail($id);
        return view('user.admin.changepassword', compact('user'));
    }
    public function getchangePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Mật khẩu cũ là bắt buộc',
            'new_password.required' => 'Mật khẩu mới là bắt buộc',
            'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'new_password.confirmed' => 'Mật khẩu không khớp.',

        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->current_password);
            $user->save();
            return redirect('changePassword');
        } else {
            return redirect('changePassword');
        }
    }
}
