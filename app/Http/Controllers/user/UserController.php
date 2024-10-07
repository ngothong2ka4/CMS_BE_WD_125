<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users= User::all();
        return view('user.index',compact('users'));
    }
    public function show(Request $request, $id)
    {
        // $users= User::first($id);
        $user= User::findOrFail($id);
        return view('user.show',compact('user'));
    }
    public function status(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $user->status=!$user->status;
        $user->save();
        toastr()->success('Tài khoản đã được cập nhật thành công !');
        return redirect()->back(); 
    }
}
