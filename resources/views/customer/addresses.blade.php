@extends('layouts.customer')
@section('title', 'Alamat Saya')
@section('page_title', 'Alamat Saya')
@section('page_subtitle', 'Urus alamat penghantaran anda')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="flex justify-end mb-6">
    <button data-modal-open="modal-add-addr" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Alamat
    </button>
</div>
<div class="grid sm:grid-cols-2 gap-6">
    @foreach($addresses as $a)
    <div class="bg-white rounded-2xl border {{ $a->is_default ? 'border-primary-300 ring-2 ring-primary-100' : 'border-gray-100' }} p-6 card-hover animate-fade-in-up relative">
        @if($a->is_default)<span class="absolute top-4 right-4 badge badge-success">Utama</span>@endif
        <div class="flex items-center gap-2 mb-3"><svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg><span class="font-semibold text-gray-900">{{ $a->label }}</span></div>
        <p class="font-medium text-gray-800 text-sm">{{ $a->recipient_name }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $a->phone }}</p>
        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $a->fullDisplay() }}</p>
        <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
            @if(!$a->is_default)
            <form action="{{ route('customer.addresses.default', $a) }}" method="POST">@csrf @method('PATCH')<button class="text-sm text-primary-600 font-semibold hover:text-primary-700">Tetapkan Utama</button></form>
            <span class="text-gray-300">·</span>
            <form action="{{ route('customer.addresses.destroy', $a) }}" method="POST" onsubmit="return confirm('Padam?')">@csrf @method('DELETE')<button class="text-sm text-danger-600 font-semibold hover:text-danger-700">Padam</button></form>
            @else
            <span class="text-sm text-gray-400">Alamat utama</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
<div id="modal-add-addr" class="modal-overlay">
    <div class="modal-content max-w-lg">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Alamat Baru</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('customer.addresses.store') }}" method="POST">@csrf
            <div class="p-6 space-y-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Label</label><input type="text" name="label" class="input-styled" placeholder="cth: Rumah" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label><input type="text" name="recipient_name" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label><input type="tel" name="phone" class="input-styled" required></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Alamat Penuh</label><textarea name="full_address" class="input-styled" rows="2" required></textarea></div>
                <div class="grid grid-cols-3 gap-3">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Bandar</label><input type="text" name="city" class="input-styled"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Poskod</label><input type="text" name="postcode" class="input-styled"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Negeri</label><input type="text" name="state" class="input-styled"></div>
                </div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_default" value="1" class="w-4 h-4 rounded border-gray-300 text-primary-600"><span class="text-sm text-gray-700">Tetapkan sebagai alamat utama</span></label></div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
