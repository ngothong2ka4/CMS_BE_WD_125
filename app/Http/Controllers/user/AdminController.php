<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
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
            'imgae' => 'nullable|file|image|max:2048',
            'address' => 'nullable',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
            'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác.',
            'email.email' => 'Email phải dạng email.',


            'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
            'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

            'password.required' => 'Mật khẩu là bắt buộc.',
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
            'address' => $request->address,
            // 'role' => $request->role,
            // 'status' => $request->status,
        ];
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
    // public function update(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);
    //     $data = $request->validate([
    //         'name' => 'required|max:255|min:3|unique:users' . $user->id,
    //         'email' => 'erquired|email|unique:users' . $user->id,
    //         'password' => 'nullable',
    //         'imgae' => 'nullable|file|image|max:2048',
    //         'address' => 'nullable',
    //     ], [
    //         'name.required' => 'Tên sản phẩm là bắt buộc.',
    //         'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
    //         'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
    //         'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

    //         'email.required' => 'Email là bắt buộc.',
    //         'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác.',
    //         'email.email' => 'Email phải dạng email.',


    //         'thumbnail.max' => 'Hình sản phẩm dung lượng vượt quá 2Mb.',
    //         'thumbnail.image' => 'Hình ảnh sản phẩm phải là một hình ảnh',

    //     ]);
    //     $old_image = $user->image;
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $nameImage = $user->id . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
    //         $image->move('img/user', $nameImage);
    //         $path = 'img/user/' . $nameImage;
    //         if (file_exists(public_path($old_image))) {
    //             unlink(public_path($old_image));
    //         }
    //     } else {
    //         $path = $old_image;
    //     }

    //     $data = [
    //         'name' => $request->name,
    //         'image' => url($path),
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password) ,
    //         'address' => $request->address,
    //         'role' => $request->role,
    //         'status' => $request->status,
    //     ];
    //     $user->update($data);
    //     $request->session()->regenerate();
    //     return redirect()->back();
    // }

    public function update(Request $request, $id)
{
    // Lấy thông tin người dùng
    $user = User::findOrFail($id);

    // Validation
    $data = $request->validate([
        'name' => 'required|max:255|min:3|unique:users,name,'.$id,
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'nullable',
        'image' => 'nullable|file|image|max:2048',
        'address' => 'nullable',
    ], [
        'name.required' => 'Tên sản phẩm là bắt buộc.',
        'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
        'name.min' => 'Tên sản phẩm phải có ít nhất 6 ký tự.',
        'name.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',

        'email.required' => 'Email là bắt buộc.',
        'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác.',
        'email.email' => 'Email phải có định dạng hợp lệ.',

        'image.max' => 'Hình ảnh dung lượng vượt quá 2MB.',
        'image.image' => 'Hình ảnh phải là một file ảnh hợp lệ.',
    ]);

    // Xử lý hình ảnh
    $old_image = $user->image;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $nameImage = $user->id . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
        $image->move('img/user', $nameImage);
        $path = 'img/user/' . $nameImage;

        // Xóa hình ảnh cũ nếu tồn tại
        if (file_exists(public_path($old_image))) {
            unlink(public_path($old_image));
        }
    } else {
        $path = $old_image;
    }

    // Chuẩn bị dữ liệu để cập nhật
    $data = [
        'name' => $request->name,
        'image' => url($path),
        'email' => $request->email,
        'address' => $request->address,
        'role' => $request->role,
        'status' => $request->status,
    ];

    // Cập nhật thông tin người dùng
    $user->update($data);

    // Regenerate session để cập nhật thông tin đăng nhập nếu cần
    $request->session()->regenerate();

    // Redirect về trang trước
    return redirect()->back()->with('status', 'Cập nhật thành công!');
}

    public function status($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();
        toastr()->success('Tài khoản đã được cập nhật thành công !');
        return redirect()->back();
    }
}
