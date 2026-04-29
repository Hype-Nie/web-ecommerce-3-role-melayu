@extends('layouts.app')
@section('title', 'Laman Utama')
@section('meta_description', 'KedaiKu — Platform e-dagang terbaik di Malaysia. Beli-belah dalam talian dengan mudah dan selamat.')

@section('content')
{{-- HERO --}}
<section class="relative gradient-hero text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-400 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-primary-300 rounded-full blur-3xl animate-float delay-300"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-primary-200 text-sm font-medium mb-6 backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Platform E-Dagang #1 Malaysia
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Beli-Belah <br><span class="text-primary-300">Tanpa Sempadan</span>
                </h1>
                <p class="text-lg text-primary-100/80 mb-8 max-w-lg">Temui ribuan produk berkualiti dari penjual terpercaya di seluruh Malaysia. Penghantaran pantas, pembayaran selamat.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#produk-popular" class="btn-primary !bg-white !text-primary-700 hover:!bg-primary-50">Mula Membeli</a>
                    <a href="{{ route('register') }}" class="btn-primary !border-white/20 !text-white hover:!">Daftar Sekarang</a>
                </div>
                <div class="flex items-center gap-8 mt-10 text-sm">
                    <div><span class="text-2xl font-bold text-white">10K+</span><p class="text-primary-200/70">Produk</p></div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div><span class="text-2xl font-bold text-white">5K+</span><p class="text-primary-200/70">Pelanggan</p></div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div><span class="text-2xl font-bold text-white">500+</span><p class="text-primary-200/70">Penjual</p></div>
                </div>
            </div>
            <div class="hidden lg:flex justify-center animate-fade-in delay-300">
                <div class="relative">
                    <div class="w-80 h-80 rounded-3xl gradient-primary opacity-20 blur-2xl absolute top-8 left-8"></div>
                    <div class="relative w-80 h-80 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/10 flex items-center justify-center">
                        <svg class="w-32 h-32 text-primary-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-gray-50 to-transparent"></div>
</section>

{{-- KATEGORI --}}
<section class="py-16 lg:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 reveal">
        <h2 class="text-3xl font-bold text-gray-900 mb-3">Kategori Pilihan</h2>
        <p class="text-gray-500 max-w-md mx-auto">Terokai pelbagai kategori produk kegemaran anda</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-6">
        @php
        $catColors = ['from-blue-500 to-blue-600','from-pink-500 to-rose-500','from-amber-500 to-orange-500','from-primary-500 to-primary-600','from-red-500 to-red-600','from-violet-500 to-purple-600','from-teal-500 to-teal-600'];
        $catIcons = ['M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z','M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z','M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4','M13 10V3L4 14h7v7l9-11h-7z','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z','M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'];
        @endphp
        @foreach($categories as $i => $cat)
        <a href="{{ route('produk.index', ['category' => $cat->id]) }}" class="group reveal">
            <div class="bg-white rounded-2xl p-6 text-center card-hover border border-gray-100">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gradient-to-br {{ $catColors[$i % count($catColors)] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $catIcons[$i % count($catIcons)] }}"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800 text-sm">{{ $cat->name }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $cat->products_count }} produk</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- PRODUK POPULAR --}}
<section id="produk-popular" class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12 reveal">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Produk Popular</h2>
                <p class="text-gray-500">Produk terlaris pilihan pelanggan kami</p>
            </div>
            <a href="{{ route('produk.index') }}" class="hidden sm:inline-flex items-center gap-1 text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @php $bgColors = ['from-blue-100 to-blue-50','from-amber-100 to-amber-50','from-purple-100 to-purple-50','from-primary-100 to-primary-50','from-rose-100 to-rose-50','from-green-100 to-green-50','from-yellow-100 to-yellow-50','from-sky-100 to-sky-50']; @endphp
            @foreach($products as $i => $p)
            <a href="{{ route('produk.show', $p->slug) }}" class="group reveal">
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
                    <div class="relative h-48 bg-gradient-to-br {{ $bgColors[$i % count($bgColors)] }} flex items-center justify-center overflow-hidden">
                        @if($p->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $p->images->first()->image_path) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <svg class="w-16 h-16 text-gray-300 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @endif
                        @if($p->discountPercent())
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-primary-600 text-white text-xs font-semibold">-{{ $p->discountPercent() }}%</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-sm mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">{{ $p->name }}</h3>
                        <p class="text-xs text-gray-400 mb-2">{{ $p->seller->shop_name ?? $p->seller->name }}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-bold text-primary-600">RM {{ number_format($p->price, 2) }}</span>
                            @if($p->old_price)<span class="text-sm text-gray-400 line-through">RM {{ number_format($p->old_price, 2) }}</span>@endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- PROMO BANNER --}}
<section class="py-16 lg:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-6 reveal">
        <div class="relative rounded-3xl overflow-hidden gradient-primary p-8 lg:p-10 text-white">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-12 translate-x-12"></div>
            <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-sm font-medium mb-4">Tawaran Istimewa</span>
            <h3 class="text-2xl lg:text-3xl font-bold mb-3">Diskaun 50% Produk Elektronik</h3>
            <p class="text-primary-100/80 mb-6">Sah sehingga akhir bulan ini sahaja!</p>
            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition-all duration-300">Beli Sekarang</a>
        </div>
        <div class="relative rounded-3xl overflow-hidden bg-gray-900 p-8 lg:p-10 text-white">
            <div class="absolute top-0 right-0 w-48 h-48 bg-primary-600/10 rounded-full -translate-y-12 translate-x-12"></div>
            <span class="inline-block px-3 py-1 rounded-full bg-primary-600/30 text-primary-300 text-sm font-medium mb-4">Penghantaran Percuma</span>
            <h3 class="text-2xl lg:text-3xl font-bold mb-3">Beli Lebih RM150</h3>
            <p class="text-gray-400 mb-6">Nikmati penghantaran percuma ke seluruh Malaysia.</p>
            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-all duration-300">Ketahui Lagi</a>
        </div>
    </div>
</section>

{{-- TESTIMONI --}}
<section class="py-16 lg:py-20 bg-primary-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Apa Kata Pelanggan Kami</h2>
            <p class="text-gray-500 max-w-md mx-auto">Ribuan pelanggan berpuas hati dengan perkhidmatan kami</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php
            $testimonials = [
                ['name'=>'Ahmad bin Hassan','text'=>'Pengalaman membeli-belah yang sangat memuaskan! Penghantaran pantas dan produk berkualiti.','role'=>'Pelanggan Setia'],
                ['name'=>'Fatimah binti Ali','text'=>'Harga berpatutan dan pilihan produk yang sangat banyak. Saya sangat suka platform ini!','role'=>'Pelanggan Baru'],
                ['name'=>'Mohd Rizal','text'=>'Sebagai penjual, KedaiKu membantu saya meluaskan perniagaan. Sistem yang mudah dan efisien.','role'=>'Penjual Berjaya'],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 card-hover reveal">
                <div class="flex gap-1 mb-4">
                    @for($i=0;$i<5;$i++)<svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">"{{ $t['text'] }}"</p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">{{ substr($t['name'],0,1) }}</div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $t['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $t['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 lg:py-28">
    <div class="max-w-4xl mx-auto px-4 text-center reveal">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Sedia Untuk Mula Membeli?</h2>
        <p class="text-gray-500 mb-8 max-w-lg mx-auto">Daftar sekarang dan nikmati pengalaman membeli-belah dalam talian yang terbaik.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="btn-primary text-lg !px-8 !py-4">Daftar Percuma</a>
            <a href="{{ route('login') }}" class="btn-secondary text-lg !px-8 !py-4">Log Masuk</a>
        </div>
    </div>
</section>
@endsection
