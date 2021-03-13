<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// include models
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;  // include Auth
use Brian2694\Toastr\Facades\Toastr;  // include Toastr
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id == $id) {
            Toastr::error('Admin can not changed role themselves!');
            return redirect()->back();
        }
        $user->role_id = $request->role;
        $user->save();
        Toastr::success('Role changed successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id == $id) {
            Toastr::error('Admin can not delete themselves!');
            return redirect()->back();
        }
        // Delete User Image without default img
        if ($user->image != 'default.jpg') {
            Storage::disk('public')->delete('user/' . $user->image);
        }
        $user->delete();
        Toastr::success('Deleted successfully');
        return redirect()->back();
    }
}
