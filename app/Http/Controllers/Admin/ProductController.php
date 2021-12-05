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
          'name' => 'required',
          'description' => 'required',
          'price' => 'required|numeric',
          'category.*' => 'required'
        ]);

        $image = $request->file('image')->store('products');

        $product = Product::create([
          'name' => $request->name,
          'slug' => Str::slug($request->name, '-'),
          'description' => $request->description,
          'price' => $request->price,
          'image' => $image
        ]);

        $categories = Category::find($request->category);

        $product->categories()->attach($categories);

        return redirect()->route('product.index')->with('success','Product  Added');
    }

    public function edit(Product $product)
    {
      $categories = Category::get();
      return view('admin.product.edit',[
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

          
        $image = $product->image ?? null;

        if($request->hasFile('image')){
          if($product->image) {
            Storage::delete($product->image);
          }
          $image = $request->file('image')->store('products');
        }

        $product->update([
          'name' => $request->name,
          'slug' => Str::slug($request->name, '-'),
          'description' => $request->description,
          'price' => $request->price,
          'image' => $image
        ]);

        $product->categories()->sync($request->category);

        return redirect()->route('product.index')->with('success','Product Updated');
    }

    public function destroy(Product $product)
    {
        if($product->image) {
          Storage::delete($product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('danger','Product Deleted');
    }
}
