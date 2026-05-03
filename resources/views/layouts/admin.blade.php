<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Papan Pemuka') — Admin CampusBuy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">

        {{-- ══════════ SIDEBAR ══════════ --}}
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <aside id="sidebar" class="fixed lg:sticky top-0 left-0 z-50 w-72 h-screen gradient-sidebar flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">
            {{-- Logo --}}
            <div class="p-6 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg tracking-tight">CampusBuy</h1>
                        <p class="text-xs text-gray-500">Panel Admin</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto sidebar-scrollbar p-4 space-y-1">
                <p class="text-xs uppercase tracking-wider text-gray-600 font-semibold px-4 mb-3">Utama</p>

                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : 'nav-item-default' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Papan Pemuka
                </a>

                <p class="text-xs uppercase tracking-wider text-gray-600 font-semibold px-4 mt-6 mb-3">Pengurusan</p>

                <a href="{{ route('admin.sellers') }}" class="nav-item {{ request()->routeIs('admin.sellers') ? 'nav-item-active' : 'nav-item-default' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Penjual
                </a>

                <a href="{{ route('admin.customers') }}" class="nav-item {{ request()->routeIs('admin.customers') ? 'nav-item-active' : 'nav-item-default' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    Pelanggan
                </a>

                <a href="{{ route('admin.categories') }}" class="nav-item {{ request()->routeIs('admin.categories') ? 'nav-item-active' : 'nav-item-default' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>



                <p class="text-xs uppercase tracking-wider text-gray-600 font-semibold px-4 mt-6 mb-3">Laporan</p>

                <a href="{{ route('admin.reports') }}" class="nav-item {{ request()->routeIs('admin.reports') ? 'nav-item-active' : 'nav-item-default' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Laporan Transaksi
                </a>
            </nav>

            {{-- User Info --}}
            <div class="p-4 border-t border-white/5">
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="w-9 h-9 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-sm">{{ substr(auth()->user()->name,0,1) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-white transition-colors" title="Log keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ══════════ MAIN AREA ══════════ --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Bar --}}
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
                        {{-- Search --}}
                        <div class="hidden md:block relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" placeholder="Cari... (Ctrl+K)" class="input-search search-global w-64">
                        </div>
                        {{-- Notifications --}}
                        @php
                            $pendingSellersCount = \App\Models\User::where('role', 'seller')->where('is_active', false)->count();
                            $todayOrdersCount = \App\Models\Order::whereDate('created_at', today())->count();
                            $totalNotifications = $pendingSellersCount + $todayOrdersCount;
                        @endphp
                        <div class="relative" id="notification-dropdown-container">
                            <button onclick="document.getElementById('notification-menu').classList.toggle('hidden')" class="relative p-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @if($totalNotifications > 0)
                                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-danger-500 rounded-full border-2 border-white"></span>
                                @endif
                            </button>
                            <div id="notification-menu" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                                <div class="p-4 border-b border-gray-100 font-bold text-gray-900">Notifikasi</div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if($totalNotifications === 0)
                                        <p class="p-4 text-sm text-gray-500 text-center">Tiada notifikasi baru</p>
                                    @else
                                        @if($pendingSellersCount > 0)
                                        <a href="{{ route('admin.sellers') }}" class="block p-4 hover:bg-gray-50 border-b border-gray-50">
                                            <p class="text-sm font-semibold text-gray-900">Penjual Baru</p>
                                            <p class="text-xs text-gray-500 mt-1">Terdapat {{ $pendingSellersCount }} penjual menunggu pengesahan.</p>
                                        </a>
                                        @endif
                                        @if($todayOrdersCount > 0)
                                        <a href="{{ route('admin.reports') }}" class="block p-4 hover:bg-gray-50">
                                            <p class="text-sm font-semibold text-gray-900">Pesanan Baru</p>
                                            <p class="text-xs text-gray-500 mt-1">Terdapat {{ $todayOrdersCount }} pesanan baru hari ini.</p>
                                        </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="flex-1 p-6 lg:p-8">
                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-danger-50 border border-danger-100 text-danger-700 text-sm animate-fade-in">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
    <script>
        // Global Table Search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-global');
            if(searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    const term = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('table.table-modern tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(term) ? '' : 'none';
                    });
                    
                    const cards = document.querySelectorAll('.card-hover');
                    cards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        card.style.display = text.includes(term) ? '' : 'none';
                    });
                });
            }

            // Close notification dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const container = document.getElementById('notification-dropdown-container');
                const menu = document.getElementById('notification-menu');
                if (container && menu && !container.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
