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
            <input type="text" id="seller-search" placeholder="Cari penjual..." class="input-search w-64">
        </div>
        <button data-modal-open="modal-add-seller" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Penjual
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="table-modern" id="sellers-table">
            <thead><tr><th>Penjual</th><th>E-mel</th><th>Kedai</th><th>Produk</th><th>Status</th><th>Tindakan</th></tr></thead>
            <tbody>
                @forelse($sellers as $s)
                <tr class="cursor-pointer hover:bg-gray-50" onclick="showSeller({{ $s->id }})">
                    <td><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">{{ substr($s->name,0,1) }}</div><span class="font-medium text-gray-900">{{ $s->name }}</span></div></td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->shop_name ?? '-' }}</td>
                    <td>{{ $s->products_count }}</td>
                    <td><span class="badge {{ $s->is_active ? 'badge-success' : 'badge-danger' }}">{{ $s->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    <td onclick="event.stopPropagation()">
                        <div class="flex items-center gap-1">
                            <button onclick="editSeller({{ $s->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary-600" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <form action="{{ route('admin.sellers.toggle', $s) }}" method="POST">@csrf @method('PATCH')
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-amber-600" title="Tukar Status"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
                            </form>
                            <button type="button" onclick="confirmDeleteSeller({{ $s->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600" title="Padam"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
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
        <form action="{{ route('admin.sellers.store') }}" method="POST">@csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama</label><input type="text" name="name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Campus ID / NIM</label><input type="text" name="campus_id" class="input-styled" required></div>
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

{{-- Detail Modal --}}
<div id="modal-seller-detail" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Penjual</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6" id="seller-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>

{{-- Edit Seller Modal --}}
<div id="modal-edit-seller" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Edit Penjual</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="edit-seller-form" method="POST">@csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama</label><input type="text" name="name" id="edit-s-name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Kedai</label><input type="text" name="shop_name" id="edit-s-shop" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">E-mel</label><input type="email" name="email" id="edit-s-email" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label><input type="tel" name="phone" id="edit-s-phone" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan Baru (kosongkan jika tidak berubah)</label><input type="password" name="password" class="input-styled"></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Kemaskini</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="modal-delete-seller" class="modal-overlay">
    <div class="modal-content max-w-md">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-danger-50 flex items-center justify-center text-danger-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
                <h3 class="text-lg font-bold text-gray-900">Padam Penjual</h3>
            </div>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 text-base leading-relaxed">Memadam penjual ini akan mengakibatkan <span class="font-semibold text-gray-900">semua produk dan data kedai mereka turut terpadam secara kekal</span>. Adakah anda pasti ingin meneruskan?</p>
        </div>
        <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" data-modal-close class="btn-ghost text-sm !px-5 !py-2.5">Batal</button>
            <form id="delete-seller-form" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger text-sm !px-6 !py-2.5">Ya, Padam</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Seller search filter
document.getElementById('seller-search').addEventListener('keyup', function() {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#sellers-table tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});

function showSeller(id) {
    const modal = document.getElementById('modal-seller-detail');
    const body = document.getElementById('seller-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/admin/penjual/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            body.innerHTML = `
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xl">${d.name.charAt(0)}</div>
                    <div><h4 class="font-bold text-gray-900 text-lg">${d.name}</h4><p class="text-sm text-gray-500">${d.shop_name || '-'}</p></div>
                    <span class="ml-auto badge ${d.is_active ? 'badge-success' : 'badge-danger'}">${d.is_active ? 'Aktif' : 'Tidak Aktif'}</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-400 text-xs">E-mel</p><p class="font-medium">${d.email}</p></div>
                    <div><p class="text-gray-400 text-xs">Telefon</p><p class="font-medium">${d.phone || '-'}</p></div>
                    <div><p class="text-gray-400 text-xs">Jumlah Produk</p><p class="font-medium">${d.products_count}</p></div>
                    <div><p class="text-gray-400 text-xs">Jumlah Jualan</p><p class="font-bold text-primary-600">RM ${d.total_sales}</p></div>
                    <div><p class="text-gray-400 text-xs">Tarikh Daftar</p><p class="font-medium">${d.created_at}</p></div>
                </div>
            `;
        });
}
function editSeller(id) {
    fetch(`/admin/penjual/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            document.getElementById('edit-seller-form').action = `/admin/penjual/${d.id}`;
            document.getElementById('edit-s-name').value = d.name;
            document.getElementById('edit-s-shop').value = d.shop_name || '';
            document.getElementById('edit-s-email').value = d.email;
            document.getElementById('edit-s-phone').value = d.phone || '';
            const modal = document.getElementById('modal-edit-seller');
            modal.classList.add('active'); document.body.classList.add('overflow-hidden');
        });
}

function confirmDeleteSeller(id) {
    event.stopPropagation();
    document.getElementById('delete-seller-form').action = `/admin/penjual/${id}`;
    const modal = document.getElementById('modal-delete-seller');
    modal.classList.add('active'); 
    document.body.classList.add('overflow-hidden');
}
</script>
@endsection
