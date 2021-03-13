<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{

    // $post means post_id
    public function store(Request $request, $post)
    {
        $this->validate($request, ['comment' => 'required | max:1000']);
        $comment = new Comment;
        $comment->post_id = $post;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;
        $comment->save();
        Toastr::success('Thanks for your comment.');
        return redirect()->back();
    }
}
