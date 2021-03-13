<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Includes Models
use App\Models\Category;
use Illuminate\Support\Str;   // include Str
use Brian2694\Toastr\Facades\Toastr;  // include Toastr
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // public function create()
    // {
    //     //
    // }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | max:255 | unique:categories',  //unique:tableName
            'description' => 'sometimes | max:1000',
            'image' => 'required | image | mimes:jpeg,png,jpg | max:2048',
        ]);

        // image 
        $image = $request->image;
        $imageName = Str::slug($request->name, '-') . uniqid() . '-' . $image->getClientOriginalName();
        if (!Storage::disk('public')->exists('category')) {
            Storage::disk('public')->makeDirectory('category');
        }
        // image store
        $image->storeAs('category', $imageName, 'public');

        $category = new Category;
        $category->name = $request->name;  // php html js
        $category->slug = Str::slug($request->name, '-');  // php-html-js
        $category->description = $request->description;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Category created successfully!');
        return redirect()->back();
        // dd($request->all());
    }

    // public function show($id)
    // {
    //     //
    // }

    // public function edit($id)
    // {
    //     //
    // }

    public function update(Request $request, $id)
    {
        if ($request->name == Category::findOrFail($id)->name) {
            $this->validate($request, [
                'name' => 'required | max:255',  //not unique
                'description' => 'sometimes | max:1000',
                'image' => 'sometimes | image | mimes:jpeg,png,jpg | max:2048',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required | max:255 | unique:categories',
                'description' => 'sometimes | max:1000',
                'image' => 'sometimes | image | mimes:jpeg,png,jpg | max:2048',
            ]);
        }

        $category = Category::findOrFail($id);
        if ($request->image != NULL) {
            // image 
            $image = $request->image;
            $imageName = Str::slug($request->name, '-') . uniqid() . '-' . $image->getClientOriginalName();
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            // Delete Old Image
            if (Storage::disk('public')->exists('category/' . $category->image)) {
                Storage::disk('public')->delete('category/' . $category->image);
            }
            // image store
            $image->storeAs('category', $imageName, 'public');
        } else {
            $imageName = $category->image;
        }

        $category->name = $request->name;  // php html js
        $category->slug = Str::slug($request->name, '-');  // php-html-js
        $category->description = $request->description;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Category updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Delete Old Image
        Storage::disk('public')->delete('category/' . $category->image);
        $category->delete();
        Toastr::success('Category deleted successfully!');
        return redirect()->back();
    }
}
