@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8 animate-fade-in">
        <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
        <a href="{{ route('produk.index') }}" class="inline-flex items-center gap-2 text-sm text-primary-600 font-semibold hover:text-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Batal
        </a>
    </div>

    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="{{ $quantity }}">
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6 animate-fade-in">
                {{-- Address --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900">Alamat Penerima</h3>
                        <a href="{{ route('customer.addresses') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1 bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Alamat
                        </a>
                    </div>
                    
                    @if($addresses->isEmpty())
                    <div class="text-center py-8 px-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <p class="text-gray-900 font-bold mb-1">Anda belum mempunyai alamat.</p>
                        <p class="text-gray-500 text-sm mb-4">Sila tambah alamat terlebih dahulu untuk membuat pesanan.</p>
                        <a href="{{ route('customer.addresses') }}" class="btn-primary inline-flex items-center gap-2 text-sm !px-4 !py-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Alamat Sekarang
                        </a>
                    </div>
                    @else
                    <div class="space-y-3">
                        @foreach($addresses as $a)
                        <label class="address-card flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all duration-200 {{ $a->is_default ? 'border-primary-300 bg-primary-50' : 'border-gray-200 hover:border-primary-200 bg-white' }}">
                            <input type="radio" name="address_id" value="{{ $a->id }}" {{ $a->is_default ? 'checked' : '' }} class="mt-1 text-primary-600 focus:ring-primary-500 transition-colors" onchange="updateAddressStyles()">
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

                {{-- Payment --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Kaedah Pembayaran</h3>
                    <div class="space-y-3">
                        @foreach(['Transfer Bank'=>'Transfer Bank','E-Wallet'=>'E-Wallet (Touch n Go / GrabPay)','Tunai'=>'Bayar Tunai (COD Kampus)'] as $val => $label)
                        <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer border-gray-200 hover:border-primary-200">
                            <input type="radio" name="payment_method" value="{{ $val }}" {{ $loop->first ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                            <span class="font-medium text-gray-800 text-sm">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- WhatsApp Info --}}
                <div class="bg-primary-50 rounded-2xl border border-primary-100 p-6">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">Pesanan akan dihantar melalui WhatsApp</p>
                            <p class="text-xs text-gray-600 mt-1">Selepas membuat pesanan, anda akan dialihkan ke WhatsApp penjual untuk menyelesaikan pembayaran dan penghantaran.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 h-fit animate-fade-in-right">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                <div class="divide-y divide-gray-100 mb-4">
                    <div class="flex items-center gap-3 py-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                            @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-full h-full object-cover rounded-lg">
                            @else
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0"><p class="font-medium text-sm text-gray-900 truncate">{{ $product->name }}</p><p class="text-xs text-gray-500">x{{ $quantity }}</p></div>
                        <span class="font-semibold text-sm">RM {{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
                <div class="space-y-2 text-sm mb-6">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium">RM {{ number_format($subtotal, 2) }}</span></div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between"><span class="font-bold text-gray-900">Jumlah</span><span class="text-xl font-bold text-primary-600">RM {{ number_format($subtotal, 2) }}</span></div>
                </div>
                <button type="submit" class="btn-primary w-full text-center flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Buat Pesanan via WhatsApp
                </button>
                <a href="{{ route('produk.show', $product->slug) }}" class="btn-ghost w-full text-center block mt-2 text-sm">Batal</a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateAddressStyles() {
        document.querySelectorAll('.address-card').forEach(card => {
            card.classList.remove('border-primary-300', 'bg-primary-50');
            card.classList.add('border-gray-200', 'hover:border-primary-200', 'bg-white');
            
            let radio = card.querySelector('input[type="radio"]');
            if (radio.checked) {
                card.classList.remove('border-gray-200', 'hover:border-primary-200', 'bg-white');
                card.classList.add('border-primary-300', 'bg-primary-50');
            }
        });
    }
</script>
@endpush
@endsection
