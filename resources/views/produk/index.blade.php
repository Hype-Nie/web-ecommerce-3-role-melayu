@extends('layouts.app')
@section('title', 'Semua Produk')
@section('meta_description', 'Lihat semua produk di CampusBy. Cari dan tapis mengikut kategori.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Page Header --}}
    <div class="mb-8 animate-fade-in">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Semua Produk</h1>
        <p class="text-gray-500">
            @if(request('search'))
                Hasil carian untuk "<span class="font-semibold text-gray-700">{{ request('search') }}</span>"
            @elseif(request('category'))
                @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
                Kategori: <span class="font-semibold text-gray-700">{{ $activeCat->name ?? '-' }}</span>
            @else
                Terokai pelbagai produk berkualiti dari penjual di seluruh Malaysia
            @endif
        </p>
    </div>

    {{-- Filters Bar --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-8 animate-fade-in">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            {{-- Category Chips --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('produk.index', request()->except('category', 'page')) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('produk.index', array_merge(request()->except('page'), ['category' => $cat->id])) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('category') == $cat->id ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $cat->name }} <span class="text-xs opacity-70">({{ $cat->products_count }})</span>
                </a>
                @endforeach
            </div>

            {{-- Sort Dropdown --}}
            <div class="flex items-center gap-3">
                <form action="{{ route('produk.index') }}" method="GET" id="sort-form">
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    <select name="sort" onchange="document.getElementById('sort-form').submit()" class="input-styled !py-2 !text-sm !rounded-xl">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                    </select>
                </form>
                <span class="text-sm text-gray-500 whitespace-nowrap">{{ $products->total() }} produk</span>
            </div>
        </div>
    </div>

    {{-- Active Search --}}
    @if(request('search'))
    <div class="mb-6 flex items-center gap-2 animate-fade-in">
        <span class="text-sm text-gray-500">Carian:</span>
        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-primary-50 text-primary-700 text-sm font-medium">
            "{{ request('search') }}"
            <a href="{{ route('produk.index', request()->except('search', 'page')) }}" class="ml-1 hover:text-primary-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </span>
    </div>
    @endif

    {{-- Products Grid --}}
    @if($products->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center animate-fade-in">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="text-gray-500 mb-4">Tiada produk ditemui</p>
        <a href="{{ route('produk.index') }}" class="btn-primary text-sm !px-6 !py-2.5">Lihat Semua Produk</a>
    </div>
    @else
    @php $bgColors = ['from-blue-100 to-blue-50','from-amber-100 to-amber-50','from-purple-100 to-purple-50','from-primary-100 to-primary-50','from-rose-100 to-rose-50','from-green-100 to-green-50','from-yellow-100 to-yellow-50','from-sky-100 to-sky-50']; @endphp
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
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

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
