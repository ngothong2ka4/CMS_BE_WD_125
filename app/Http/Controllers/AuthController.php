<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        if (Auth::guard('sanctum')->check()) {
            return redirect('/');
        }else{
        return view('auth.forgot');
        }
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

            $user = User::where('email', $request->email)->where('role', '2')->where('status', 1)->first();

            if (!$user) {
                toastr()->error('Đã có lỗi xảy ra: Email không không đủ quyền hạn!');
                return redirect()->back()->withInput();
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
                        $message->subject('Đặt lại mật khẩu quản trị');
                    }
                );
                toastr()->success('Vui lòng kiểm tra email của bạn!');
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        return redirect()->back()->withInput();
        }
    }

    public function postResetPassword(Request $request, $token)
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
                toastr()->error('Đã có lỗi xảy ra: Đã quá thời hạn đổi mật khẩu!');
                return redirect()->route('forgot');
            }
            $user = User::where('email', $dataToken->email)->firstOrFail();

            $data = [
                'password' => bcrypt($request->password),
            ];
            $check = $user->update($data);
            // dd($data);
            if ($check) {
                UserResetToken::where('token', $token)->delete();
                toastr()->success('Đổi mật khẩu thành công!');
                return redirect()->route('login');
            }
           
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    function resetPassword(){
        if (Auth::guard('sanctum')->check()) {
            return redirect('/');
        }else{
        return view('auth.reset-pass');
        }
    }
}

