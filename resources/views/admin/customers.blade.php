@extends('layouts.admin')
@section('title', 'Pengurusan Pelanggan')
@section('page_title', 'Pengurusan Pelanggan')
@section('page_subtitle', 'Senarai semua pelanggan berdaftar')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm animate-fade-in">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>Pelanggan</th><th>E-mel</th><th>Telefon</th><th>Pesanan</th><th>Tarikh Daftar</th><th>Status</th><th>Tindakan</th></tr></thead>
            <tbody>
                @forelse($customers as $c)
                <tr class="cursor-pointer hover:bg-gray-50" onclick="showCustomer({{ $c->id }})">
                    <td><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">{{ substr($c->name,0,1) }}</div><span class="font-medium text-gray-900">{{ $c->name }}</span></div></td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone ?? '-' }}</td>
                    <td>{{ $c->orders_count }}</td>
                    <td class="text-gray-500">{{ $c->created_at->format('d M Y') }}</td>
                    <td><span class="badge {{ $c->is_customer ? 'badge-success' : 'badge-danger' }}">{{ $c->is_customer ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    <td onclick="event.stopPropagation()">
                        <div class="flex items-center gap-1">
                            <button onclick="showCustomer({{ $c->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary-600" title="Lihat"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                            <button type="button" onclick="confirmDeleteCustomer({{ $c->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-gray-400 py-8">Tiada pelanggan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Customer Detail Modal --}}
<div id="modal-cust-detail" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Pelanggan</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6 max-h-[60vh] overflow-y-auto" id="cust-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="modal-delete-customer" class="modal-overlay">
    <div class="modal-content max-w-md">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-danger-50 flex items-center justify-center text-danger-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
                <h3 class="text-lg font-bold text-gray-900">Padam Pelanggan</h3>
            </div>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 text-base leading-relaxed">Memadam pelanggan ini akan mengakibatkan <span class="font-semibold text-gray-900">semua sejarah pesanan dan alamat mereka turut terpadam secara kekal</span>. Adakah anda pasti ingin meneruskan?</p>
        </div>
        <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" data-modal-close class="btn-ghost text-sm !px-5 !py-2.5">Batal</button>
            <form id="delete-customer-form" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger text-sm !px-6 !py-2.5">Ya, Padam</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showCustomer(id) {
    const modal = document.getElementById('modal-cust-detail');
    const body = document.getElementById('cust-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/admin/pelanggan/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            let ordersHtml = d.recent_orders.length ? d.recent_orders.map(o => `<div class="flex justify-between py-2"><div><p class="font-medium text-sm">#${o.order_number}</p><p class="text-xs text-gray-400">${o.date}</p></div><div class="text-right"><p class="font-semibold text-sm">RM ${o.total}</p><span class="badge ${o.status_badge}">${o.status}</span></div></div>`).join('') : '<p class="text-sm text-gray-400">Tiada pesanan</p>';
            body.innerHTML = `
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xl">${d.name.charAt(0)}</div>
                    <div><h4 class="font-bold text-gray-900 text-lg">${d.name}</h4><p class="text-sm text-gray-500">${d.email}</p></div>
                    <span class="ml-auto badge ${d.is_customer ? 'badge-success' : 'badge-danger'}">${d.is_customer ? 'Aktif' : 'Tidak Aktif'}</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-xl p-3 text-center"><p class="text-xl font-bold text-gray-900">${d.orders_count}</p><p class="text-xs text-gray-400">Pesanan</p></div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center"><p class="text-xl font-bold text-primary-600">RM ${d.total_spending}</p><p class="text-xs text-gray-400">Jumlah Belanja</p></div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center"><p class="text-xl font-bold text-gray-900">${d.addresses_count}</p><p class="text-xs text-gray-400">Alamat</p></div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center"><p class="text-sm font-medium text-gray-900">${d.created_at}</p><p class="text-xs text-gray-400">Tarikh Daftar</p></div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                    <div><p class="text-gray-400 text-xs">Telefon</p><p class="font-medium">${d.phone || '-'}</p></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 font-semibold uppercase mb-2">Pesanan Terbaru</p>
                    <div class="divide-y divide-gray-200">${ordersHtml}</div>
                </div>
            `;
        });
}

function confirmDeleteCustomer(id) {
    event.stopPropagation();
    document.getElementById('delete-customer-form').action = `/admin/pelanggan/${id}`;
    const modal = document.getElementById('modal-delete-customer');
    modal.classList.add('active'); 
    document.body.classList.add('overflow-hidden');
}
</script>
@endsection
