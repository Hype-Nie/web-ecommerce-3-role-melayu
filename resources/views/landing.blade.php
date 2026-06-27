@extends('layouts.app')
@section('title', 'Laman Utama')

@section('content')

{{-- TOP PROMO BAR --}}
<a href="{{ route('produk.index') }}" class="w-full bg-[#121212] py-2.5 px-4 flex justify-center items-center gap-3 hover:bg-black transition-colors group">
    <div class="w-5 h-5 bg-primary-600 rounded-[4px] flex items-center justify-center text-white">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
    </div>
    <span class="text-white text-[12px] font-medium tracking-tight">Cara pantas beli & terus WhatsApp. Lihat Semua Produk</span>
    <svg class="w-3 h-3 text-white transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
</a>

{{-- HERO --}}
<section class="relative min-h-[450px] md:min-h-[550px] lg:min-h-[600px] pt-24 pb-16 flex flex-col items-center justify-center text-center px-4 overflow-hidden">
    {{-- Decorative background gradients --}}
    <div class="absolute inset-0 z-0 opacity-40 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-primary-100 blur-3xl mix-blend-multiply"></div>
        <div class="absolute top-[20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-blue-100 blur-3xl mix-blend-multiply"></div>
    </div>

    {{-- Decorative floating images (Massive & Clear) --}}
    <div class="absolute inset-0 pointer-events-none hidden md:block">
        @foreach($products->take(4) as $index => $p)
            @if($p->images->isNotEmpty())
            <div class="absolute {{ ['top-[8%] left-[4%]', 'top-[12%] right-[4%]', 'bottom-[8%] left-[12%]', 'bottom-[12%] right-[12%]' ][$index] }} transform {{ ['-rotate-12', 'rotate-6', 'rotate-12', '-rotate-6'][$index] }} z-0">
                <img src="{{ asset('storage/' . $p->images->first()->image_path) }}" class="w-[160px] h-[160px] lg:w-[240px] lg:h-[240px] object-cover rounded-[24px] shadow-2xl drop-shadow-2xl hover:scale-105 transition-transform duration-500">
            </div>
            @endif
        @endforeach
    </div>

    <div class="relative z-10 flex flex-col items-center w-full max-w-[600px]">
        <h1 class="text-[56px] md:text-[72px] font-bold tracking-tighter text-primary-600 mb-8 leading-none">
            campus<span class="text-primary-600">buy</span>
        </h1>
        
        {{-- HERO SEARCH --}}
        {{-- HERO SEARCH --}}
        <form id="hero-search" action="{{ route('produk.index') }}" method="GET" class="relative w-full shadow-[0_8px_30px_rgba(0,0,0,0.06)] rounded-[28px] hover:scale-[1.02] transition-transform duration-300">
            <input type="text" name="search" placeholder="Apa yang anda cari hari ini?" class="w-full h-[56px] pl-[24px] pr-[56px] rounded-[28px] border border-gray-100 bg-white text-[14px] text-black placeholder-gray-400 outline-none focus:border-primary-600 transition-colors">
            <button type="submit" class="absolute right-[6px] top-[6px] w-[44px] h-[44px] bg-primary-600 rounded-full flex items-center justify-center text-white shadow-[0_4px_20px_rgba(225,29,72,0.4)] hover:bg-primary-700 active:scale-95 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>
    </div>
</section>

{{-- FEATURES TICKER --}}
<div class="flex items-center justify-center gap-8 md:gap-16 flex-wrap opacity-50 pb-16 pt-4 border-b border-gray-100 max-w-[1000px] mx-auto w-full">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        <span class="font-bold text-[14px]">Terus WhatsApp</span>
    </div>
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        <span class="font-bold text-[14px]">Eksklusif Kampus</span>
    </div>
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <span class="font-bold text-[14px]">Selamat & Pantas</span>
    </div>
</div>

{{-- CATEGORY PILLS --}}
<section class="max-w-[1000px] mx-auto px-4 pb-16">
    <div class="flex flex-wrap justify-center gap-[12px]">
        @php
        $catColors = ['bg-blue-600', 'bg-rose-600', 'bg-amber-500', 'bg-green-600', 'bg-purple-600', 'bg-teal-600'];
        @endphp
        @foreach($categories as $i => $cat)
        <a href="{{ route('produk.index', ['category' => $cat->id]) }}" class="flex items-center gap-[8px] pl-[6px] pr-[16px] py-[6px] bg-white border border-gray-200 rounded-[28px] hover:shadow-md hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
            @if($cat->image)
            <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="w-[28px] h-[28px] object-cover rounded-full bg-gray-100">
            @else
            <div class="w-[28px] h-[28px] rounded-full {{ $catColors[$i % count($catColors)] }} flex items-center justify-center text-white">
                <span class="text-[10px] font-bold">{{ substr($cat->name, 0, 1) }}</span>
            </div>
            @endif
            <span class="text-[13px] font-medium tracking-tight text-black">{{ $cat->name }}</span>
        </a>
        @endforeach
    </div>
</section>

{{-- CATEGORY BOXES (Single Horizontal Scroll, No Wrapper Card) --}}
<section class="w-full pl-4 sm:pl-6 lg:pl-12 pb-16 overflow-hidden">
    <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-4 pr-4 lg:pr-12" style="scrollbar-width: none;">
        @foreach($categories as $cat)
            @php
                $catProducts = \App\Models\Product::where('category_id', $cat->id)->where('product_status', 'available')->latest()->take(4)->get();
            @endphp
            @if($catProducts->count() > 0)
            <div class="w-[280px] md:w-[320px] flex-shrink-0 snap-start flex flex-col group">
                
                {{-- Category Title ONLY --}}
                <a href="{{ route('produk.index', ['category' => $cat->id]) }}" class="flex items-center gap-2 mb-3 px-1 w-fit">
                    <h3 class="text-[20px] md:text-[24px] font-bold text-black tracking-tight group-hover:text-primary-600 transition-colors">{{ $cat->name }}</h3>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                
                {{-- 2x2 Grid Container with Fixed Dimensions and Rounded Outer Corners --}}
                <div class="grid grid-cols-2 grid-rows-2 gap-[2px] w-[280px] h-[280px] md:w-[320px] md:h-[320px] rounded-[32px] overflow-hidden bg-white shadow-sm border border-gray-100">
                    @foreach($catProducts as $p)
                        <a href="{{ route('produk.show', $p->slug) }}" class="w-full h-full relative overflow-hidden bg-[#f4f4f4] group/item hover:opacity-95 transition-opacity">
                            @if($p->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $p->images->first()->image_path) }}" class="absolute inset-0 w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-500">
                            @else
                            {{-- Shopping Bag Icon Placeholder --}}
                            <div class="absolute inset-0 flex items-center justify-center bg-[#f4f4f4]">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            @endif
                            
                            {{-- Product Name Overlay --}}
                            <div class="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-black/80 via-black/40 to-transparent pointer-events-none">
                                <p class="text-white text-[13px] font-medium leading-tight drop-shadow-md line-clamp-1">{{ $p->name }}</p>
                            </div>
                        </a>
                    @endforeach
                    
                    {{-- Empty slots (Shopping Bag Icon Placeholder) --}}
                    @for($i = $catProducts->count(); $i < 4; $i++)
                        <a href="{{ route('produk.index', ['category' => $cat->id]) }}" class="w-full h-full bg-[#f9f9f9] flex flex-col items-center justify-center group/empty hover:bg-[#f0f0f0] transition-colors">
                            <svg class="w-6 h-6 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span class="text-[10px] text-gray-400 font-medium">Lagi...</span>
                        </a>
                    @endfor
                </div>
            </div>
            @endif
        @endforeach
    </div>
</section>

{{-- CURATED COLLECTIONS --}}
<section class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="mb-8">
        <h2 class="text-[20px] font-bold tracking-tight text-black">Koleksi Terpilih</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('produk.index') }}" class="relative h-[240px] md:h-[280px] rounded-[32px] overflow-hidden group bg-gray-100 block">
            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/10"></div>
            <div class="absolute inset-0 p-8 flex flex-col justify-center">
                <span class="px-3 py-1 bg-primary-600 text-white text-[10px] font-bold tracking-wider rounded-full w-fit mb-4">BARU</span>
                <h3 class="text-white text-[24px] md:text-[28px] font-bold leading-tight mb-2">Gajet & Aksesori<br>Pelajar IT</h3>
                <p class="text-gray-300 text-[14px] max-w-[220px] mb-6">Tingkatkan produktiviti dengan gajet terpakai berkualiti.</p>
                <div class="flex items-center gap-2 text-white font-medium text-[13px] group-hover:gap-3 transition-all">
                    Lihat Koleksi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
            </div>
        </a>
        <a href="{{ route('produk.index') }}" class="relative h-[240px] md:h-[280px] rounded-[32px] overflow-hidden group bg-gray-100 block">
            <img src="https://images.unsplash.com/photo-1434389678232-02621d154ee4?auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/10"></div>
            <div class="absolute inset-0 p-8 flex flex-col justify-center">
                <span class="px-3 py-1 bg-white text-black text-[10px] font-bold tracking-wider rounded-full w-fit mb-4">TRENDING</span>
                <h3 class="text-white text-[24px] md:text-[28px] font-bold leading-tight mb-2">Fesyen & Gaya<br>Khas Ke Kelas</h3>
                <p class="text-gray-300 text-[14px] max-w-[220px] mb-6">Pakaian *preloved* berjenama pada harga pelajar.</p>
                <div class="flex items-center gap-2 text-white font-medium text-[13px] group-hover:gap-3 transition-all">
                    Lihat Koleksi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
            </div>
        </a>
    </div>
</section>

{{-- WHY CHOOSE US --}}
<section class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="text-center mb-10">
        <h2 class="text-[28px] md:text-[32px] font-bold tracking-tight text-black mb-4">Kenapa Beli di CampusBuy?</h2>
        <p class="text-gray-500 text-[15px] max-w-lg mx-auto">Kami menyelesaikan masalah jual beli di antara rakan kampus. Tidak perlu lagi pos barang, COD terus di kolej kediaman!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-100 rounded-[32px] p-8 text-center hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition-shadow">
            <div class="w-16 h-16 mx-auto bg-primary-50 rounded-[20px] flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="text-[18px] font-bold text-black mb-3">Dekat & Pantas</h3>
            <p class="text-gray-500 text-[14px]">Berurusan terus dengan rakan sekampus. COD hari ini juga tanpa perlu tunggu kurier.</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-[32px] p-8 text-center hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition-shadow">
            <div class="w-16 h-16 mx-auto bg-primary-50 rounded-[20px] flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="text-[18px] font-bold text-black mb-3">Lebih Selamat</h3>
            <p class="text-gray-500 text-[14px]">Platform eksklusif komuniti kampus. Profil penjual lebih telus untuk kepercayaan bersama.</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-[32px] p-8 text-center hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition-shadow">
            <div class="w-16 h-16 mx-auto bg-primary-50 rounded-[20px] flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-[18px] font-bold text-black mb-3">Harga Pelajar</h3>
            <p class="text-gray-500 text-[14px]">Temui barangan *preloved* dan buku teks terpakai dengan harga yang sangat berpatutan.</p>
        </div>
    </div>
</section>

@guest
{{-- CTA AJAKAN LOGIN (To fill empty space) --}}
<section class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-16">
    <div class="w-full bg-primary-600 rounded-[32px] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between text-white relative overflow-hidden shadow-[0_20px_40px_rgba(225,29,72,0.2)]">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-black/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-lg mb-8 md:mb-0">
            <h2 class="text-[32px] md:text-[40px] font-bold tracking-tight leading-tight mb-4">Sertai Komuniti CampusBuy</h2>
            <p class="text-[16px] text-white/90 font-medium mb-8">Beli barangan, jual preloved anda, dan berhubung dengan rakan kampus lain dengan lebih mudah dan selamat.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-primary-600 font-bold rounded-[24px] hover:scale-105 active:scale-95 transition-transform shadow-lg">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="px-6 py-3 bg-black/20 text-white font-bold rounded-[24px] hover:bg-black/30 transition-colors">Log Masuk</a>
            </div>
        </div>
        
        <div class="relative z-10 hidden md:block">
            <svg class="w-48 h-48 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
        </div>
    </div>
</section>
@endguest

{{-- SEMUA PRODUK (Untuk mengisi paparan) --}}
<section class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 pb-32">
    <div class="mb-8">
        <h2 class="text-[20px] font-bold tracking-tight text-black">Lebih Banyak Produk</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($products as $p)
        <a href="{{ route('produk.show', $p->slug) }}" class="group block bg-white border border-gray-200 rounded-[16px] hover:border-gray-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
            <div class="w-full aspect-square bg-gray-100 flex items-center justify-center relative">
                @if($p->images->isNotEmpty())
                <img src="{{ asset('storage/' . $p->images->first()->image_path) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                @else
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                @endif
                @if($p->discountPercent())
                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-[28px] bg-white border border-gray-200 text-black text-[10px] font-bold shadow-sm">-{{ $p->discountPercent() }}%</span>
                @endif
            </div>
            <div class="p-4">
                <h3 class="text-[13px] font-medium text-black line-clamp-1 mb-1">{{ $p->name }}</h3>
                <div class="flex items-baseline gap-1">
                    <span class="text-[14px] font-bold text-black">RM{{ number_format($p->price, 0) }}</span>
                    @if($p->old_price)<span class="text-[11px] text-gray-400 line-through">RM{{ number_format($p->old_price, 0) }}</span>@endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- STICKY BOTTOM SEARCH --}}
<div id="sticky-search" class="fixed bottom-6 left-0 w-full z-40 flex justify-center px-4 transition-all duration-500 translate-y-32 opacity-0 pointer-events-none">
    <form action="{{ route('produk.index') }}" method="GET" class="relative w-full max-w-[500px] shadow-[0_12px_40px_rgba(0,0,0,0.12)] rounded-[32px] hover:scale-[1.02] transition-transform duration-300 pointer-events-auto bg-white/90 backdrop-blur-md border border-gray-200">
        <input type="text" name="search" placeholder="Apa yang anda cari hari ini?" class="w-full h-[56px] pl-[24px] pr-[56px] rounded-[32px] bg-transparent text-[14px] font-medium text-black placeholder-gray-500 outline-none focus:border-primary-600 transition-colors">
        <button type="submit" class="absolute right-[6px] top-[6px] w-[44px] h-[44px] bg-primary-600 rounded-full flex items-center justify-center text-white shadow-md hover:bg-primary-700 active:scale-95 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroSearch = document.getElementById('hero-search');
    const stickySearch = document.getElementById('sticky-search');
    
    if (heroSearch && stickySearch) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    // Show sticky search
                    stickySearch.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
                    stickySearch.classList.add('translate-y-0', 'opacity-100');
                } else {
                    // Hide sticky search
                    stickySearch.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
                    stickySearch.classList.remove('translate-y-0', 'opacity-100');
                }
            });
        }, { threshold: 0, rootMargin: "-100px 0px 0px 0px" });
        
        observer.observe(heroSearch);
    }
});
</script>
@endsection
