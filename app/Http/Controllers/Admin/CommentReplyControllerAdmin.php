<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentReply;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentReplyControllerAdmin extends Controller
{
    public function index()
    {
        $comment_replies = CommentReply::all();
        return view('admin.replies.index', compact('comment_replies'));
    }

    public function destroy($id)
    {
        $comment_reply = CommentReply::findOrFail($id);
        $comment_reply->delete();
        Toastr::success('Reply deleted successfully');
        return redirect()->back();
    }
}
