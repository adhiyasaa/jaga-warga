@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Report History</h1>

    <x-admin.report-table :reports="$reports" />

    @foreach ($reports as $report)
        <x-admin.report-modal-view :report="$report" />
        <x-admin.report-modal-delete :report="$report" />
    @endforeach
@endsection