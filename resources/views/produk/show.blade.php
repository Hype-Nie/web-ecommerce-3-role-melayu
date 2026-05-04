@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">
        {{-- Image Gallery --}}
        <div class="animate-fade-in">
            <div class="block aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 relative">
                @if($product->images->isNotEmpty())
                @php $firstImg = $product->images->first(); @endphp
                <img id="main-product-img" src="{{ asset('storage/' . $firstImg->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover cursor-pointer" onclick="openImageModal(this.src)">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                @endif
                @if($product->product_status === 'sold')
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center rounded-3xl pointer-events-none">
                    <span class="px-4 py-2 rounded-xl bg-gray-600 text-white font-bold text-lg">TERJUAL</span>
                </div>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="flex gap-3 mt-4">
                @foreach($product->images as $img)
                <button type="button" data-src="{{ asset('storage/' . $img->image_path) }}" class="thumb-btn w-20 h-20 rounded-xl overflow-hidden border-2 {{ $loop->first ? 'border-primary-400' : 'border-gray-200' }} hover:border-primary-400 transition-colors">
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
            @if($product->product_status !== 'sold')
            <form action="{{ route('checkout') }}" method="GET" class="flex gap-3 mb-3">
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
            <div class="btn-disabled flex-1 text-center flex items-center justify-center gap-2 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>Produk Ini Telah Terjual</span>
            </div>
            @endif
            @else
            <a href="{{ route('login') }}" class="btn-primary text-center block mb-3">Log Masuk untuk Membeli</a>
            @endauth

            @php
            $sellerPhone = preg_replace('/[^0-9]/', '', $product->seller->phone ?? '60123456789');
            if (str_starts_with($sellerPhone, '0')) {
                $sellerPhone = '60' . substr($sellerPhone, 1);
            }
            $waMessage = "Hola! Saya ingin bertanya tentang produk {$product->name} dengan harga RM " . number_format($product->price, 2) . ". Boleh bantu?";
            $waUrl = 'https://wa.me/' . $sellerPhone . '?text=' . urlencode($waMessage);
            @endphp

            <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-green-500 hover:bg-green-600 text-white font-medium transition-colors shadow-md w-full justify-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Semak Ketersediaan
            </a>

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
                <div class="h-40 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden relative">
                    @if($r->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $r->images->first()->image_path) }}" alt="{{ $r->name }}" class="w-full h-full object-cover">
                    @else
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @endif
                    @if($r->product_status === 'sold')
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="px-2 py-1 rounded-lg bg-gray-600 text-white text-xs font-bold">TERJUAL</span>
                    </div>
                    @endif
                </div>
                <div class="p-4"><h3 class="font-semibold text-sm text-gray-800 mb-1 line-clamp-2">{{ $r->name }}</h3><span class="text-primary-600 font-bold">RM {{ number_format($r->price, 2) }}</span></div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- Image Modal --}}
<div id="modal-img-preview" class="modal-overlay" onclick="closeImageModal(event)">
    <div class="p-6 flex items-center justify-between bg-white rounded-t-2xl">
        <h3 class="text-lg font-bold text-gray-900">Pratonton Gambar</h3>
        <button onclick="closeImageModal()" class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <div class="p-6 pt-0 flex items-center justify-center">
        <img id="modal-img-preview-src" src="" class="max-w-full max-h-[70vh] object-contain rounded-lg">
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.thumb-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var src = this.getAttribute('data-src');
        document.getElementById('main-product-img').src = src;
        document.querySelectorAll('.thumb-btn').forEach(function(b) {
            b.classList.remove('border-primary-400');
            b.classList.add('border-gray-200');
        });
        this.classList.remove('border-gray-200');
        this.classList.add('border-primary-400');
    });
});

function openImageModal(src) {
    document.getElementById('modal-img-preview-src').src = src;
    document.getElementById('modal-img-preview').classList.add('active');
    document.body.classList.add('overflow-hidden');
}

function closeImageModal(e) {
    if (!e || e.target === document.getElementById('modal-img-preview') || e.target.closest('button')) {
        document.getElementById('modal-img-preview').classList.remove('active');
        document.body.classList.remove('overflow-hidden');
    }
}
</script>
@endsection