<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // onk gula comment er post ekta thakbe
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    // onk gula comment er user ekta thakbe
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\CommentReply');
    }

}
