<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('customer.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only('name', 'email', 'phone'));
        return redirect()->route('customer.profile')->with('success', 'Profil berjaya dikemaskini.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Sila masukkan kata laluan semasa.',
            'password.required'         => 'Sila masukkan kata laluan baru.',
            'password.min'              => 'Kata laluan mesti sekurang-kurangnya 8 aksara.',
            'password.confirmed'        => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Kata laluan semasa tidak betul.']);
        }

        auth()->user()->update(['password' => $request->password]);
        return redirect()->route('customer.profile')->with('success', 'Kata laluan berjaya ditukar.');
    }
}
