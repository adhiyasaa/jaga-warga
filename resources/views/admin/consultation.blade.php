@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Consultation</h1>

    <x-admin.consultation-table :consultations="$consultations" />

    @foreach ($consultations as $consultation)
        <x-admin.consultation-modal-view :consultation="$consultation" />
        <x-admin.consultation-modal-delete :consultation="$consultation" />
    @endforeach
@endsection