<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $startFrom = $request->start_form ? $request->start_form : 0;
        $limit = $request->limit ? $request->limit : 10;

        $products = Product::leftJoin('category_product', 'category_product.product_id', '=', 'products.id');

        if (isset($request->category_ids))
            $products = $products->whereIn('category_id', $request->category_ids);

        $products = $products->select('products.*')
            ->orderBy('name', 'asc')
            ->skip($startFrom)->limit($limit)
            ->distinct()
            ->get();

        $products->load('categories');


        return response()->json([
            "data" => $products,
            "succes" => true,
            "message" => "Berhasil mengambil data"
        ]);
    }
}
