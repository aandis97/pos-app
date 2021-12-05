<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description
        ]);

        return redirect()->route('category.index')->with('success', 'Category Added');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description
        ]);

        return redirect()->route('category.index')->with('info', 'Category Edited');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('danger', 'Category Deleted');;
    }
}
