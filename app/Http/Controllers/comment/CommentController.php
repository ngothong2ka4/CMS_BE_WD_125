<?php

namespace App\Http\Controllers\comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('comment.index', compact('comments'));
    }
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comment.show', compact('comment'));
    }
    // public function destroy($id)
    // {
    //     $comment = Comment::findOrFail($id);
    //     $comment->delete();
    //     toastr()->success('Xóa bình luận thành công!');
    //     return redirect()->back();
    // }
    public function status($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = !$comment->status;
        $comment->save();
        toastr()->success('Tài khoản đã được cập nhật thành công !');
        return redirect()->back();
    }
}
