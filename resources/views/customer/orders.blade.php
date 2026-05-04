@extends('layouts.customer')
@section('title', 'Pesanan Saya')
@section('page_title', 'Pesanan Saya')
@section('page_subtitle', 'Sejarah semua pesanan anda')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="space-y-4">
    @forelse($orders as $o)
    <a href="{{ route('customer.order-detail', $o) }}" class="block bg-white rounded-2xl border border-gray-100 p-6 card-hover animate-fade-in-up">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <span class="font-bold text-gray-900">#{{ $o->order_number }}</span>
                <span class="badge {{ $o->statusBadge() }}">{{ $o->statusLabel() }}</span>
            </div>
            <span class="text-sm text-gray-500">{{ $o->created_at->format('d M Y') }}</span>
        </div>
        @foreach($o->items->take(2) as $item)
        <div class="flex items-center gap-4 {{ !$loop->first ? 'mt-3' : '' }}">
            <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800">{{ $item->product_name }}</p>
                <p class="text-sm text-gray-500">x{{ $item->quantity }} · RM {{ number_format($item->product_price, 2) }}</p>
            </div>
        </div>
        @endforeach
        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm text-gray-500">{{ $o->items->count() }} item</span>
            <span class="font-bold text-gray-900">RM {{ number_format($o->total, 2) }}</span>
        </div>
    </a>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">Tiada pesanan</div>
    @endforelse
</div>
@endsection
