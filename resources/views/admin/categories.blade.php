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
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover animate-fade-in-up {{ !$c->is_active ? 'opacity-60' : '' }} cursor-pointer" onclick="showCategory({{ $c->id }})">
        @if($c->image)
        <div class="h-32 overflow-hidden"><img src="{{ asset('storage/' . $c->image) }}" alt="{{ $c->name }}" class="w-full h-full object-cover"></div>
        @endif
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $catColors[$i % count($catColors)] }} flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                    <button onclick="editCategory({{ $c->id }})" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                    <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Padam?')">@csrf @method('DELETE')
                        <button class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-danger-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </form>
                </div>
            </div>
            <h3 class="font-bold text-gray-900 mb-1">{{ $c->name }}</h3>
            <p class="text-sm text-gray-500">{{ $c->products_count }} produk</p>
            <div class="mt-3"><span class="badge {{ $c->is_active ? 'badge-success' : 'badge-gray' }}">{{ $c->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></div>
        </div>
    </div>
    @endforeach
</div>

{{-- Add Category Modal --}}
<div id="modal-add-cat" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Kategori</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label><input type="text" name="name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><textarea name="description" class="input-styled" rows="3"></textarea></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Kategori</label>
                    <input type="file" name="image" accept="image/*" class="input-styled !py-2 !text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Aktif</span></label></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Modal --}}
<div id="modal-cat-detail" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Kategori</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6" id="cat-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>

{{-- Edit Category Modal --}}
<div id="modal-edit-cat" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Edit Kategori</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="edit-cat-form" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label><input type="text" name="name" id="edit-cat-name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><textarea name="description" id="edit-cat-desc" class="input-styled" rows="3"></textarea></div>
                <div id="edit-cat-img-preview"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Baru (kosongkan jika tidak berubah)</label>
                    <input type="file" name="image" accept="image/*" class="input-styled !py-2 !text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" id="edit-cat-active" class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Aktif</span></label></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Kemaskini</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showCategory(id) {
    const modal = document.getElementById('modal-cat-detail');
    const body = document.getElementById('cat-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/admin/kategori/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            body.innerHTML = `
                ${d.image ? `<img src="${d.image}" class="w-full h-40 object-cover rounded-xl mb-4">` : ''}
                <h4 class="text-xl font-bold text-gray-900 mb-2">${d.name}</h4>
                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div><p class="text-gray-400 text-xs">Produk</p><p class="font-medium">${d.products_count}</p></div>
                    <div><p class="text-gray-400 text-xs">Status</p><p><span class="badge ${d.is_active ? 'badge-success' : 'badge-gray'}">${d.is_active ? 'Aktif' : 'Tidak Aktif'}</span></p></div>
                    <div><p class="text-gray-400 text-xs">Tarikh</p><p class="font-medium">${d.created_at}</p></div>
                </div>
                ${d.description ? `<div><p class="text-gray-400 text-xs mb-1">Penerangan</p><p class="text-sm text-gray-600">${d.description}</p></div>` : ''}
            `;
        });
}
function editCategory(id) {
    fetch(`/admin/kategori/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            document.getElementById('edit-cat-form').action = `/admin/kategori/${d.id}`;
            document.getElementById('edit-cat-name').value = d.name;
            document.getElementById('edit-cat-desc').value = d.description || '';
            document.getElementById('edit-cat-active').checked = d.is_active;
            document.getElementById('edit-cat-img-preview').innerHTML = d.image ? `<p class="text-sm font-medium text-gray-700 mb-1">Gambar Semasa</p><img src="${d.image}" class="w-24 h-24 rounded-xl object-cover">` : '';
            const modal = document.getElementById('modal-edit-cat');
            modal.classList.add('active'); document.body.classList.add('overflow-hidden');
        });
}
</script>
@endsection
