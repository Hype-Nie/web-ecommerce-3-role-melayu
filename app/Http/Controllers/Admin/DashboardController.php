<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSellers   = User::where('role', 'seller')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts  = Product::count();
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total');
        $recentOrders   = Order::with('user')->latest()->take(5)->get();
        $dates = collect(range(6, 0))->map(fn($days) => now()->subDays($days)->format('Y-m-d'));
        $chartLabels = $dates->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
        $chartData = $dates->map(fn($date) => Order::where('payment_status', 'paid')->whereDate('created_at', $date)->sum('total'));

        return view('admin.dashboard', compact(
            'totalSellers', 'totalCustomers', 'totalProducts', 'totalRevenue', 'recentOrders', 'chartLabels', 'chartData'
        ));
    }
}
