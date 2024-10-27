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
                
                return $this->jsonResponse('Đăng ký thành công', true,$data);
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

    public function forgotPassword(Request $request){

       try{
        $request->validate([
            'email'=> 'required|email|exists:users|unique:password_reset_tokens,email'
        ],[
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email chưa đúng định dạng',
            'email.exists' => 'Email không tồn tại trong hệ thống',
            'email.unique' => 'Yêu cầu của bạn đã được xử lý. Vui lòng kiểm tra email của bạn'
        ]);

        $user = User::where('email',$request->email)->where('role','1')->where('status',1)->first();
        
        if(!$user){
            return $this->jsonResponse('Email không hợp lệ!');
        }

        $email = $request->email;
        $token = \Str::random(50);
        $data = [
            'email'  => $request->email,
            'token' => $token,
        ];

        if(UserResetToken::create($data)){
        Mail::send('emails.forgot-password',compact('user','token'),
            function ($message) use ($email){
                $message->from(config('mail.from.address'),'Shine');
                $message->to($email);
                $message->subject('Đặt lại mật khẩu của bạn');
            }
    );
        return $this->jsonResponse('Vui lòng kiểm tra email của bạn!');

        }
        return $this->jsonResponse('Email không hợp lệ!');
   
    } catch (\Exception $exception) {
        DB::rollBack();
        \Log::error($exception->getMessage());
        return $this->jsonResponse($exception->getMessage());
    }
    }

    public function resetPassword(Request $request, $token){

        try{
        $request->validate([
            'password' => 'required|min:8|max:32|confirmed',
        ],[
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được quá 32 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);
        $dataToken = UserResetToken::where('token', $token)->firstOrFail();
        $user = User::where('email', $dataToken->email)->firstOrFail();

        $data = [
            'password' => bcrypt($request->password),
        ];
        $check = $user->update($data);
        // dd($data);
        if($check){
        UserResetToken::where('token', $token)->delete();
        return $this->jsonResponse('Đổi mật khẩu thành công!');

    }
    return $this->jsonResponse('Có lỗi xảy ra!');
} catch (\Exception $exception) {
    DB::rollBack();
    \Log::error($exception->getMessage());
    return $this->jsonResponse($exception->getMessage());
}

    }
}