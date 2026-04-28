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
                <tr>
                    <td><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">{{ substr($c->name,0,1) }}</div><span class="font-medium text-gray-900">{{ $c->name }}</span></div></td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone ?? '-' }}</td>
                    <td>{{ $c->orders_count }}</td>
                    <td class="text-gray-500">{{ $c->created_at->format('d M Y') }}</td>
                    <td><span class="badge {{ $c->is_active ? 'badge-success' : 'badge-danger' }}">{{ $c->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    <td>
                        <form action="{{ route('admin.customers.destroy', $c) }}" method="POST" onsubmit="return confirm('Padam pelanggan ini?')">@csrf @method('DELETE')
                            <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-gray-400 py-8">Tiada pelanggan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
