{{-- ══════════ VERTICAL NAV RAIL ══════════ --}}
<nav class="fixed top-0 left-0 h-screen w-[72px] bg-white border-r border-gray-200 z-50 flex flex-col items-center py-6 hidden lg:flex">
    <div class="flex flex-col gap-6 w-full items-center my-auto">
        {{-- Logo / Home --}}
        <a href="{{ route('landing') }}" class="w-12 h-12 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors group">
            <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
        </a>

        {{-- Nav Items --}}
        <a href="{{ route('produk.index', ['focus' => 'search']) }}" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 hover:scale-105 active:scale-95 transition-all duration-300 text-gray-500 hover:text-black group relative tooltip-container" id="nav-search-btn">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span class="tooltip-text">Cari Produk</span>
        </a>
        
        {{-- Account / Auth --}}
        @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors text-gray-500 hover:text-black group relative tooltip-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span class="tooltip-text">Papan Pemuka</span>
            </a>
            @elseif(auth()->user()->isSeller())
            <a href="{{ route('seller.dashboard') }}" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors text-gray-500 hover:text-black group relative tooltip-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span class="tooltip-text">Kedai Saya</span>
            </a>
            @else
            <a href="{{ route('customer.dashboard') }}" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors text-gray-500 hover:text-black group relative tooltip-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="tooltip-text">Akaun Saya</span>
            </a>
            <a href="{{ route('customer.orders') }}" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors text-gray-500 hover:text-black group relative tooltip-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="tooltip-text">Pesanan Saya</span>
            </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors text-gray-500 hover:text-black group relative tooltip-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                <span class="tooltip-text">Log Masuk</span>
            </a>
        @endauth

        {{-- Bottom Actions --}}
        @auth
        <div class="w-6 h-px bg-gray-200 my-1"></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-11 h-11 flex items-center justify-center rounded-[28px] hover:bg-gray-50 transition-colors text-gray-500 hover:text-black group relative tooltip-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="tooltip-text">Log Keluar</span>
            </button>
        </form>
        @endauth
    </div>
</nav>

{{-- MOBILE TOPBAR --}}
<nav class="lg:hidden sticky top-0 z-50 bg-white border-b border-gray-200">
    <div class="px-4 h-16 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="text-xl font-bold tracking-tight text-black flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
            Campus<span class="text-primary-600">Buy</span>
        </a>
        <div class="flex items-center gap-3">
            <button id="mobile-menu-toggle" class="p-2 text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    
    <div id="mobile-menu" class="hidden border-t border-gray-200 bg-white flex flex-col p-4 gap-2">
        <form action="{{ route('produk.index') }}" method="GET" class="relative mb-2">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-full pl-11 pr-4 py-3 rounded-[28px] border border-gray-200 bg-white text-sm outline-none focus:border-black">
        </form>
        <a href="{{ route('landing') }}" class="px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50">Laman Utama</a>
        <a href="{{ route('produk.index') }}" class="px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50">Semua Produk</a>
        @guest
        <a href="{{ route('login') }}" class="px-4 py-3 text-sm font-medium text-white bg-primary-600 rounded-[28px] text-center mt-2">Log Masuk</a>
        @else
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50">Papan Pemuka</a>
            @elseif(auth()->user()->isSeller())
            <a href="{{ route('seller.dashboard') }}" class="px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50">Kedai Saya</a>
            @else
            <a href="{{ route('customer.dashboard') }}" class="px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50">Akaun Saya</a>
            <a href="{{ route('customer.orders') }}" class="px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50">Pesanan Saya</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full px-4 py-3 text-sm text-black rounded-lg hover:bg-gray-50 text-left">Log Keluar</button>
            </form>
        @endguest
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Find the main search input on the products page
        const searchInput = document.getElementById('main-search-input');
        
        // Handle auto-focus from URL
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.get('focus') === 'search' && searchInput) {
            // Clean up the URL
            urlParams.delete('focus');
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState({}, '', newUrl);
            
            // Focus and scroll
            setTimeout(() => {
                searchInput.focus();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        }

        // Handle click on sidebar icon if already on the page
        const searchBtn = document.getElementById('nav-search-btn');
        if(searchBtn) {
            searchBtn.addEventListener('click', (e) => {
                if(window.location.pathname.includes('/produk') && searchInput) {
                    e.preventDefault();
                    searchInput.focus();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        }
    });
</script>
