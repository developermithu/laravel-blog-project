<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->take(6)->published()->get();
        return view('index', compact('posts'));
    }

    public function posts()
    {
        $posts = Post::latest()->published()->simplePaginate(4);
        // $categories = Category::take(6)->get();
        return view('posts', compact('posts'));
    }

    // post/id na dekhiye (post/slug) wise dekhabo for SEO
    public function post($slug)
    {
        $post = Post::where('slug', $slug)->published()->first();
        // increase view count
        $postKey = 'post_' . $post->id;
        if (!Session::has($postKey)) {
            $post->increment('view_count');
            Session::put($postKey, 1);
        }
        return view('post', compact('post'));
    }

    public function categories()
    {
        $categories = Category::all();
        return view('categories', compact('categories'));
    }

    public function postByCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->published()->simplePaginate(10);
        // $categories = Category::all();
        return view('categoryPost', compact('posts', 'category'));
    }

    public function search(Request $request)
    {
        $this->validate($request, ['search' => 'required | max:255']);
        $search = $request->search;
        $posts = Post::where('title', 'like', "%$search%")->simplePaginate(10);
        $posts->appends(['search' => $search]); //without this pagination will not work

        // $categories = Category::all();
        return view('search', compact('posts', 'search'));
    }

    public function postByTag($name)
    {
        $query = $name;
        $tags = Tag::where('name', 'like', "%$name%")->simplePaginate(4);
        $tags->appends(['search' => $name]);
        return view('postByTag', compact('tags', 'query'));
    }

    public function likePost($post)
    {
        // check if the user already liked the post or not 
        $user = Auth::user();
        $likePost = $user->likedPosts()->where('post_id', $post)->count();
        if ($likePost == 0) {
            $user->likedPosts()->attach($post);
        } else {
            $user->likedPosts()->detach($post);
        }
        return redirect()->back();
    }
}
