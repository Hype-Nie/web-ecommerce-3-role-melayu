@extends('layouts.app')
@section('title', 'Daftar Akaun Baru')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in">
        {{-- Left Illustration --}}
        <div class="hidden lg:flex gradient-hero items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute top-10 right-10 w-40 h-40 bg-primary-400/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-10 left-10 w-56 h-56 bg-primary-300/10 rounded-full blur-2xl"></div>
            <div class="text-center relative z-10">
                <div class="w-24 h-24 mx-auto mb-6 rounded-3xl bg-white/10 backdrop-blur flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">Sertai CampusBuy!</h2>
                <p class="text-primary-200/70 text-sm max-w-xs mx-auto">Daftar sekarang dan mula jual-beli di kampus anda dengan mudah dan selamat.</p>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="p-8 lg:p-12">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Akaun Baru</h1>
                <p class="text-gray-500 text-sm">Lengkapkan butiran di bawah untuk mendaftar.</p>
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-danger-50 border border-danger-100 text-danger-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-4" id="register-form">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penuh</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="cth: Ahmad bin Ali" class="input-styled" required autofocus>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Campus ID / NIM</label>
                        <input type="text" name="campus_id" value="{{ old('campus_id') }}" placeholder="cth: 2024010001" class="input-styled" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">E-mel</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="input-styled" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telefon</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="cth: 012-3456789" class="input-styled" required>
                </div>

                {{-- Role Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer" id="role-customer-label">
                            <input type="radio" name="role" value="customer" class="peer sr-only" id="role-customer" {{ old('role', 'customer') == 'customer' ? 'checked' : '' }}>
                            <div class="rounded-xl border-2 border-gray-100 p-4 hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all">
                                <div class="flex items-center gap-3 mb-1">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <p class="font-bold text-gray-900">Pelanggan</p>
                                </div>
                                <p class="text-xs text-gray-500 ml-11">Beli produk di kampus.</p>
                            </div>
                        </label>
                        <label class="cursor-pointer" id="role-seller-label">
                            <input type="radio" name="role" value="seller" class="peer sr-only" id="role-seller" {{ old('role') == 'seller' ? 'checked' : '' }}>
                            <div class="rounded-xl border-2 border-gray-100 p-4 hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all">
                                <div class="flex items-center gap-3 mb-1">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <p class="font-bold text-gray-900">Penjual</p>
                                </div>
                                <p class="text-xs text-gray-500 ml-11">Mula berniaga di kampus.</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Shop Name (Seller Only) --}}
                <div id="shop-name-field" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kedai</label>
                    <input type="text" name="shop_name" value="{{ old('shop_name') }}" placeholder="cth: Kedai Ali Campus" class="input-styled" id="shop-name-input">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Laluan</label>
                        <div class="relative">
                            <input type="password" name="password" id="pw-reg" placeholder="Min. 8 aksara" class="input-styled !pr-12" required>
                            <button type="button" data-toggle-password="pw-reg" class="absolute right-4 top-1/2 -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sahkan Kata Laluan</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="pw-reg-conf" placeholder="Ulang kata laluan" class="input-styled !pr-12" required>
                            <button type="button" data-toggle-password="pw-reg-conf" class="absolute right-4 top-1/2 -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full text-center">Daftar Sekarang</button>
                </div>
                <p class="text-center text-sm text-gray-500 mt-6">Sudah mempunyai akaun? <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:text-primary-700">Log masuk</a></p>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleCustomer = document.getElementById('role-customer');
    const roleSeller = document.getElementById('role-seller');
    const shopField = document.getElementById('shop-name-field');
    const shopInput = document.getElementById('shop-name-input');

    function toggleShopName() {
        if (roleSeller.checked) {
            shopField.classList.remove('hidden');
            shopInput.required = true;
        } else {
            shopField.classList.add('hidden');
            shopInput.required = false;
        }
    }

    roleCustomer.addEventListener('change', toggleShopName);
    roleSeller.addEventListener('change', toggleShopName);
    toggleShopName(); // init
});
</script>
@endsection
