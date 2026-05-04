@extends('layouts.customer')
@section('title', 'Butiran Pesanan #' . $order->order_number)
@section('page_title', 'Butiran Pesanan')
@section('page_subtitle', '#' . $order->order_number)

@section('content')
@php
$statusSteps = ['sold'=>0,'processing'=>1,'shipped'=>2,'completed'=>3];
$currentStep = $statusSteps[$order->status] ?? -1;
$steps = ['Terjual','Diproses','Dihantar','Selesai'];
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
                <div class="w-20 h-20 rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                    @if($item->product && $item->product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" class="w-full h-full object-cover rounded-xl">
                    @else
                    <svg class="w-10 h-10 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @endif
                </div>
                <div class="flex-1"><p class="font-semibold text-gray-900">{{ $item->product_name }}</p><p class="text-sm text-gray-500">x{{ $item->quantity }}</p></div>
                <div class="text-right"><p class="font-bold text-gray-900">RM {{ number_format($item->subtotal, 2) }}</p></div>
            </div>
            @endforeach
        </div>
        @if($order->whatsapp_sent)
        <div class="mt-6 p-4 rounded-xl bg-green-50 border border-green-100">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                <span class="font-semibold text-green-800 text-sm">Pesanan telah dihantar melalui WhatsApp</span>
            </div>
        </div>
        @endif
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 h-fit animate-fade-in-right">
        <h3 class="font-bold text-gray-900 mb-4">Ringkasan</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium">RM {{ number_format($order->subtotal, 2) }}</span></div>
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
