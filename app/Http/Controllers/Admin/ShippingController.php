<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingType;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = ShippingType::latest()->get();
        return view('admin.shipping', compact('shippings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        ShippingType::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'price'          => $request->price,
            'estimated_days' => $request->estimated_days,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.shipping')->with('success', 'Jenis penghantaran berjaya ditambah.');
    }

    public function destroy(ShippingType $shippingType)
    {
        $shippingType->delete();
        return redirect()->route('admin.shipping')->with('success', 'Jenis penghantaran berjaya dipadam.');
    }
}
