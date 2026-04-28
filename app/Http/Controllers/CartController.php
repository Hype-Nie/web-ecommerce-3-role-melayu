<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product.seller')->get();
        $subtotal  = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'    => 'integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::where('user_id', auth()->id())
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + ($request->quantity ?? 1)]);
        } else {
            CartItem::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => $request->quantity ?? 1,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berjaya ditambah ke troli.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) abort(403);
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Produk dibuang dari troli.');
    }
}
