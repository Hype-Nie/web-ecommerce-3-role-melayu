@extends('layouts.app')
@section('title', 'Troli Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-gray-900 mb-8 animate-fade-in">Troli Saya</h1>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
    @endif

    @if($cartItems->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center animate-fade-in">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
        <p class="text-gray-500 mb-4">Troli anda kosong</p>
        <a href="{{ route('landing') }}" class="btn-primary text-sm !px-6 !py-2.5">Mula Membeli-belah</a>
    </div>
    @else
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4 animate-fade-in">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-20 h-20 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 truncate">{{ $item->product->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $item->product->seller->shop_name ?? $item->product->seller->name }}</p>
                    <p class="text-primary-600 font-bold mt-1">RM {{ number_format($item->product->price, 2) }}</p>
                </div>
                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border border-gray-200 rounded-xl overflow-hidden">@csrf @method('PUT')
                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="px-3 py-2 text-gray-500 hover:bg-gray-50">−</button>
                    <span class="w-10 text-center text-sm font-semibold">{{ $item->quantity }}</span>
                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-3 py-2 text-gray-500 hover:bg-gray-50">+</button>
                </form>
                <form action="{{ route('cart.remove', $item) }}" method="POST">@csrf @method('DELETE')
                    <button class="p-2 rounded-lg hover:bg-danger-50 text-gray-400 hover:text-danger-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </form>
            </div>
            @endforeach
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 h-fit animate-fade-in-right">
            <h3 class="font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
            <div class="space-y-3 text-sm mb-6">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal ({{ $cartItems->count() }} item)</span><span class="font-medium">RM {{ number_format($subtotal, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Penghantaran</span><span class="text-primary-600 font-medium">Dikira semasa checkout</span></div>
                <div class="border-t border-gray-100 pt-3 flex justify-between"><span class="font-semibold text-gray-900">Subtotal</span><span class="text-xl font-bold text-primary-600">RM {{ number_format($subtotal, 2) }}</span></div>
            </div>
            <a href="{{ route('checkout') }}" class="btn-primary w-full text-center block">Checkout</a>
        </div>
    </div>
    @endif
</div>
@endsection
