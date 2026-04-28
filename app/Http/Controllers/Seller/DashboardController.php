<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $seller      = auth()->user();
        $productIds  = $seller->products()->pluck('id');

        $totalProducts = $seller->products()->count();
        $lowStock      = $seller->products()->where('stock', '<=', 5)->where('stock', '>', 0)->count();
        $newOrders     = OrderItem::whereIn('product_id', $productIds)
                            ->whereHas('order', fn ($q) => $q->where('status', 'pending'))
                            ->count();

        $monthlyRevenue = OrderItem::whereIn('product_id', $productIds)
                            ->whereHas('order', fn ($q) => $q->where('payment_status', 'paid')
                                ->whereMonth('created_at', now()->month))
                            ->sum('subtotal');

        $recentOrders = Order::whereHas('items', fn ($q) => $q->whereIn('product_id', $productIds))
                        ->with('user', 'items')
                        ->latest()
                        ->take(5)
                        ->get();

        return view('seller.dashboard', compact(
            'totalProducts', 'newOrders', 'monthlyRevenue', 'lowStock', 'recentOrders'
        ));
    }
}
