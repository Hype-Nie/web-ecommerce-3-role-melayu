<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $products   = Product::where('is_active', true)
                        ->where('stock', '>', 0)
                        ->with('seller', 'category')
                        ->latest()
                        ->take(8)
                        ->get();

        return view('landing', compact('categories', 'products'));
    }

    public function show(string $slug)
    {
        $product  = Product::where('slug', $slug)->with('seller', 'category', 'images')->firstOrFail();
        $related  = Product::where('category_id', $product->category_id)
                      ->where('id', '!=', $product->id)
                      ->where('is_active', true)
                      ->take(4)
                      ->get();

        return view('produk.show', compact('product', 'related'));
    }
}
