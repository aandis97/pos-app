<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::orderBy('name', 'asc')->paginate(10);
        $products->load('categories');
        return view('admin.product.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.product.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required|numeric',
            'category.*' => 'required'
        ]);

        $file = $request->file('image');
        $random = time() . rand(11111, 99999);
        $extension = $file->getClientOriginalName();
        $fileName = $random . '.' . $extension;
        $file->move("images/products", $fileName);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
            'price' => $request->price,
            'image' => $fileName
        ]);

        $categories = Category::find($request->category);

        $product->categories()->attach($categories);

        return redirect()->route('product.index')->with('success', 'Product  Added');
    }

    public function edit(Product $product)
    {
        $categories = Category::get();
        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Product $product)
    {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category.*' => 'required'
        ]);


        $fileName = $product->image ?? null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $random = time() . rand(11111, 99999);
            $extension = $file->getClientOriginalName();
            $fileName = $random . '.' . $extension;
            $file->move("images/products", $fileName);
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
            'price' => $request->price,
            'image' => $fileName
        ]);

        $product->categories()->sync($request->category);

        return redirect()->route('product.index')->with('success', 'Product Updated');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('danger', 'Product Deleted');
    }
}
