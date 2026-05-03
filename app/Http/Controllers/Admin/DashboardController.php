<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function showOrder(Order $order)
    {
        $order->load('user', 'address', 'items');
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'id'             => $order->id,
                'order_number'   => $order->order_number,
                'customer'       => $order->user->name,
                'campus_id'      => $order->user->campus_id,
                'email'          => $order->user->email,
                'phone'          => $order->user->phone,
                'address'        => $order->address ? $order->address->fullDisplay() : '-',
                'status'         => $order->statusLabel(),
                'status_badge'   => $order->statusBadge(),
                'payment_method' => $order->payment_method ?? '-',
                'payment_status' => $order->payment_status,
                'subtotal'       => number_format($order->subtotal, 2),
                'total'          => number_format($order->total, 2),
                'whatsapp_sent'  => $order->whatsapp_sent,
                'created_at'     => $order->created_at->format('d M Y, H:i'),
                'items'          => $order->items->map(fn($i) => [
                    'name'     => $i->product_name,
                    'quantity' => $i->quantity,
                    'price'    => number_format($i->product_price, 2),
                    'subtotal' => number_format($i->subtotal, 2),
                ]),
            ]);
        }

        return back();
    }
}
