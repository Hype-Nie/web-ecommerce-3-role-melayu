<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Papan Pemuka') — Penjual KedaiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
<div class="flex min-h-screen">
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden"></div>
    <aside id="sidebar" class="fixed lg:sticky top-0 left-0 z-50 w-72 h-screen gradient-sidebar flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <div class="p-6 border-b border-white/5">
            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg">KedaiKu</h1>
                    <p class="text-xs text-gray-500">Panel Penjual</p>
                </div>
            </a>
        </div>
        <nav class="flex-1 overflow-y-auto sidebar-scrollbar p-4 space-y-1">
            <p class="text-xs uppercase tracking-wider text-gray-600 font-semibold px-4 mb-3">Utama</p>
            <a href="{{ route('seller.dashboard') }}" class="nav-item {{ request()->routeIs('seller.dashboard') ? 'nav-item-active' : 'nav-item-default' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Papan Pemuka
            </a>
            <p class="text-xs uppercase tracking-wider text-gray-600 font-semibold px-4 mt-6 mb-3">Pengurusan</p>
            <a href="{{ route('seller.products') }}" class="nav-item {{ request()->routeIs('seller.products') ? 'nav-item-active' : 'nav-item-default' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Produk
            </a>
            <a href="{{ route('seller.transactions') }}" class="nav-item {{ request()->routeIs('seller.transactions') ? 'nav-item-active' : 'nav-item-default' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Transaksi
            </a>
        </nav>
        <div class="p-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-sm">P</div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">Kedai Aminah</p>
                    <p class="text-gray-500 text-xs truncate">aminah@kedaiku.my</p>
                </div>
                <a href="{{ route('landing') }}" class="text-gray-500 hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></a>
            </div>
        </div>
    </aside>
    <div class="flex-1 flex flex-col min-w-0">
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">@yield('page_title', 'Papan Pemuka')</h2>
                        <p class="text-sm text-gray-500">@yield('page_subtitle', 'Selamat datang kembali!')</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="relative p-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-danger-500 rounded-full border-2 border-white"></span>
                    </button>
                </div>
            </div>
        </header>
        <div class="flex-1 p-6 lg:p-8">@yield('content')</div>
    </div>
</div>
@yield('scripts')
</body>
</html>
