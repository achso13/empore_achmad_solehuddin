@extends('layouts.app')

@section('content')
    <div class="container pt-3">
        @if (session('success'))
            <x-adminlte-alert theme="success" title="Success">
                {{ session('success') }}
            </x-adminlte-alert>
        @endif

        @if (session('failed'))
            <x-adminlte-alert theme="danger" title="Failed">
                {{ session('failed') }}
            </x-adminlte-alert>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="align-middle m-0">Data Peminjaman</h5>
                </div>
            </div>

            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
