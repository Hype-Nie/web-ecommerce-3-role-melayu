<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user(), session('active_role'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'campus_id' => 'required|string',
            'email'     => 'required|email',
            'password'  => 'required',
            'role'      => 'required|in:customer,seller,admin',
        ], [
            'campus_id.required' => 'Sila masukkan Campus ID / NIM.',
            'email.required'     => 'Sila masukkan e-mel.',
            'email.email'        => 'Format e-mel tidak sah.',
            'password.required'  => 'Sila masukkan kata laluan.',
        ]);

        $credentials = $request->only('email', 'password');

        $selectedRole = $request->role;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Verify campus_id and role match
            $roleAllowed = match ($selectedRole) {
                'admin' => $user->isAdmin(),
                'seller' => $user->isSeller(),
                'customer' => $user->isCustomer(),
                default => false,
            };

            if ($user->campus_id !== $request->campus_id || !$roleAllowed) {
                Auth::logout();
                return back()->withErrors(['email' => 'Campus ID, e-mel, atau peranan tidak sepadan.'])->onlyInput('email', 'campus_id');
            }

            $request->session()->regenerate();
            $request->session()->put('active_role', $selectedRole);

            if ($selectedRole === 'seller' && !$user->is_active) {
                Auth::logout();
                $msg = 'Akaun penjual anda sedang menunggu pengesahan admin.';
                return back()->withErrors(['email' => $msg]);
            }

            return $this->redirectByRole($user, $selectedRole);
        }

        return back()->withErrors(['email' => 'E-mel atau kata laluan tidak sah.'])->onlyInput('email', 'campus_id');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $existingUser = \App\Models\User::where('email', $request->email)
            ->orWhere('campus_id', $request->campus_id)
            ->first();

        $rules = [
            'name'      => 'required|string|max:255',
            'campus_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'campus_id')->ignore($existingUser?->id),
            ],
            'email'     => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($existingUser?->id),
            ],
            'phone'     => 'required|string|max:20',
            'role'      => 'required|in:customer,seller',
            'password'  => 'required|string|min:8|confirmed',
        ];

        $messages = [
            'name.required'      => 'Sila masukkan nama.',
            'campus_id.required' => 'Sila masukkan Campus ID / NIM.',
            'campus_id.unique'   => 'Campus ID ini telah didaftarkan.',
            'email.required'     => 'Sila masukkan e-mel.',
            'email.unique'       => 'E-mel ini telah didaftarkan.',
            'phone.required'     => 'Sila masukkan nombor telefon.',
            'password.required'  => 'Sila masukkan kata laluan.',
            'password.min'       => 'Kata laluan mesti sekurang-kurangnya 8 aksara.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
        ];

        if ($request->role === 'seller') {
            $rules['shop_name'] = 'required|string|max:255';
            $messages['shop_name.required'] = 'Sila masukkan nama kedai.';
        }

        $request->validate($rules, $messages);

        if ($existingUser) {
            if ($existingUser->isAdmin()) {
                return back()->withErrors(['email' => 'Akaun admin tidak boleh didaftarkan semula.'])->onlyInput('email', 'campus_id');
            }

            if ($request->role === 'customer') {
                return back()->withErrors(['email' => 'Akaun sudah wujud. Sila log masuk untuk teruskan.'])->onlyInput('email', 'campus_id');
            }

            if (!Hash::check($request->password, $existingUser->password)) {
                return back()->withErrors(['password' => 'Kata laluan tidak sepadan untuk akaun sedia ada.'])->onlyInput('email', 'campus_id');
            }

            $existingUser->update([
                'name'        => $request->name,
                'phone'       => $request->phone,
                'shop_name'   => $request->shop_name,
                'is_seller'   => true,
                'is_customer' => true,
                'is_active'   => false,
            ]);

            return redirect()->route('login')->with('success', 'Permohonan penjual diterima. Sila tunggu pengesahan admin.');
        }

        $user = \App\Models\User::create([
            'name'      => $request->name,
            'campus_id' => $request->campus_id,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => $request->password,
            'role'      => $request->role,
            'shop_name' => $request->role === 'seller' ? $request->shop_name : null,
            'is_active' => $request->role === 'seller' ? false : true,
            'is_seller' => $request->role === 'seller',
            'is_customer' => true,
        ]);

        if ($user->role === 'seller') {
            return redirect()->route('login')->with('success', 'Pendaftaran berjaya. Sila tunggu pengesahan admin untuk akaun penjual anda.');
        }

        Auth::login($user);
        session(['active_role' => 'customer']);
        return redirect()->route('customer.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    private function redirectByRole($user, ?string $role = null)
    {
        $role = $role ?: session('active_role');

        if (!$role) {
            $role = $user->isAdmin() ? 'admin' : ($user->isSeller() ? 'seller' : 'customer');
        }

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default => redirect()->route('landing'),
        };
    }
}
