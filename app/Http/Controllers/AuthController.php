<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Sila masukkan e-mel.',
            'email.email'       => 'Format e-mel tidak sah.',
            'password.required' => 'Sila masukkan kata laluan.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                $msg = $user->role === 'seller' ? 'Akaun penjual anda sedang menunggu pengesahan admin.' : 'Akaun anda telah dinyahaktifkan.';
                return back()->withErrors(['email' => $msg]);
            }

            return $this->redirectByRole($user);
        }

        return back()->withErrors(['email' => 'E-mel atau kata laluan tidak sah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:20',
            'role'     => 'required|in:customer,seller',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Sila masukkan nama.',
            'email.required'     => 'Sila masukkan e-mel.',
            'email.unique'       => 'E-mel ini telah didaftarkan.',
            'phone.required'     => 'Sila masukkan nombor telefon.',
            'password.required'  => 'Sila masukkan kata laluan.',
            'password.min'       => 'Kata laluan mesti sekurang-kurangnya 8 aksara.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->password, // hashed via cast
            'role'     => $request->role,
            'is_active'=> $request->role === 'seller' ? false : true,
        ]);

        if ($user->role === 'seller') {
            return redirect()->route('login')->with('success', 'Pendaftaran berjaya. Sila tunggu pengesahan admin untuk akaun penjual anda.');
        }

        Auth::login($user);
        return redirect()->route('customer.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'seller'   => redirect()->route('seller.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default    => redirect()->route('landing'),
        };
    }
}
