<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function showProfile()
    {
        $user = User::find(Auth::user()->id);
        return view('user.profile', compact('user'));
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
