<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Stone;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        $stones = Stone::all();
        return view('product.product_tag.index', compact('materials', 'stones'));
    }
}
