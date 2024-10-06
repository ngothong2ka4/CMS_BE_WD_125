<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

                $token = $user->createToken('tokenAuth')->plainTextToken;

                return $this->jsonResponse('Đăng nhập thành công',true,$token);
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
    //              "email": "thongngo2ka4@gmail.com",
    //              "password": "thong15112004"
    //              "password_confirmation": "thong15112004"
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
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 1,
            ]);
        
            Auth::login($user);
        
            return $this->jsonResponse('Đăng ký thành công', true);
        } catch (\Exception $exception) {
            \DB::rollBack();
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
        $request->user()->currentAccessToken()->delete();
        return $this->jsonResponse('Đăng Xuất thành công',true);
    }
}