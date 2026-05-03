@extends('layouts.seller')
@section('title', 'Pengurusan Transaksi')
@section('page_title', 'Transaksi')
@section('page_subtitle', 'Urus pesanan pelanggan anda')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Tarikh</th><th>Status</th><th>Tindakan</th></tr></thead>
            <tbody>
                @forelse($orders as $o)
                <tr class="cursor-pointer hover:bg-gray-50" onclick="showTransaction({{ $o->id }})">
                    <td class="font-semibold">#{{ $o->order_number }}</td>
                    <td>{{ $o->user->name }}</td>
                    <td class="font-semibold">RM {{ number_format($o->total, 2) }}</td>
                    <td class="text-gray-500">{{ $o->created_at->format('d M Y') }}</td>
                    <td><span class="badge {{ $o->statusBadge() }}">{{ $o->statusLabel() }}</span></td>
                    <td onclick="event.stopPropagation()">
                        <div class="flex items-center gap-2">
                            <button onclick="showTransaction({{ $o->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary-600" title="Lihat"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                            <form action="{{ route('seller.transactions.status', $o) }}" method="POST" onclick="event.stopPropagation()">@csrf @method('PATCH')
                                <select name="status" onchange="if(confirm('Pasti mahu menukar status ke: ' + this.options[this.selectedIndex].text + '?')) this.form.submit(); else this.value='{{ $o->status }}';" class="px-2 py-1 rounded-lg border border-gray-200 text-xs font-medium text-gray-700 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 cursor-pointer">
                                    <option value="sold" {{ $o->status == 'sold' ? 'selected' : '' }}>Terjual</option>
                                    <option value="processing" {{ $o->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="shipped" {{ $o->status == 'shipped' ? 'selected' : '' }}>Dihantar</option>
                                    <option value="completed" {{ $o->status == 'completed' ? 'selected' : '' }}>Tiba (Selesai)</option>
                                    <option value="cancelled" {{ $o->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-8">Tiada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Transaction Detail Modal --}}
<div id="modal-tx-detail" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Pesanan</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6 max-h-[60vh] overflow-y-auto" id="tx-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showTransaction(id) {
    const modal = document.getElementById('modal-tx-detail');
    const body = document.getElementById('tx-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/penjual/transaksi/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            let itemsHtml = d.items.map(i => `<div class="flex justify-between py-2"><div><p class="font-medium text-sm">${i.product_name}</p><p class="text-xs text-gray-400">x${i.quantity}</p></div><span class="font-semibold text-sm">RM ${i.subtotal}</span></div>`).join('');
            let statusMap = {'completed':'gray','cancelled':'danger','shipped':'success','processing':'warning','sold':'success','pending':'info'};
            body.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900">#${d.order_number}</h4>
                    <span class="badge badge-${statusMap[d.status] || 'gray'}">${d.status_label}</span>
                </div>
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-semibold uppercase mb-2">Pelanggan</p>
                        <p class="font-medium text-sm">${d.customer.name}</p>
                        <p class="text-sm text-gray-500">${d.customer.email}</p>
                        <p class="text-sm text-gray-500">${d.customer.phone || '-'}</p>
                        <p class="text-sm text-gray-500 mt-1">Campus ID: ${d.customer.campus_id || '-'}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-semibold uppercase mb-2">Alamat</p>
                        ${d.address ? `<p class="font-medium text-sm">${d.address.recipient_name}</p><p class="text-sm text-gray-500">${d.address.phone}</p><p class="text-sm text-gray-500">${d.address.full_display}</p>` : '<p class="text-sm text-gray-400">-</p>'}
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <p class="text-xs text-gray-400 font-semibold uppercase mb-2">Item Pesanan</p>
                    <div class="divide-y divide-gray-200">${itemsHtml}</div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div><p class="text-gray-400 text-xs">Subtotal</p><p class="font-semibold">RM ${d.subtotal}</p></div>
                    <div><p class="text-gray-400 text-xs">Pembayaran</p><p class="font-medium">${d.payment_method}</p></div>
                    <div><p class="text-gray-400 text-xs">Jumlah</p><p class="font-bold text-primary-600">RM ${d.total}</p></div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm mt-3">
                    <div><p class="text-gray-400 text-xs">WhatsApp</p><p class="font-medium">${d.whatsapp_sent ? '✅ Terhantar' : '❌ Belum'}</p></div>
                    <div><p class="text-gray-400 text-xs">Tarikh</p><p class="font-medium">${d.created_at}</p></div>
                </div>
            `;
        });
}
</script>
@endsection
