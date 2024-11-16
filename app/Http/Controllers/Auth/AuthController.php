<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\UserResetToken;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    // API: /api/login
    // param: (email, password )
    // example:
    //            {
    //              "email": "thongngo2ka4@gmail.com",
    //              "password": "thong15112004"
    //            }
    // response:200
    //            {
    //                "status": true,
    //                "message": "Đăng nhập thành công",
    //                "data": "6|FZVmV7xSkh4PLYcLxunNCHElZjvDy3IUTA3YjFbybb7edd39"
    //            }
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if ($user->status !== 1) {
                    return $this->jsonResponse('Tài khoản của bạn không hoạt động');
                }

                $token = $user->createToken('tokenAuth')->plainTextToken;
                $data = [
                    'role' => $user->role,
                    'token' => $token,
                    'user' => $user
                ];
                return $this->jsonResponse('Đăng nhập thành công', true, $data);
            }

            return $this->jsonResponse('Thông tin đăng nhập không chính xác');
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }

    // method: POST
    // API: /api/register
    // param: (email, password, password_confirmation )
    // example:
    //            {
    //              "name": "thongngo",
    //              "email": "thongngo2ka4@gmail.com",
    //              "password": "password"
    //              "password_confirmation": "password"
    //            }
    // response:200
    //            {
    //                "status": true,
    //                "message": "Đăng ký thành công",
    //                "data": null
    //            }
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 1,
                'status' => 1,
            ]);
            DB::commit();

            if ($user) {
                Auth::login($user);
                $token = $user->createToken('tokenAuth')->plainTextToken;
                $data = [
                    'role' => $user->role,
                    'token' => $token,
                    'user' => $user
                ];

                return $this->jsonResponse('Đăng ký thành công', true, $data);
            } else {
                return $this->jsonResponse('Đăng ký thất bại');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse('Common Exception');
        }
    }


    // method: POST
    // API: /api/logout
    // request: token
    // response:200
    //            {
    //                "status": true,
    //                "message": "Đăng Xuất thành công",
    //                "data": null
    //            }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();

            return $this->jsonResponse('Đăng Xuất thành công', true);
        }

        return $this->jsonResponse('Người dùng không được xác thực');
    }

    public function forgotPassword(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email|exists:users|unique:password_reset_tokens,email'
            ], [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email chưa đúng định dạng',
                'email.exists' => 'Email không tồn tại trong hệ thống',
                'email.unique' => 'Yêu cầu của bạn đã được xử lý. Vui lòng kiểm tra email của bạn'
            ]);

            $user = User::where('email', $request->email)->where('role', '1')->where('status', 1)->first();

            if (!$user) {
                return $this->jsonResponse('Email không hợp lệ!');
            }

            $email = $request->email;
            $token = \Str::random(50);
            $data = [
                'email'  => $request->email,
                'token' => $token,
            ];

            if (UserResetToken::create($data)) {
                Mail::send(
                    'emails.forgot-password',
                    compact('user', 'token'),
                    function ($message) use ($email) {
                        $message->from(config('mail.from.address'), 'Shine');
                        $message->to($email);
                        $message->subject('Đặt lại mật khẩu của bạn');
                    }
                );
                return $this->jsonResponse('Vui lòng kiểm tra email của bạn!', true);
            }
            return $this->jsonResponse('Email không hợp lệ!');
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function resetPassword(Request $request, $token)
    {

        try {
            $request->validate([
                'password' => 'required|min:8|max:32|confirmed',
            ], [
                'password.required' => 'Mật khẩu là trường bắt buộc.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.max' => 'Mật khẩu không được quá 32 ký tự.',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            ]);
            $dataToken = UserResetToken::where('token', $token)->first();

            if (!$dataToken) {
                return $this->jsonResponse('Đã quá thời hạn đổi mật khẩu!');
            }
            $user = User::where('email', $dataToken->email)->firstOrFail();

            $data = [
                'password' => bcrypt($request->password),
            ];
            $check = $user->update($data);
            // dd($data);
            if ($check) {
                UserResetToken::where('token', $token)->delete();
                return $this->jsonResponse('Đổi mật khẩu thành công!', true);
            }
            return $this->jsonResponse('Có lỗi xảy ra!');
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        try {
            $data = $request->validate([
                'name' => 'required|max:255|min:3',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'image' => 'nullable|file|image|max:2048',
                'phone_number' => 'nullable|regex:/^[0-9]{10,}$/',
                'address' => 'nullable',
            ], [
                'name.required' => 'Tên khách hàng là bắt buộc.',
                'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'name.min' => 'Tên khách hàng phải có ít nhất 6 ký tự.',
                'name.unique' => 'Tên khách hàng đã tồn tại, vui lòng chọn tên khác.',

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
                $image->move('img/client', $nameImage);
                $path = 'img/client/' . $nameImage;
                if ($old_image && file_exists(public_path($old_image))) {
                    unlink(public_path($old_image));
                }
            } else {
                $path = $old_image;
            }
            $data = [
                'name' => $request->name,
                'image' => $path ? url($path) : null,
                'email' => $request->email,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ];
            User::findOrFail($user->id)->update($data);
            return $this->jsonResponse('Thay đổi thông tin thành công!', true);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ], [
                'old_password.required' => 'Mật khẩu cũ là bắt buộc',
                'new_password.required' => 'Mật khẩu mới là bắt buộc',
                'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
                'new_password.confirmed' => 'Mật khẩu không khớp.',

            ]);
            $user = Auth::user();
            if (Hash::check($request->old_password, $user->password)) {
                $data = ['password' => Hash::make($request->new_password)];
                User::findOrFail($user->id)->update($data);
                return $this->jsonResponse('Thay đổi mật khẩu thành công!', true);
            } else {
                return $this->jsonResponse('Mật khẩu cũ không đúng, vui lòng nhập lại!', false);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function searchUser(Request $request)
    {
        $query = $request->get('query');
    if (strlen($query) < 3) {
        return response()->json([]);
    }
    $products = User::where('name', 'LIKE', "%{$query}%")
                       ->take(10) // Giới hạn số lượng kết quả trả về
                       ->get(['id', 'name']); // Chỉ lấy trường cần thiết

    return response()->json($products);
    }
}

