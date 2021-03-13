<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // belongsTo hole method name (singular)
    public function user()
    {
        return $this->belongsTo('App\Models\User');  //user_id
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');  //category_id
    }

    // hasMany hole method name (plural) &  ekta post er onek tag hobe
    public function tags()
    {
        return $this->hasMany('App\Models\Tag', 'postID', 'id');
    }

// ekta post er onk gula comment thakbe
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

       // many to many
       public function likedUsers()
       {
           return $this->belongsToMany('App\Models\User')->withTimestamps();
       }

    // Define Scope
    // published()
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
