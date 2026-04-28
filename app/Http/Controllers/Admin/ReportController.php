<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders       = $query->latest()->get();
        $totalOrders  = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total');
        $avgOrder     = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('admin.reports', compact('orders', 'totalOrders', 'totalRevenue', 'avgOrder'));
    }
}
