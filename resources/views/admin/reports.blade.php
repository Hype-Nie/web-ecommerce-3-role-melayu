@extends('layouts.admin')
@section('title', 'Laporan Transaksi')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Analisis dan laporan jualan')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6 animate-fade-in">
    <form method="GET" class="flex flex-wrap items-end gap-4">
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Dari Tarikh</label><input type="date" name="from" value="{{ request('from') }}" class="input-styled !py-2"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Hingga Tarikh</label><input type="date" name="to" value="{{ request('to') }}" class="input-styled !py-2"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="input-styled !py-2"><option value="all">Semua</option><option value="completed" {{ request('status')=='completed'?'selected':'' }}>Selesai</option><option value="processing" {{ request('status')=='processing'?'selected':'' }}>Diproses</option><option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Dibatalkan</option></select>
        </div>
        <button type="submit" class="btn-primary text-sm !px-5 !py-2.5">Tapis</button>
        <a href="{{ route('admin.reports.export', request()->only('from', 'to', 'status')) }}" class="btn-ghost text-sm !px-5 !py-2.5 inline-flex items-center gap-2 border border-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Eksport CSV
        </a>
    </form>
</div>
<div class="grid sm:grid-cols-3 gap-6 mb-6">
    <div class="stat-card animate-fade-in-up"><p class="text-sm text-gray-500 mb-1">Jumlah Transaksi</p><p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p></div>
    <div class="stat-card animate-fade-in-up delay-100"><p class="text-sm text-gray-500 mb-1">Jumlah Pendapatan</p><p class="text-2xl font-bold text-primary-600">RM {{ number_format($totalRevenue, 2) }}</p></div>
    <div class="stat-card animate-fade-in-up delay-200"><p class="text-sm text-gray-500 mb-1">Purata Pesanan</p><p class="text-2xl font-bold text-gray-900">RM {{ number_format($avgOrder, 2) }}</p></div>
</div>
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Tarikh</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($orders as $o)
                <tr>
                    <td class="font-semibold">#{{ $o->order_number }}</td>
                    <td>{{ $o->user->name }}</td>
                    <td class="font-semibold">RM {{ number_format($o->total, 2) }}</td>
                    <td class="text-gray-500">{{ $o->created_at->format('d M Y') }}</td>
                    <td><span class="badge {{ $o->statusBadge() }}">{{ $o->statusLabel() }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-8">Tiada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
