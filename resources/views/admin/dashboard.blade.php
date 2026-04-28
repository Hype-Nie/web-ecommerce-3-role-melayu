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

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100"><h3 class="font-bold text-gray-900">Pesanan Terbaru</h3></div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Status</th><th>Tarikh</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $o)
                <tr>
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
@endsection
