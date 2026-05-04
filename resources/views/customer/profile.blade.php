@extends('layouts.customer')
@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Kemaskini maklumat peribadi dan kata laluan')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-danger-50 border border-danger-100 text-danger-700 text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 animate-fade-in">
        <h3 class="font-bold text-gray-900 mb-6">Maklumat Peribadi</h3>
        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">@csrf @method('PUT')
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama</label><input type="text" name="name" value="{{ $user->name }}" class="input-styled" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">E-mel</label><input type="email" name="email" value="{{ $user->email }}" class="input-styled" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">No. Telefon</label><input type="tel" name="phone" value="{{ $user->phone }}" class="input-styled"></div>
            <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan Perubahan</button>
        </form>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 animate-fade-in-right">
        <h3 class="font-bold text-gray-900 mb-6">Tukar Kata Laluan</h3>
        <form action="{{ route('customer.profile.password') }}" method="POST" class="space-y-4">@csrf @method('PUT')
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan Semasa</label><input type="password" name="current_password" class="input-styled" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan Baru</label><input type="password" name="password" class="input-styled" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Sahkan Kata Laluan Baru</label><input type="password" name="password_confirmation" class="input-styled" required></div>
            <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Tukar Kata Laluan</button>
        </form>
    </div>
</div>
@endsection
