<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('is_customer', true)->withCount('orders')->latest()->get();
        return view('admin.customers', compact('customers'));
    }

    public function show(User $user)
    {
        if (!$user->isCustomer()) abort(404);

        $user->loadCount('orders', 'addresses');
        $totalSpending = $user->orders()->where('payment_status', 'paid')->sum('total');
        $recentOrders  = $user->orders()->with('items')->latest()->take(5)->get();

        return response()->json([
            'id'              => $user->id,
            'name'            => $user->name,
            'email'           => $user->email,
            'phone'           => $user->phone,
            'is_customer'     => $user->is_customer,
            'orders_count'    => $user->orders_count,
            'addresses_count' => $user->addresses_count,
            'total_spending'  => number_format($totalSpending, 2),
            'created_at'      => $user->created_at->format('d M Y'),
            'recent_orders'   => $recentOrders->map(fn ($o) => [
                'order_number' => $o->order_number,
                'total'        => number_format($o->total, 2),
                'status'       => $o->statusLabel(),
                'status_badge' => $o->statusBadge(),
                'date'         => $o->created_at->format('d M Y'),
            ]),
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.customers')->with('success', 'Pelanggan berjaya dipadam.');
    }
}
