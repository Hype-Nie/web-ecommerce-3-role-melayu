<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products   = auth()->user()->products()->with('category', 'images')->latest()->get();
        $categories = Category::where('is_active', true)->get();
        return view('seller.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images'      => 'nullable|array|max:5',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = auth()->user()->products()->create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(5),
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'old_price'   => $request->old_price,
            'description' => $request->description,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('seller.products')->with('success', 'Produk berjaya ditambah.');
    }

    public function show(Product $product)
    {
        if ($product->seller_id !== auth()->id()) abort(403);

        $product->load('category', 'images');

        return response()->json([
            'id'          => $product->id,
            'name'        => $product->name,
            'slug'        => $product->slug,
            'description' => $product->description,
            'price'       => $product->price,
            'old_price'   => $product->old_price,

            'is_active'   => $product->is_active,
            'category_id' => $product->category_id,
            'category'    => $product->category->name,
            'images'      => $product->images->map(fn ($img) => [
                'id'         => $img->id,
                'url'        => asset('storage/' . $img->image_path),
                'is_primary' => $img->is_primary,
            ]),
            'created_at'  => $product->created_at->format('d M Y'),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== auth()->id()) abort(403);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images'      => 'nullable|array|max:5',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id',
        ]);

        $product->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(5),
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'old_price'   => $request->old_price,
            'description' => $request->description,
        ]);

        // Delete selected images
        if ($request->filled('delete_images')) {
            $imagesToDelete = ProductImage::where('product_id', $product->id)
                ->whereIn('id', $request->delete_images)
                ->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $maxSort = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $product->images()->count() === 0 && $i === 0,
                    'sort_order' => $maxSort + $i + 1,
                ]);
            }
        }

        return redirect()->route('seller.products')->with('success', 'Produk berjaya dikemaskini.');
    }

    public function destroy(Product $product)
    {
        if ($product->seller_id !== auth()->id()) abort(403);

        // Delete product images from storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->delete();
        return redirect()->route('seller.products')->with('success', 'Produk berjaya dipadam.');
    }
}
