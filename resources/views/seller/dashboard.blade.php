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
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100"><h3 class="font-bold text-gray-900">Pesanan Terbaru</h3></div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $o)
                <tr>
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
