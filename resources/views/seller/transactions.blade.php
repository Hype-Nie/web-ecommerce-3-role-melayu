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
                <tr>
                    <td class="font-semibold">#{{ $o->order_number }}</td>
                    <td>{{ $o->user->name }}</td>
                    <td class="font-semibold">RM {{ number_format($o->total, 2) }}</td>
                    <td class="text-gray-500">{{ $o->created_at->format('d M Y') }}</td>
                    <td><span class="badge {{ $o->statusBadge() }}">{{ $o->statusLabel() }}</span></td>
                    <td>
                        @if($o->status === 'pending')
                        <form action="{{ route('seller.transactions.status', $o) }}" method="POST">@csrf @method('PATCH')
                            <input type="hidden" name="status" value="processing">
                            <button class="px-3 py-1.5 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold hover:bg-primary-100">Proses</button>
                        </form>
                        @elseif($o->status === 'processing')
                        <form action="{{ route('seller.transactions.status', $o) }}" method="POST">@csrf @method('PATCH')
                            <input type="hidden" name="status" value="shipped">
                            <button class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-100">Hantar</button>
                        </form>
                        @else
                        <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-8">Tiada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
