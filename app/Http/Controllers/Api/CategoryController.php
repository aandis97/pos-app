<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        
        return response()->json([
            "data" => $categories,
            "succes" => true,
            "message" => "Berhasil mengambil data"
        ]);
    }
}
