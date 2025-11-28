@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Information</h1>

    <x-admin.information-table :informations="$informations" />

    <x-admin.information-modal-add />

    @foreach ($informations as $information)
        <x-admin.information-modal-view :information="$information" />
        <x-admin.information-modal-edit :information="$information" />
        <x-admin.information-modal-delete :information="$information" />
    @endforeach
@endsection