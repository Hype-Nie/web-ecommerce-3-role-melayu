<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $products   = Product::where('is_active', true)
                        ->with('seller', 'category', 'images')
                        ->latest()
                        ->take(8)
                        ->get();

        return view('landing', compact('categories', 'products'));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('is_active', true)
                    ->with('seller', 'category', 'images');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->withCount('products')->get();

        return view('produk.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product  = Product::where('slug', $slug)->with('seller', 'category', 'images')->firstOrFail();
        $related  = Product::where('category_id', $product->category_id)
                      ->where('id', '!=', $product->id)
                      ->where('is_active', true)
                      ->with('images')
                      ->take(4)
                      ->get();

        return view('produk.show', compact('product', 'related'));
    }
}
