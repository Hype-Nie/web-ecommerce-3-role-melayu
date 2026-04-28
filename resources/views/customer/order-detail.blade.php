@extends('layouts.customer')
@section('title', 'Butiran Pesanan #' . $order->order_number)
@section('page_title', 'Butiran Pesanan')
@section('page_subtitle', '#' . $order->order_number)

@section('content')
@php
$statusSteps = ['pending'=>0,'processing'=>1,'shipped'=>2,'completed'=>3];
$currentStep = $statusSteps[$order->status] ?? -1;
$steps = ['Pesanan Dibuat','Diproses','Dihantar','Selesai'];
@endphp
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6 animate-fade-in">
    <h3 class="font-bold text-gray-900 mb-6">Status Pesanan</h3>
    @if($order->status === 'cancelled')
    <div class="p-4 rounded-xl bg-danger-50 border border-danger-100 text-danger-700 text-sm font-semibold">Pesanan ini telah dibatalkan.</div>
    @else
    <div class="flex items-center justify-between mb-2">
        @foreach($steps as $i => $step)
        <div class="flex-1 flex flex-col items-center text-center">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 {{ $i <= $currentStep ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-400' }}">
                @if($i <= $currentStep)<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>@else {{ $i+1 }} @endif
            </div>
            <span class="text-xs {{ $i <= $currentStep ? 'text-primary-600 font-semibold' : 'text-gray-400' }} hidden sm:block">{{ $step }}</span>
        </div>
        @if($i < count($steps)-1)<div class="flex-1 h-1 rounded {{ $i < $currentStep ? 'bg-primary-400' : 'bg-gray-200' }} -mt-5 mx-1 hidden sm:block"></div>@endif
        @endforeach
    </div>
    @endif
</div>
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 animate-fade-in">
        <h3 class="font-bold text-gray-900 mb-4">Item Pesanan</h3>
        <div class="divide-y divide-gray-100">
            @foreach($order->items as $item)
            <div class="flex items-center gap-4 py-4">
                <div class="w-20 h-20 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div class="flex-1"><p class="font-semibold text-gray-900">{{ $item->product_name }}</p><p class="text-sm text-gray-500">x{{ $item->quantity }}</p></div>
                <div class="text-right"><p class="font-bold text-gray-900">RM {{ number_format($item->subtotal, 2) }}</p></div>
            </div>
            @endforeach
        </div>
        @if($order->tracking_number)
        <div class="mt-6 p-4 rounded-xl bg-primary-50 border border-primary-100">
            <div class="flex items-center gap-2 mb-1"><svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/></svg><span class="font-semibold text-primary-800 text-sm">{{ $order->shippingType->name ?? 'Kurier' }} — {{ $order->statusLabel() }}</span></div>
            <p class="text-sm text-primary-700">No. Penjejakan: <span class="font-mono font-semibold">{{ $order->tracking_number }}</span></p>
        </div>
        @endif
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 h-fit animate-fade-in-right">
        <h3 class="font-bold text-gray-900 mb-4">Ringkasan</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium">RM {{ number_format($order->subtotal, 2) }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Penghantaran</span><span class="font-medium">RM {{ number_format($order->shipping_cost, 2) }}</span></div>
            <div class="border-t border-gray-100 pt-3 flex justify-between"><span class="font-semibold text-gray-900">Jumlah</span><span class="text-lg font-bold text-primary-600">RM {{ number_format($order->total, 2) }}</span></div>
        </div>
        <div class="mt-6 pt-6 border-t border-gray-100 space-y-3 text-sm">
            @if($order->address)
            <div><p class="text-gray-500 mb-1">Alamat</p><p class="font-medium text-gray-900">{{ $order->address->recipient_name }}<br>{{ $order->address->fullDisplay() }}</p></div>
            @endif
            <div><p class="text-gray-500 mb-1">Pembayaran</p><p class="font-medium text-gray-900">{{ $order->payment_method }}</p></div>
            <div><p class="text-gray-500 mb-1">Tarikh</p><p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, h:i A') }}</p></div>
        </div>
    </div>
</div>
@endsection
