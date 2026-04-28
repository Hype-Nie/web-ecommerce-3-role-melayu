<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products   = auth()->user()->products()->with('category')->latest()->get();
        $categories = Category::where('is_active', true)->get();
        return view('seller.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        auth()->user()->products()->create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'old_price'   => $request->old_price,
            'stock'       => $request->stock,
            'description' => $request->description,
        ]);

        return redirect()->route('seller.products')->with('success', 'Produk berjaya ditambah.');
    }

    public function destroy(Product $product)
    {
        if ($product->seller_id !== auth()->id()) abort(403);
        $product->delete();
        return redirect()->route('seller.products')->with('success', 'Produk berjaya dipadam.');
    }
}
