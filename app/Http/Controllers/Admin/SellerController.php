<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'seller')->withCount('products')->latest()->get();
        return view('admin.sellers', compact('sellers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'campus_id' => 'required|string|max:50|unique:users',
            'email'     => 'required|email|unique:users',
            'phone'     => 'required|string|max:20',
            'shop_name' => 'required|string|max:255',
            'password'  => 'required|string|min:6',
        ]);

        User::create([
            'name'      => $request->name,
            'campus_id' => $request->campus_id,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'shop_name' => $request->shop_name,
            'password'  => $request->password,
            'role'      => 'seller',
        ]);

        return redirect()->route('admin.sellers')->with('success', 'Penjual berjaya ditambah.');
    }

    public function show(User $user)
    {
        if ($user->role !== 'seller') abort(404);

        $totalSales = $user->products()
            ->withSum('orderItems', 'subtotal')
            ->get()
            ->sum('order_items_sum_subtotal');

        return response()->json([
            'id'             => $user->id,
            'name'           => $user->name,
            'email'          => $user->email,
            'phone'          => $user->phone,
            'shop_name'      => $user->shop_name,
            'is_active'      => $user->is_active,
            'products_count' => $user->products()->count(),
            'total_sales'    => number_format($totalSales ?? 0, 2),
            'created_at'     => $user->created_at->format('d M Y'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'seller') abort(404);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'required|string|max:20',
            'shop_name'=> 'required|string|max:255',
        ]);

        $data = $request->only('name', 'email', 'phone', 'shop_name');
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.sellers')->with('success', 'Penjual berjaya dikemaskini.');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return redirect()->route('admin.sellers')->with('success', 'Status penjual dikemaskini.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.sellers')->with('success', 'Penjual berjaya dipadam.');
    }
}
