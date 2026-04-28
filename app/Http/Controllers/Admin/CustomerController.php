<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->withCount('orders')->latest()->get();
        return view('admin.customers', compact('customers'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.customers')->with('success', 'Pelanggan berjaya dipadam.');
    }
}
