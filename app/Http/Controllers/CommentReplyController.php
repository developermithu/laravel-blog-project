<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentReply;

class CommentReplyController extends Controller
{
   // $comment means comment_id
   public function store(Request $request, $comment)
   {
       $this->validate($request, ['message' => 'required | max:1000']);
       $CommentReply = new CommentReply;
       $CommentReply->comment_id = $comment;
       $CommentReply->user_id = Auth::id();
       $CommentReply->message = $request->message;
       $CommentReply->save();
       Toastr::success('You replied successfully.');
       return redirect()->back();
   }
}
