@extends('layouts.admin')
@section('title', 'Pengurusan Penghantaran')
@section('page_title', 'Jenis Penghantaran')
@section('page_subtitle', 'Urus jenis dan kos penghantaran')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm animate-fade-in">{{ session('success') }}</div>
@endif

<div class="flex justify-end mb-6">
    <button data-modal-open="modal-add-shipping" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Jenis
    </button>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @php $shipColors = ['from-red-500 to-red-600','from-red-400 to-orange-500','from-yellow-500 to-yellow-600','from-primary-500 to-primary-600','from-blue-500 to-blue-600']; @endphp
    @foreach($shippings as $i => $s)
    <div class="bg-white rounded-2xl border border-gray-100 p-6 card-hover animate-fade-in-up {{ !$s->is_active ? 'opacity-60' : '' }} cursor-pointer" onclick="showShipping({{ $s->id }})">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $shipColors[$i % count($shipColors)] }} flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <span class="badge {{ $s->is_active ? 'badge-success' : 'badge-gray' }}">{{ $s->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
        <h3 class="font-bold text-gray-900 mb-1">{{ $s->name }}</h3>
        <p class="text-sm text-gray-500 mb-2">{{ $s->description }}</p>
        @if($s->estimated_days)<p class="text-xs text-gray-400 mb-4">{{ $s->estimated_days }}</p>@endif
        <div class="flex items-center justify-between pt-4 border-t border-gray-100" onclick="event.stopPropagation()">
            <span class="text-lg font-bold text-primary-600">RM {{ number_format($s->price, 2) }}</span>
            <div class="flex items-center gap-1">
                <button onclick="editShipping({{ $s->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary-600" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                <form action="{{ route('admin.shipping.destroy', $s) }}" method="POST" onsubmit="return confirm('Padam?')">@csrf @method('DELETE')
                    <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Add Shipping Modal --}}
<div id="modal-add-shipping" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Jenis Penghantaran</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('admin.shipping.store') }}" method="POST">@csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kurier</label><input type="text" name="name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><input type="text" name="description" class="input-styled"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Anggaran Hari</label><input type="text" name="estimated_days" class="input-styled" placeholder="cth: 1-2 hari"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga (RM)</label><input type="number" name="price" step="0.01" class="input-styled" required></div>
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
<div id="modal-ship-detail" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Penghantaran</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6" id="ship-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>

{{-- Edit Shipping Modal --}}
<div id="modal-edit-shipping" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Edit Penghantaran</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="edit-ship-form" method="POST">@csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kurier</label><input type="text" name="name" id="edit-ship-name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><input type="text" name="description" id="edit-ship-desc" class="input-styled"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Anggaran Hari</label><input type="text" name="estimated_days" id="edit-ship-days" class="input-styled"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga (RM)</label><input type="number" name="price" id="edit-ship-price" step="0.01" class="input-styled" required></div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" id="edit-ship-active" class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Aktif</span></label></div>
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
function showShipping(id) {
    const modal = document.getElementById('modal-ship-detail');
    const body = document.getElementById('ship-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/admin/penghantaran/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            body.innerHTML = `
                <h4 class="text-xl font-bold text-gray-900 mb-4">${d.name}</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-400 text-xs">Harga</p><p class="font-bold text-primary-600 text-lg">RM ${parseFloat(d.price).toFixed(2)}</p></div>
                    <div><p class="text-gray-400 text-xs">Status</p><p><span class="badge ${d.is_active ? 'badge-success' : 'badge-gray'}">${d.is_active ? 'Aktif' : 'Tidak Aktif'}</span></p></div>
                    <div><p class="text-gray-400 text-xs">Anggaran Hari</p><p class="font-medium">${d.estimated_days || '-'}</p></div>
                    <div><p class="text-gray-400 text-xs">Tarikh</p><p class="font-medium">${d.created_at}</p></div>
                </div>
                ${d.description ? `<div class="mt-4"><p class="text-gray-400 text-xs mb-1">Penerangan</p><p class="text-sm text-gray-600">${d.description}</p></div>` : ''}
            `;
        });
}
function editShipping(id) {
    fetch(`/admin/penghantaran/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            document.getElementById('edit-ship-form').action = `/admin/penghantaran/${d.id}`;
            document.getElementById('edit-ship-name').value = d.name;
            document.getElementById('edit-ship-desc').value = d.description || '';
            document.getElementById('edit-ship-days').value = d.estimated_days || '';
            document.getElementById('edit-ship-price').value = d.price;
            document.getElementById('edit-ship-active').checked = d.is_active;
            const modal = document.getElementById('modal-edit-shipping');
            modal.classList.add('active'); document.body.classList.add('overflow-hidden');
        });
}
</script>
@endsection
