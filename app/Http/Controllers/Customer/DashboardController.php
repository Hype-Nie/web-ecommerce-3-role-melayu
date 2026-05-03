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
        $processingCount = $user->orders()->whereIn('status', ['sold', 'processing'])->count();
        $dates = collect(range(6, 0))->map(fn($days) => now()->subDays($days)->format('Y-m-d'));
        $chartLabels = $dates->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
        $chartData = $dates->map(fn($date) => $user->orders()->whereDate('created_at', $date)->sum('total'));

        return view('customer.dashboard', compact(
            'user', 'totalOrders', 'totalAddresses', 'recentOrders', 'processingCount', 'chartLabels', 'chartData'
        ));
    }
}
