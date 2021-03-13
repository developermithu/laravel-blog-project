<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;  // include Auth
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;  // include Toastr
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        $users = User::all();
        $comments = Comment::latest()->get();
        $likes = DB::table('post_user')->get();
        return view('admin.index', compact('posts', 'categories', 'users', 'comments', 'likes'));
    }

    public function showProfile()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'userid' => 'required',
            'about' => 'sometimes | max:255',
            'image' => 'sometimes | image | mimes:jpeg,png,jpg | max:5000',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        if ($request->image != NULL) {
            $image = $request->image;
            $imageName = Str::slug($request->name, '-') . uniqid() . '-' . $image->getClientOriginalName();
            if (!Storage::disk('public')->exists('user')) {
                Storage::disk('public')->makeDirectory('user');
            }
            // Delete Old Image
            if ($user->image != 'default.jpg' && Storage::disk('public')->exists('user/' . $user->image)) {
                Storage::disk('public')->delete('user/' . $user->image);
            }
            // image store
            // Image Cropped Using Intervention Image Library
            $img = Image::make($image)->fit(200, 200)->stream();
            Storage::disk('public')->put('user/' . $imageName, $img);
        } else {
            $imageName = $user->image;
        }

        $user->name = $request->name;  // php html js
        $user->userid = $request->userid;
        $user->about = $request->about;
        $user->image = $imageName;
        $user->save();
        Toastr::success('Profile updated successfully!');
        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required | min:4 | confirmed',
        ]);

        $oldPassword = Auth::user()->password;  //hashed db pwd
        if (Hash::check($request->old_password, $oldPassword)) {
            // New password should not be same as old password
            if (!Hash::check($request->password, $oldPassword)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                // logout user after pwd change & redirect
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password should not be same as old password!');
                return redirect()->back();
            }
        } else {
            Toastr::error('Sorry! old password not matched.');
            return redirect()->back();
        }
    }
}
