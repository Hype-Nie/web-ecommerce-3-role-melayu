<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
        return view('customer.addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'full_address'   => 'required|string',
        ]);

        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create([
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'full_address'   => $request->full_address,
            'city'           => $request->city,
            'postcode'       => $request->postcode,
            'state'          => $request->state,
            'is_default'     => $isDefault,
        ]);

        return redirect()->route('customer.addresses')->with('success', 'Alamat berjaya ditambah.');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);

        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('customer.addresses')->with('success', 'Alamat utama dikemaskini.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);
        $address->delete();
        return redirect()->route('customer.addresses')->with('success', 'Alamat berjaya dipadam.');
    }
}
