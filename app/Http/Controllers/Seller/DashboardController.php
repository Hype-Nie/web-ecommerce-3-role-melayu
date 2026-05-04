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
        $productIds  = $seller->products()->pluck('id')->toArray();

        $totalProducts = $seller->products()->count();
        $totalOrders   = Order::whereHas('items', fn ($q) => $q->whereIn('product_id', $productIds))->count();
        $newOrders     = OrderItem::whereIn('product_id', $productIds)
                            ->whereHas('order', fn ($q) => $q->where('status', 'sold'))
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
        $dates = collect(range(6, 0))->map(fn($days) => now()->subDays($days)->format('Y-m-d'));
        $chartLabels = $dates->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
        $chartData = $dates->map(fn($date) => OrderItem::whereIn('product_id', $productIds)
                            ->whereHas('order', fn ($q) => $q->where('payment_status', 'paid')->whereDate('created_at', $date))
                            ->sum('subtotal'));

        return view('seller.dashboard', compact(
            'totalProducts', 'newOrders', 'monthlyRevenue', 'totalOrders', 'recentOrders', 'chartLabels', 'chartData'
        ));
    }
}
