<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $properties = $product->ProductProperties()->with('ProductValues')->get();
        return view('client.product', ['product' => $product, 'properties' => $properties]);
    }
}
