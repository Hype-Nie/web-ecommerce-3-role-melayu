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

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:processing,shipped,completed,cancelled']);
        $order->update(['status' => $request->status]);

        return redirect()->route('seller.transactions')->with('success', 'Status pesanan dikemaskini.');
    }
}
