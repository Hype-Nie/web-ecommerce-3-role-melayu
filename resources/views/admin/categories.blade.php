@extends('layouts.admin')
@section('title', 'Pengurusan Kategori')
@section('page_title', 'Pengurusan Kategori')
@section('page_subtitle', 'Urus kategori produk')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="flex justify-end mb-6">
    <button data-modal-open="modal-add-cat" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Kategori
    </button>
</div>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @php $catColors = ['from-blue-500 to-blue-600','from-pink-500 to-rose-500','from-amber-500 to-orange-500','from-primary-500 to-primary-600','from-red-500 to-red-600','from-violet-500 to-purple-600','from-teal-500 to-teal-600']; @endphp
    @foreach($categories as $i => $c)
    <div class="bg-white rounded-2xl border border-gray-100 p-6 card-hover animate-fade-in-up {{ !$c->is_active ? 'opacity-60' : '' }}">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $catColors[$i % count($catColors)] }} flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Padam?')">@csrf @method('DELETE')
                <button class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-danger-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
            </form>
        </div>
        <h3 class="font-bold text-gray-900 mb-1">{{ $c->name }}</h3>
        <p class="text-sm text-gray-500">{{ $c->products_count }} produk</p>
        <div class="mt-3"><span class="badge {{ $c->is_active ? 'badge-success' : 'badge-gray' }}">{{ $c->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></div>
    </div>
    @endforeach
</div>
<div id="modal-add-cat" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Kategori</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST">@csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label><input type="text" name="name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><textarea name="description" class="input-styled" rows="3"></textarea></div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Aktif</span></label></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
