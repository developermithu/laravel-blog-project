<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentControllerUser extends Controller
{
    public function index()
    {
        $comments = Comment::where('user_id', Auth::id())->latest()->get();
        return view('user.comments', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        // $replies = CommentReply::where('comment_id', $id)->get();
        
        if ($comment->user_id == Auth::id()) {
            // foreach ($replies as $reply) {
            //     $reply->delete();
            // }
            $comment->delete();
            Toastr::success('Comment deleted successfully');
            return redirect()->back();
        } else {
            Toastr::error('You can not delete this comment!');
            return redirect()->back();
        }
    }
}
