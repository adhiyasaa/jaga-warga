@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Information</h1>

    {{-- 1. Komponen Tabel Utama (sudah termasuk tombol 'Add') --}}
    <x-admin.information-table :informations="$informations" />

    {{-- 2. Modal untuk Tambah Data --}}
    <x-admin.information-modal-add />

    {{-- 3. Loop Modal untuk View, Edit, dan Delete --}}
    @foreach ($informations as $information)
        <x-admin.information-modal-view :information="$information" />
        <x-admin.information-modal-edit :information="$information" />
        <x-admin.information-modal-delete :information="$information" />
    @endforeach
@endsection