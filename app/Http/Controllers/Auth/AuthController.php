<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use DB;
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
    public function login()
    {

        return view('auth.login');
    }
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => 'required|min:3|email|unique:users',
            'password' => 'required|min:8'
        ]);
        if(Auth::attempt( $credentials)){
            $request->session()->regenerate();
            
            // if(Auth::user()->isAdmin()){
            //     return redirect()->intended('dashboard');
            // }
            return redirect()->intended('dashboard');


        }
        return back()->withErrors([
            'email'=>'Chưa có tài khoản',
        ])->onlyInput('email');
        // try {
        //     $credentials = $request->only('email', 'password');

        //     if (Auth::attempt($credentials)) {
        //         $user = Auth::user();
        //         $token = $user->createToken('tokenAuth')->plainTextToken;
        //         $data = [
        //             'role' => $user->role,
        //             'token' => $token,
        //         ];
        //         return $this->jsonResponse('Đăng nhập thành công', true, $data);
        //     }

        //     return $this->jsonResponse('Thông tin đăng nhập không chính xác');
        // } catch (\Exception $exception) {
        //     \DB::rollBack();
        //     \Log::error($exception->getMessage());
        //     return $this->jsonResponse('Common Exception');
        // }
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
    public function register()
    {

        return view('auth.signup');
    }
    public function postRegister(RegisterRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = User::query()->create($data);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
        // dd($data);
        // try {
        //     $user = User::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'password' => Hash::make($request->password),
        //         'role' => 1,
        //         'status' => 1,
        //     ]);

        //     if ($user) {
        //         Auth::login($user);
        //         $token = $user->createToken('tokenAuth')->plainTextToken;
        //         $data = [
        //             'role' => $user->role,
        //             'token' => $token,
        //         ];
        //         return $this->jsonResponse('Đăng ký thành công', true, $data);
        //     } else {
        //         return $this->jsonResponse('Đăng ký thất bại');
        //     }
        // } catch (\Exception $exception) {
        //     \DB::rollBack();
        //     \Log::error($exception->getMessage());
        //     return $this->jsonResponse('Common Exception');
        // }

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
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
        // if ($request->user()) {
        //     $request->user()->currentAccessToken()->delete();

        //     return $this->jsonResponse('Đăng Xuất thành công', true);
        // }

        // return $this->jsonResponse('Người dùng không được xác thực');
    }
}
