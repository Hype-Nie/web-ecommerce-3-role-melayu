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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:20',
            'shop_name'=> 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'shop_name' => $request->shop_name,
            'password'  => $request->password,
            'role'      => 'seller',
        ]);

        return redirect()->route('admin.sellers')->with('success', 'Penjual berjaya ditambah.');
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
