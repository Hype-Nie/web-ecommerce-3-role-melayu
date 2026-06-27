@extends('layouts.customer')
@section('title', 'Alamat Saya')
@section('page_title', 'Alamat Saya')
@section('page_subtitle', 'Urus alamat penghantaran anda')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="flex justify-end mb-6">
    <button data-modal-open="modal-add-addr" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Alamat
    </button>
</div>
<div class="grid sm:grid-cols-2 gap-6">
    @foreach($addresses as $a)
    <div class="bg-white rounded-2xl border {{ $a->is_default ? 'border-primary-300 ring-2 ring-primary-100' : 'border-gray-100' }} p-6 card-hover animate-fade-in-up relative cursor-pointer" onclick="showAddressDetail({{ $a->id }})">
        @if($a->is_default)<span class="absolute top-4 right-4 badge badge-success">Utama</span>@endif
        <div class="flex items-center gap-2 mb-3"><svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg><span class="font-semibold text-gray-900">{{ $a->label }}</span></div>
        <p class="font-medium text-gray-800 text-sm">{{ $a->recipient_name }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $a->phone }}</p>
        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $a->fullDisplay() }}</p>
        <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100" onclick="event.stopPropagation()">
            <button onclick="editAddress({{ $a->id }})" class="text-sm text-primary-600 font-semibold hover:text-primary-700">Edit</button>
            <span class="text-gray-300">·</span>
            @if(!$a->is_default)
            <form action="{{ route('customer.addresses.default', $a) }}" method="POST">@csrf @method('PATCH')<button class="text-sm text-primary-600 font-semibold hover:text-primary-700">Tetapkan Utama</button></form>
            <span class="text-gray-300">·</span>
            <button type="button" onclick="confirmDeleteAddress({{ $a->id }})" class="text-sm text-danger-600 font-semibold hover:text-danger-700">Padam</button>
            @else
            <span class="text-sm text-gray-400">Alamat utama</span>
            @endif
        </div>
    </div>
    @endforeach
</div>

{{-- Add Address Modal --}}
<div id="modal-add-addr" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Alamat Baru</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('customer.addresses.store') }}" method="POST">@csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Label</label><input type="text" name="label" class="input-styled" placeholder="cth: Rumah" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label><input type="text" name="recipient_name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label><input type="tel" name="phone" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Alamat Penuh</label><textarea name="full_address" class="input-styled" rows="2" required></textarea></div>
                <div class="grid grid-cols-3 gap-3">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Bandar</label><input type="text" name="city" class="input-styled"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Poskod</label><input type="text" name="postcode" class="input-styled"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Negeri</label><input type="text" name="state" class="input-styled"></div>
                </div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_default" value="1" class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Tetapkan sebagai alamat utama</span></label></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Modal --}}
<div id="modal-addr-detail" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Alamat</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6 space-y-3" id="addr-detail-body">
            <p class="text-center text-gray-400">Memuatkan...</p>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit-addr" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Edit Alamat</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="edit-addr-form" method="POST">@csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Label</label><input type="text" name="label" id="edit-addr-label" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label><input type="text" name="recipient_name" id="edit-addr-recipient" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label><input type="tel" name="phone" id="edit-addr-phone" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Alamat Penuh</label><textarea name="full_address" id="edit-addr-address" class="input-styled" rows="2" required></textarea></div>
                <div class="grid grid-cols-3 gap-3">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Bandar</label><input type="text" name="city" id="edit-addr-city" class="input-styled"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Poskod</label><input type="text" name="postcode" id="edit-addr-postcode" class="input-styled"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Negeri</label><input type="text" name="state" id="edit-addr-state" class="input-styled"></div>
                </div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_default" value="1" id="edit-addr-default" class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Tetapkan sebagai alamat utama</span></label></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Kemaskini</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="modal-delete-addr" class="modal-overlay">
    <div class="modal-content max-w-md">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-danger-50 flex items-center justify-center text-danger-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
                <h3 class="text-lg font-bold text-gray-900">Padam Alamat</h3>
            </div>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 text-base leading-relaxed">Adakah anda pasti ingin memadam alamat ini? Tindakan ini tidak boleh dipulihkan.</p>
        </div>
        <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" data-modal-close class="btn-ghost text-sm !px-5 !py-2.5">Batal</button>
            <form id="delete-addr-form" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger text-sm !px-6 !py-2.5">Ya, Padam</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showAddressDetail(id) {
    const modal = document.getElementById('modal-addr-detail');
    const body = document.getElementById('addr-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active');
    document.body.classList.add('overflow-hidden');
    fetch(`/pelanggan/alamat/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            body.innerHTML = `
                <div class="flex items-center gap-2 mb-1"><svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg><span class="font-bold text-gray-900 text-lg">${d.label}</span>${d.is_default ? '<span class="badge badge-success ml-2">Utama</span>' : ''}</div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div><p class="text-xs text-gray-400 mb-1">Nama Penerima</p><p class="font-medium text-gray-900 text-sm">${d.recipient_name}</p></div>
                    <div><p class="text-xs text-gray-400 mb-1">No. Telefon</p><p class="font-medium text-gray-900 text-sm">${d.phone}</p></div>
                    <div class="col-span-2"><p class="text-xs text-gray-400 mb-1">Alamat Penuh</p><p class="font-medium text-gray-900 text-sm">${d.full_address}</p></div>
                    <div><p class="text-xs text-gray-400 mb-1">Bandar</p><p class="font-medium text-gray-900 text-sm">${d.city || '-'}</p></div>
                    <div><p class="text-xs text-gray-400 mb-1">Poskod</p><p class="font-medium text-gray-900 text-sm">${d.postcode || '-'}</p></div>
                    <div><p class="text-xs text-gray-400 mb-1">Negeri</p><p class="font-medium text-gray-900 text-sm">${d.state || '-'}</p></div>
                </div>
            `;
        });
}
function editAddress(id) {
    fetch(`/pelanggan/alamat/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            document.getElementById('edit-addr-form').action = `/pelanggan/alamat/${d.id}`;
            document.getElementById('edit-addr-label').value = d.label;
            document.getElementById('edit-addr-recipient').value = d.recipient_name;
            document.getElementById('edit-addr-phone').value = d.phone;
            document.getElementById('edit-addr-address').value = d.full_address;
            document.getElementById('edit-addr-city').value = d.city || '';
            document.getElementById('edit-addr-postcode').value = d.postcode || '';
            document.getElementById('edit-addr-state').value = d.state || '';
            document.getElementById('edit-addr-default').checked = d.is_default;
            const modal = document.getElementById('modal-edit-addr');
            modal.classList.add('active');
            document.body.classList.add('overflow-hidden');
            modal.classList.add('active');
            document.body.classList.add('overflow-hidden');
        });
}

function confirmDeleteAddress(id) {
    event.stopPropagation();
    document.getElementById('delete-addr-form').action = `/pelanggan/alamat/${id}`;
    const modal = document.getElementById('modal-delete-addr');
    modal.classList.add('active'); 
    document.body.classList.add('overflow-hidden');
}
</script>
@endsection
