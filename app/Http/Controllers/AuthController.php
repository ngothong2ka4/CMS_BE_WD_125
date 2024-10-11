<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  
    public function login()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
{
    // Validate dữ liệu
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ], [
        'email.required' => 'Email là bắt buộc.',
        'email.min' => 'Email phải là định dạng email.',
        'password.required' => 'Mật khẩu là bắt buộc.',
        'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
    ]);

    // Thử đăng nhập
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }
    return back()->withErrors([
        'login' => 'Email hoặc mật khẩu không đúng.',
    ])->onlyInput('email');
}

    // public function postLogin( Request $request)
    // {
    //     // $data=$request->only(['name','password']);
    //     // if(Auth::attempt($data)){
    //     //     return redirect()->intended('dashboard');
    //     // }else{
    //     //     return redirect()->back();
    //     // }
    //     $credentials = $request->validate([
    //         'name' => 'required|min:3|unique:users',
    //         'password' => 'required|min:8'
    //     ]);
    //     $credentials = $request->only(['name','password']);
    //     if(Auth::attempt( $credentials)){
    //         $request->session()->regenerate();
            
    //         // if(Auth::user()->isAdmin()){
    //         //     return redirect()->intended('dashboard');
    //         // }
    //         return redirect()->intended('dashboard');

    //     } 
    //     return back()->withErrors([
    //         'name'=>'Chưa có tài khoản',
    //     ])->onlyInput('name');
       
    // }

   
    public function register()
    {
        return view('auth.signup');
    }
    public function postRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed'
        ]);
        $user=User::query()->create($data);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
       
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

