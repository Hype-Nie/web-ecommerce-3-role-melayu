{{-- ══════════ PUBLIC NAVBAR ══════════ --}}
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Logo --}}
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="w-9 h-9 rounded-xl gradient-primary flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-xl font-bold text-gray-900">Kedai<span class="text-primary-600">Ku</span></span>
            </a>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-xl mx-8">
                <form action="{{ route('produk.index') }}" method="GET" class="relative w-full">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk, kategori, atau jenama..." class="w-full pl-12 pr-4 py-2.5 rounded-full bg-gray-100 border border-transparent text-sm transition-all duration-300 outline-none focus:bg-white focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 search-global">
                </form>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2">
                {{-- Cart --}}
                <a href="{{ route('cart') }}" class="relative p-2.5 rounded-xl hover:bg-gray-100 transition-colors" id="nav-cart-btn">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    @auth
                        @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                        <span id="nav-cart-badge" class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-primary-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center {{ $cartCount > 0 ? 'animate-bounce-in' : 'hidden' }}">{{ $cartCount }}</span>
                    @endauth
                </a>

                {{-- User Actions (Desktop) --}}
                @auth
                <div class="hidden sm:block relative group">
                    <button class="flex items-center gap-2 btn-secondary text-sm !px-4 !py-2.5 border-none bg-gray-50 hover:bg-gray-100">
                        <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xs">{{ substr(auth()->user()->name,0,1) }}</div>
                        <span class="font-medium text-gray-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100">
                        <div class="p-2 space-y-1">
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg">Papan Pemuka</a>
                            @elseif(auth()->user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg">Papan Pemuka</a>
                            @else
                            <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg">Akaun Saya</a>
                            <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg">Pesanan Saya</a>
                            @endif
                            <hr class="my-1 border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 rounded-lg">Log Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-2 btn-primary text-sm !px-5 !py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Log Masuk
                </a>
                @endauth

                {{-- Mobile Menu Toggle --}}
                <button id="mobile-menu-toggle" class="md:hidden p-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden flex-col md:hidden bg-white border-t border-gray-100 animate-fade-in-down">
        <div class="p-4">
            <form action="{{ route('produk.index') }}" method="GET" class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-100 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-primary-500/20">
            </form>
        </div>
        <div class="px-4 pb-4 space-y-1">
            <a href="{{ route('landing') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Laman Utama</a>
            <a href="{{ route('produk.index') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Semua Produk</a>
            <a href="{{ route('cart') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-700 font-medium transition-colors">Troli</a>
            @guest
            <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl bg-primary-600 text-white font-semibold text-center mt-2">Log Masuk</a>
            @endguest
        </div>
    </div>
</nav>
<div id="mobile-menu-overlay" class="hidden fixed inset-0 bg-black/30 z-40 md:hidden"></div>
