<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentControllerAdmin extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        // foreign key delete setup with migration
        // $replies = CommentReply::where('comment_id', $id)->get();
        // foreach ($replies as $reply) {
        //     $reply->delete();
        // }
        $comment->delete();
        Toastr::success('Comment deleted successfully');
        return redirect()->back();
    }
}
