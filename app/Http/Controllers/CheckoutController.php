<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user      = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Troli anda kosong.');
        }

        $addresses     = $user->addresses()->orderByDesc('is_default')->get();
        $shippingTypes = ShippingType::where('is_active', true)->get();
        $subtotal      = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);

        return view('checkout', compact('cartItems', 'addresses', 'shippingTypes', 'subtotal'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id'       => 'required|exists:addresses,id',
            'shipping_type_id' => 'required|exists:shipping_types,id',
            'payment_method'   => 'required|string',
        ]);

        $user      = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Troli anda kosong.');
        }

        $shipping = ShippingType::findOrFail($request->shipping_type_id);
        $subtotal = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);
        $total    = $subtotal + $shipping->price;

        DB::transaction(function () use ($user, $cartItems, $request, $shipping, $subtotal, $total) {
            $order = Order::create([
                'order_number'     => Order::generateOrderNumber(),
                'user_id'          => $user->id,
                'address_id'       => $request->address_id,
                'shipping_type_id' => $shipping->id,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shipping->price,
                'total'            => $total,
                'status'           => 'pending',
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'paid', // Simulated
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product->name,
                    'product_price' => $item->product->price,
                    'quantity'      => $item->quantity,
                    'subtotal'      => $item->product->price * $item->quantity,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $user->cartItems()->delete();
        });

        return redirect()->route('customer.orders')->with('success', 'Pesanan berjaya dibuat! Terima kasih.');
    }
}
