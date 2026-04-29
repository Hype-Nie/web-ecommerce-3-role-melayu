@extends('layouts.seller')
@section('title', 'Papan Pemuka')
@section('page_title', 'Papan Pemuka Penjual')
@section('page_subtitle', 'Ringkasan prestasi kedai anda')

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php $stats = [
        ['label'=>'Jumlah Produk','value'=>$totalProducts,'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4','color'=>'from-primary-500 to-primary-600'],
        ['label'=>'Pesanan Baru','value'=>$newOrders,'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','color'=>'from-blue-500 to-blue-600'],
        ['label'=>'Pendapatan Bulan Ini','value'=>number_format($monthlyRevenue, 2),'prefix'=>'RM ','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'from-violet-500 to-purple-600'],
        ['label'=>'Stok Rendah','value'=>$lowStock,'icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z','color'=>'from-amber-500 to-orange-500'],
    ]; @endphp
    @foreach($stats as $i => $s)
    <div class="stat-card animate-fade-in-up" style="animation-delay:{{ $i*0.1 }}s">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center mb-4"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/></svg></div>
        <p class="text-2xl font-bold text-gray-900">{{ $s['prefix'] ?? '' }}{{ $s['value'] }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>
{{-- Chart Section --}}
<div class="bg-white rounded-2xl border border-gray-100 mb-8 animate-fade-in p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-900">Jualan 7 Hari Terakhir</h3>
    </div>
    <div class="relative h-72">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100"><h3 class="font-bold text-gray-900">Pesanan Terbaru</h3></div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $o)
                <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('seller.transactions') }}'">
                    <td class="font-semibold">#{{ $o->order_number }}</td>
                    <td>{{ $o->user->name }}</td>
                    <td class="font-semibold">RM {{ number_format($o->total, 2) }}</td>
                    <td><span class="badge {{ $o->statusBadge() }}">{{ $o->statusLabel() }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-gray-400 py-8">Tiada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(139, 92, 246, 0.2)'); // violet-500
    gradient.addColorStop(1, 'rgba(139, 92, 246, 0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jualan (RM)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#8b5cf6', // violet-500
                backgroundColor: gradient,
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#8b5cf6',
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
</script>
@endsection
