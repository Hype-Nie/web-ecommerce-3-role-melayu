@extends('layouts.app')
@section('title', 'Log Masuk')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in">
        {{-- Left Illustration --}}
        <div class="hidden lg:flex gradient-hero items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute top-10 left-10 w-40 h-40 bg-primary-400/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-10 right-10 w-56 h-56 bg-primary-300/10 rounded-full blur-2xl"></div>
            <div class="text-center relative z-10">
                <div class="w-24 h-24 mx-auto mb-6 rounded-3xl bg-white/10 backdrop-blur flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">Selamat Kembali!</h2>
                <p class="text-primary-200/70 text-sm max-w-xs mx-auto">Log masuk ke akaun CampusBuy anda untuk meneruskan pengalaman jual-beli di kampus.</p>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="p-8 lg:p-12">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Log Masuk</h1>
                <p class="text-gray-500 text-sm">Pilih peranan anda dan masukkan maklumat log masuk.</p>
            </div>

            {{-- Role Tabs --}}
            <div class="flex rounded-xl bg-gray-100 p-1 mb-6" id="role-tabs">
                <button type="button" data-role="customer" class="role-tab flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-primary-700 shadow-sm">Pelanggan</button>
                <button type="button" data-role="seller" class="role-tab flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700">Penjual</button>
                <button type="button" data-role="admin" class="role-tab flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700">Admin</button>
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

            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="role" id="login-role" value="{{ old('role', 'customer') }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Campus ID / NIM</label>
                    <input type="text" name="campus_id" value="{{ old('campus_id') }}" placeholder="cth: 2024010001" class="input-styled" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">E-mel</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="input-styled" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Laluan</label>
                    <div class="relative">
                        <input type="password" name="password" id="pw-login" placeholder="Masukkan kata laluan" class="input-styled !pr-12" required>
                        <button type="button" data-toggle-password="pw-login" class="absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>
                </div>
                <button type="submit" class="btn-primary w-full text-center">Log Masuk</button>
                <p class="text-center text-sm text-gray-500">Belum ada akaun? <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:text-primary-700">Daftar sekarang</a></p>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.role-tab');
    const roleInput = document.getElementById('login-role');
    
    // Set initial state from old value
    const currentRole = roleInput.value || 'customer';
    tabs.forEach(tab => {
        if (tab.dataset.role === currentRole) {
            tab.classList.add('bg-white', 'text-primary-700', 'shadow-sm');
            tab.classList.remove('text-gray-500');
        } else {
            tab.classList.remove('bg-white', 'text-primary-700', 'shadow-sm');
            tab.classList.add('text-gray-500');
        }
    });

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => {
                t.classList.remove('bg-white', 'text-primary-700', 'shadow-sm');
                t.classList.add('text-gray-500');
            });
            this.classList.add('bg-white', 'text-primary-700', 'shadow-sm');
            this.classList.remove('text-gray-500');
            roleInput.value = this.dataset.role;
        });
    });
});
</script>
@endsection
