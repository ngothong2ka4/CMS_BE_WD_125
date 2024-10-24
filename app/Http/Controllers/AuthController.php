<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Password;

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
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        if(Auth::user()->status ==0){
            Auth::logout();
            return back()->withErrors([
                'login' => 'Tài khoản của bạn đã bị vô hiệu hóa.',
            ])->onlyInput('email');
        }
        $request->session()->regenerate();
        return redirect()->intended('statistic');
    }
    return back()->withErrors([
        'login' => 'Email hoặc mật khẩu không đúng.',
    ])->onlyInput('email');
}

    

   
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
        return redirect()->route('statistic');
       
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function forgot()
    {
        return view('auth.forgot');
    }
    public function sendPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users,email',
        ],[
            'email.required'=>'Chưa nhập email. Hãy nhập email của bạn!',
            'email.exists'=>'Email chưa được đăng ký trên hệ thống.'
        ]);
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
     
        // return $status === Password::RESET_LINK_SENT
        //             ? back()->with(['status' => __($status)])
        //             : back()->withErrors(['email' => __($status)]);
    }
}

