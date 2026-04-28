<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user          = auth()->user();
        $totalOrders   = $user->orders()->count();
        $totalAddresses = $user->addresses()->count();
        $recentOrders  = $user->orders()->with('items')->latest()->take(3)->get();
        $processingCount = $user->orders()->whereIn('status', ['pending', 'processing'])->count();

        return view('customer.dashboard', compact(
            'user', 'totalOrders', 'totalAddresses', 'recentOrders', 'processingCount'
        ));
    }
}
