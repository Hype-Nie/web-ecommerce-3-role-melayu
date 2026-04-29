@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8 animate-fade-in">
        <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
        <a href="{{ route('cart') }}" class="inline-flex items-center gap-2 text-sm text-primary-600 font-semibold hover:text-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Troli
        </a>
    </div>

    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6 animate-fade-in">
                {{-- Address --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Alamat Penghantaran</h3>
                    @if($addresses->isEmpty())
                    <p class="text-gray-500 text-sm">Tiada alamat. <a href="{{ route('customer.addresses') }}" class="text-primary-600 font-semibold">Tambah sekarang</a></p>
                    @else
                    <div class="space-y-3">
                        @foreach($addresses as $a)
                        <label class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer {{ $a->is_default ? 'border-primary-300 bg-primary-50/50' : 'border-gray-200 hover:border-primary-200' }}">
                            <input type="radio" name="address_id" value="{{ $a->id }}" {{ $a->is_default ? 'checked' : '' }} class="mt-1 text-primary-600 focus:ring-primary-500">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $a->label }} — {{ $a->recipient_name }}</p>
                                <p class="text-sm text-gray-500">{{ $a->phone }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $a->fullDisplay() }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Shipping --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Kaedah Penghantaran</h3>
                    <div class="space-y-3">
                        @foreach($shippingTypes as $s)
                        <label class="flex items-center justify-between p-4 rounded-xl border cursor-pointer border-gray-200 hover:border-primary-200">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_type_id" value="{{ $s->id }}" {{ $loop->first ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                                <div><p class="font-semibold text-gray-900 text-sm">{{ $s->name }}</p><p class="text-xs text-gray-500">{{ $s->estimated_days }}</p></div>
                            </div>
                            <span class="font-bold text-gray-900 text-sm">RM {{ number_format($s->price, 2) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Payment --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Kaedah Pembayaran</h3>
                    <div class="space-y-3">
                        @foreach(['FPX'=>'FPX Online Banking','Kad Kredit'=>'Kad Kredit / Debit','E-Wallet'=>'E-Wallet (Touch n Go / GrabPay)'] as $val => $label)
                        <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer border-gray-200 hover:border-primary-200">
                            <input type="radio" name="payment_method" value="{{ $val }}" {{ $loop->first ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                            <span class="font-medium text-gray-800 text-sm">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 h-fit animate-fade-in-right">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                <div class="divide-y divide-gray-100 mb-4">
                    @foreach($cartItems as $item)
                    <div class="flex items-center gap-3 py-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0"><svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                        <div class="flex-1 min-w-0"><p class="font-medium text-sm text-gray-900 truncate">{{ $item->product->name }}</p><p class="text-xs text-gray-500">x{{ $item->quantity }}</p></div>
                        <span class="font-semibold text-sm">RM {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="space-y-2 text-sm mb-6">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium">RM {{ number_format($subtotal, 2) }}</span></div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between"><span class="font-bold text-gray-900">Anggaran Jumlah</span><span class="text-xl font-bold text-primary-600">RM {{ number_format($subtotal, 2) }}+</span></div>
                </div>
                <button type="submit" class="btn-primary w-full text-center">Buat Pesanan</button>
                <a href="{{ route('cart') }}" class="btn-ghost w-full text-center block mt-2 text-sm">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
