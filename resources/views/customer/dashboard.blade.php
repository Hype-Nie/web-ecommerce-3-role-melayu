@extends('layouts.customer')
@section('title', 'Papan Pemuka')
@section('page_title', 'Selamat Datang, ' . auth()->user()->name . '!')
@section('page_subtitle', 'Berikut adalah ringkasan akaun anda')

@section('content')
<div class="gradient-primary rounded-2xl p-6 lg:p-8 text-white mb-8 animate-fade-in relative overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-12 translate-x-12"></div>
    <h2 class="text-xl font-bold mb-2">Hai, {{ $user->name }}! 👋</h2>
    <p class="text-primary-100/80 text-sm mb-4">Anda mempunyai {{ $processingCount }} pesanan yang sedang diproses.</p>
    <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary-700 rounded-xl text-sm font-semibold hover:bg-primary-50 transition-all">Lihat Pesanan</a>
</div>
<div class="grid sm:grid-cols-3 gap-6 mb-8">
    <div class="stat-card animate-fade-in-up">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center mb-4"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p><p class="text-sm text-gray-500">Jumlah Pesanan</p>
    </div>
    <div class="stat-card animate-fade-in-up delay-100">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalAddresses }}</p><p class="text-sm text-gray-500">Alamat Tersimpan</p>
    </div>
    <div class="stat-card animate-fade-in-up delay-200">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center mb-4"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <p class="text-2xl font-bold text-gray-900">{{ $processingCount }}</p><p class="text-sm text-gray-500">Sedang Diproses</p>
    </div>
</div>
{{-- Chart Section --}}
<div class="bg-white rounded-2xl border border-gray-100 mb-8 animate-fade-in p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-900">Perbelanjaan 7 Hari Terakhir</h3>
    </div>
    <div class="relative h-72">
        <canvas id="spendingChart"></canvas>
    </div>
</div>
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-900">Pesanan Terbaru</h3>
        <a href="{{ route('customer.orders') }}" class="text-sm text-primary-600 font-semibold hover:text-primary-700">Lihat Semua</a>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($recentOrders as $o)
        <a href="{{ route('customer.order-detail', $o) }}" class="flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
            <div>
                <p class="font-semibold text-gray-900">#{{ $o->order_number }} · {{ $o->items->first()->product_name ?? '-' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $o->created_at->format('d M Y') }}</p>
            </div>
            <div class="text-right">
                <p class="font-semibold text-gray-900">RM {{ number_format($o->total, 2) }}</p>
                <span class="badge {{ $o->statusBadge() }} mt-1">{{ $o->statusLabel() }}</span>
            </div>
        </a>
        @empty
        <div class="p-8 text-center text-gray-400">Tiada pesanan</div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('spendingChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(245, 158, 11, 0.2)'); // amber-500
    gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Perbelanjaan (RM)',
                data: {!! json_encode($chartData) !!},
                backgroundColor: '#f59e0b', // amber-500
                borderRadius: 4,
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
