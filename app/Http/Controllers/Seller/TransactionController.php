<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $productIds = auth()->user()->products()->pluck('id');

        $orders = Order::whereHas('items', fn ($q) => $q->whereIn('product_id', $productIds))
                    ->with('user', 'items')
                    ->latest()
                    ->get();

        return view('seller.transactions', compact('orders'));
    }

    public function show(Order $order)
    {
        $productIds = auth()->user()->products()->pluck('id');

        // Verify this order contains seller's products
        if (!$order->items()->whereIn('product_id', $productIds)->exists()) {
            abort(403);
        }

        $order->load('user', 'items', 'address', 'shippingType');

        return response()->json([
            'id'             => $order->id,
            'order_number'   => $order->order_number,
            'status'         => $order->status,
            'status_label'   => $order->statusLabel(),
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'subtotal'       => number_format($order->subtotal, 2),
            'shipping_cost'  => number_format($order->shipping_cost, 2),
            'total'          => number_format($order->total, 2),
            'created_at'     => $order->created_at->format('d M Y, H:i'),
            'customer'       => [
                'name'  => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
            ],
            'address' => $order->address ? [
                'label'          => $order->address->label,
                'recipient_name' => $order->address->recipient_name,
                'phone'          => $order->address->phone,
                'full_display'   => $order->address->fullDisplay(),
            ] : null,
            'shipping' => $order->shippingType ? [
                'name'           => $order->shippingType->name,
                'estimated_days' => $order->shippingType->estimated_days,
            ] : null,
            'items' => $order->items->map(fn ($item) => [
                'product_name'  => $item->product_name,
                'product_price' => number_format($item->product_price, 2),
                'quantity'      => $item->quantity,
                'subtotal'      => number_format($item->subtotal, 2),
            ]),
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:processing,shipped,completed,cancelled']);
        $order->update(['status' => $request->status]);

        return redirect()->route('seller.transactions')->with('success', 'Status pesanan dikemaskini.');
    }
}
