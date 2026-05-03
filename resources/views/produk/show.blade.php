@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">
        {{-- Image --}}
        <div class="animate-fade-in">
            <div class="aspect-square rounded-3xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center overflow-hidden">
                @if($product->images->isNotEmpty())
                <img id="main-product-img" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="flex gap-3 mt-4">
                @foreach($product->images as $img)
                <button onclick="document.getElementById('main-product-img').src='{{ asset('storage/' . $img->image_path) }}'" class="w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-primary-400 transition-colors">
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>
        {{-- Details --}}
        <div class="animate-fade-in-right">
            <span class="badge badge-info mb-4">{{ $product->category->name }}</span>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
            <div class="flex items-baseline gap-3 mb-6">
                <span class="text-3xl font-bold text-primary-600">RM {{ number_format($product->price, 2) }}</span>
                @if($product->old_price)<span class="text-lg text-gray-400 line-through">RM {{ number_format($product->old_price, 2) }}</span><span class="badge badge-success">-{{ $product->discountPercent() }}%</span>@endif
            </div>
            <p class="text-gray-600 leading-relaxed mb-6">{{ $product->description }}</p>
            <div class="flex items-center gap-2 mb-6 text-sm"><span class="font-semibold text-primary-600">Sedia Ditempah</span></div>

            {{-- Direct Checkout --}}
            @auth
            <form action="{{ route('checkout') }}" method="GET" class="flex gap-3 mb-6">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                    <button type="button" class="px-3 py-3 text-gray-500 hover:bg-gray-50" onclick="this.parentElement.querySelector('input').stepDown()">−</button>
                    <input type="number" name="quantity" value="1" min="1" class="w-14 text-center border-0 focus:ring-0 text-sm font-semibold">
                    <button type="button" class="px-3 py-3 text-gray-500 hover:bg-gray-50" onclick="this.parentElement.querySelector('input').stepUp()">+</button>
                </div>
                <button type="submit" class="btn-primary flex-1 text-center flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Beli Sekarang</span>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-primary text-center block mb-6">Log Masuk untuk Membeli</a>
            @endauth

            {{-- Seller --}}
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold">{{ substr($product->seller->name,0,1) }}</div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800 text-sm">{{ $product->seller->shop_name ?? $product->seller->name }}</p>
                    <p class="text-xs text-gray-500">{{ $product->seller->products()->count() }} produk</p>
                </div>
            </div>
        </div>
    </div>

    @if($related->isNotEmpty())
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Berkaitan</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($related as $r)
            <a href="{{ route('produk.show', $r->slug) }}" class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
                <div class="h-40 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
                    @if($r->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $r->images->first()->image_path) }}" alt="{{ $r->name }}" class="w-full h-full object-cover">
                    @else
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @endif
                </div>
                <div class="p-4"><h3 class="font-semibold text-sm text-gray-800 mb-1 line-clamp-2">{{ $r->name }}</h3><span class="text-primary-600 font-bold">RM {{ number_format($r->price, 2) }}</span></div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

