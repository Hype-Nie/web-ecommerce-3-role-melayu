@extends('layouts.admin')
@section('title', 'Pengurusan Penjual')
@section('page_title', 'Pengurusan Penjual')
@section('page_subtitle', 'Senarai semua penjual berdaftar')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm animate-fade-in">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari penjual..." class="input-search w-64">
        </div>
        <button data-modal-open="modal-add-seller" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Penjual
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>Penjual</th><th>E-mel</th><th>Kedai</th><th>Produk</th><th>Status</th><th>Tindakan</th></tr></thead>
            <tbody>
                @forelse($sellers as $s)
                <tr>
                    <td><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">{{ substr($s->name,0,1) }}</div><span class="font-medium text-gray-900">{{ $s->name }}</span></div></td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->shop_name ?? '-' }}</td>
                    <td>{{ $s->products_count }}</td>
                    <td><span class="badge {{ $s->is_active ? 'badge-success' : 'badge-danger' }}">{{ $s->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    <td>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.sellers.toggle', $s) }}" method="POST">@csrf @method('PATCH')
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-amber-600" title="Tukar Status"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
                            </form>
                            <form action="{{ route('admin.sellers.destroy', $s) }}" method="POST" onsubmit="return confirm('Padam penjual ini?')">@csrf @method('DELETE')
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600" title="Padam"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-8">Tiada penjual</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Seller Modal --}}
<div id="modal-add-seller" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Penjual Baru</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('admin.sellers.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama</label><input type="text" name="name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kedai</label><input type="text" name="shop_name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">E-mel</label><input type="email" name="email" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label><input type="tel" name="phone" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label><input type="password" name="password" class="input-styled" required></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
