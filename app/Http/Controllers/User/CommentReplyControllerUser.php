<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommentReply;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReplyControllerUser extends Controller
{
    public function index()
    {
        $comment_replies = CommentReply::where('user_id', Auth::id())->latest()->get();
        return view('user.replies', compact('comment_replies'));
    }

    public function destroy($id)
    {
        $comment_reply = CommentReply::findOrFail($id);

        if ($comment_reply->user_id == Auth::id()) {
            $comment_reply->delete();
            Toastr::success('Replied deleted successfully');
            return redirect()->back();
        } else {
            Toastr::error('You can not delete this reply!');
            return redirect()->back();
        }
    }
}
