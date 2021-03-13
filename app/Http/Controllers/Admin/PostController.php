<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewPost;
use Illuminate\Http\Request;

// include all model & others
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;   // include Str
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function likedUser($post)
    {
        $post = Post::findOrFail($post);
        return view('admin.posts.likedUser', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd(explode(',', $request->tags));
        $this->validate($request, [
            'title' => 'required | max:255 | unique:posts',  //unique:tableName
            'image' => 'required | image | mimes:jpeg,png,jpg | max:5000',
            'category' => 'required',
            'body' => 'required',
            'status' => 'required',
            'tags' => 'required',
        ]);

        $slug = Str::slug($request->title, '-');
        $image = $request->image;
        $imageName = $slug . '-' . uniqid() . Carbon::now()->timestamp . '-' . $image->getClientOriginalName();
        if (!Storage::disk('public')->exists('post')) {
            Storage::disk('public')->makeDirectory('post');
        }
        // Image Cropped Using Intervention Image Library
        $img = Image::make($image)->resize(752, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->stream();
        Storage::disk('public')->put('post/' . $imageName, $img);

        $post = new Post;
        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->image = $imageName;
        $post->slug = $slug;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = 1;
        }
        $post->save();

        // send mail notification to all users
        if ($post->status) {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->queue(new NewPost($post));
            }
        }

        // store tags as tags table
        $tags = [];
        $stringTags = array_map("trim", explode(',', $request->tags));  // php,html,css  =  php html css korbe
        foreach ($stringTags as $tag) {
            array_push($tags, ['name' => $tag]);  //tag table er name
        }
        $post->tags()->createMany($tags);
        Toastr::success('Post created successfully!');
        return redirect()->route('admin.post');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->title == $post->title) {
            $this->validate($request, [
                'title' => 'required | max:255',  //not to need unique
                'image' => 'sometimes | image | mimes:jpeg,png,jpg | max:5000',
                'category' => 'required',
                'body' => 'required',
                'status' => 'required',
                'tags' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'title' => 'required | max:255 | unique:posts',  //unique:post title
                'image' => 'sometimes | image | mimes:jpeg,png,jpg | max:5000',
                'category' => 'required',
                'body' => 'required',
                'status' => 'required',
                'tags' => 'required',
            ]);
        }

        $slug = Str::slug($request->title, '-');

        if (isset($request->image)) {
            $image = $request->image;
            $imageName = $slug . '-' . uniqid() . Carbon::now()->timestamp . '-' . $image->getClientOriginalName();
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            // Delete Old Image
            if (Storage::disk('public')->exists('post/' . $post->image)) {
                Storage::disk('public')->delete('post/' . $post->image);
            }
            // Image Cropped Using Intervention Image Library
            $img = Image::make($image)->resize(752, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();
            Storage::disk('public')->put('post/' . $imageName, $img);
        } else {
            $imageName = $post->image;
        }

        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->category_id = $request->category;
        $post->image = $imageName;
        $post->slug = $slug;
        // $post->tag = $request->tag;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = 1;
        }
        $post->save();

        // send mail notification to all users
        if ($post->status) {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->queue(new NewPost($post));
            }
        }
        
        // delete old tags
        $post->tags()->delete();
        // store tags as tags table
        $tags = [];
        $stringTags = array_map("trim", explode(',', $request->tags));  // php,html,css  =  php html css korbe
        foreach ($stringTags as $tag) {
            array_push($tags, ['name' => $tag]);  //tag table er name
        }
        $post->tags()->createMany($tags);

        Toastr::success('Post updated successfully!');
        return redirect()->route('admin.post');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        // Delete Old Image
        Storage::disk('public')->delete('post/' . $post->image);
        // foreign key delete function already setup with migration
        // $post->tags()->delete();

        $post->delete();
        Toastr::success('Post deleted successfully!');
        return redirect()->route('admin.post');
    }
}
