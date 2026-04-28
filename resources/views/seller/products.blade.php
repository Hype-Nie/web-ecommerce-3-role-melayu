@extends('layouts.seller')
@section('title', 'Pengurusan Produk')
@section('page_title', 'Produk Saya')
@section('page_subtitle', 'Urus semua produk kedai anda')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <p class="text-sm text-gray-500">{{ $products->count() }} produk</p>
        <button data-modal-open="modal-add-product" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Tindakan</th></tr></thead>
            <tbody>
                @forelse($products as $p)
                <tr>
                    <td class="font-medium text-gray-900">{{ $p->name }}</td>
                    <td><span class="badge badge-gray">{{ $p->category->name }}</span></td>
                    <td class="font-semibold">RM {{ number_format($p->price, 2) }}</td>
                    <td><span class="{{ $p->stock <= 5 ? 'text-danger-600 font-semibold' : '' }}">{{ $p->stock }}</span></td>
                    <td><span class="badge {{ $p->is_active && $p->stock > 0 ? 'badge-success' : 'badge-danger' }}">{{ $p->stock > 0 ? ($p->is_active ? 'Aktif' : 'Tidak Aktif') : 'Habis' }}</span></td>
                    <td>
                        <form action="{{ route('seller.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Padam produk ini?')">@csrf @method('DELETE')
                            <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-8">Tiada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div id="modal-add-product" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Produk Baru</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('seller.products.store') }}" method="POST">@csrf
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label><input type="text" name="name" class="input-styled" required></div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga (RM)</label><input type="number" name="price" step="0.01" class="input-styled" required></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Stok</label><input type="number" name="stock" class="input-styled" required></div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" class="input-styled" required><option value="">Pilih</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Lama (RM)</label><input type="number" name="old_price" step="0.01" class="input-styled"></div>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><textarea name="description" class="input-styled" rows="3"></textarea></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
