@extends('layouts.admin')
@section('title', 'Papan Pemuka')
@section('page_title', 'Papan Pemuka Admin')
@section('page_subtitle', 'Ringkasan keseluruhan platform')

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php
    $stats = [
        ['label'=>'Jumlah Penjual','value'=>$totalSellers,'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','color'=>'from-primary-500 to-primary-600'],
        ['label'=>'Jumlah Pelanggan','value'=>$totalCustomers,'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z','color'=>'from-blue-500 to-blue-600'],
        ['label'=>'Jumlah Produk','value'=>$totalProducts,'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4','color'=>'from-violet-500 to-purple-600'],
        ['label'=>'Jumlah Pendapatan','value'=>number_format($totalRevenue, 2),'prefix'=>'RM ','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'from-amber-500 to-orange-500'],
    ];
    @endphp
    @foreach($stats as $i => $s)
    <div class="stat-card animate-fade-in-up" style="animation-delay:{{ $i*0.1 }}s">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $s['prefix'] ?? '' }}{{ $s['value'] }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Chart Section --}}
<div class="bg-white rounded-2xl border border-gray-100 mb-8 animate-fade-in p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-900">Pendapatan 7 Hari Terakhir</h3>
    </div>
    <div class="relative h-72">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100"><h3 class="font-bold text-gray-900">Pesanan Terbaru</h3></div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Status</th><th>Tarikh</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $o)
                <tr class="cursor-pointer hover:bg-primary-50/50" onclick="showOrderDetail({{ $o->id }})">
                    <td class="font-semibold text-gray-900">#{{ $o->order_number }}</td>
                    <td>{{ $o->user->name }}</td>
                    <td class="font-semibold">RM {{ number_format($o->total, 2) }}</td>
                    <td><span class="badge {{ $o->statusBadge() }}">{{ $o->statusLabel() }}</span></td>
                    <td class="text-gray-500">{{ $o->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-8">Tiada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Order Detail Modal --}}
<div id="modal-order-detail" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Pesanan</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6 max-h-[60vh] overflow-y-auto" id="order-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(225, 29, 72, 0.2)');
    gradient.addColorStop(1, 'rgba(225, 29, 72, 0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (RM)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#e11d48',
                backgroundColor: gradient,
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#e11d48',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 14, weight: 'bold' },
                    callbacks: {
                        label: function(context) {
                            return 'RM ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        color: '#64748b',
                        callback: function(value) { return 'RM ' + value; }
                    }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    border: { display: false },
                    ticks: { color: '#64748b' }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
});

function showOrderDetail(id) {
    const modal = document.getElementById('modal-order-detail');
    const body = document.getElementById('order-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/admin/pesanan/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            let itemsHtml = d.items.map(i => `
                <div class="flex items-center justify-between py-2">
                    <div><p class="font-medium text-sm text-gray-900">${i.name}</p><p class="text-xs text-gray-500">x${i.quantity} @ RM ${i.price}</p></div>
                    <span class="font-semibold text-sm">RM ${i.subtotal}</span>
                </div>
            `).join('');
            body.innerHTML = `
                <div class="flex items-center justify-between mb-6">
                    <div><h4 class="text-xl font-bold text-gray-900">#${d.order_number}</h4><p class="text-sm text-gray-500">${d.created_at}</p></div>
                    <span class="badge ${d.status_badge}">${d.status}</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                    <div><p class="text-gray-400 text-xs">Pelanggan</p><p class="font-medium">${d.customer}</p></div>
                    <div><p class="text-gray-400 text-xs">Campus ID</p><p class="font-medium">${d.campus_id}</p></div>
                    <div><p class="text-gray-400 text-xs">E-mel</p><p class="font-medium">${d.email}</p></div>
                    <div><p class="text-gray-400 text-xs">Telefon</p><p class="font-medium">${d.phone || '-'}</p></div>
                    <div><p class="text-gray-400 text-xs">Kaedah Bayaran</p><p class="font-medium">${d.payment_method}</p></div>
                    <div><p class="text-gray-400 text-xs">WhatsApp</p><p class="font-medium">${d.whatsapp_sent ? '✅ Terhantar' : '❌ Belum'}</p></div>
                </div>
                <div><p class="text-gray-400 text-xs mb-1">Alamat</p><p class="text-sm text-gray-700">${d.address}</p></div>
                <div class="mt-4 border-t border-gray-100 pt-4">
                    <p class="font-semibold text-sm text-gray-900 mb-2">Item Pesanan</p>
                    <div class="divide-y divide-gray-100">${itemsHtml}</div>
                    <div class="border-t border-gray-200 mt-3 pt-3 flex justify-between">
                        <span class="font-bold text-gray-900">Jumlah</span>
                        <span class="text-lg font-bold text-primary-600">RM ${d.total}</span>
                    </div>
                </div>
            `;
        });
}
</script>
@endsection
