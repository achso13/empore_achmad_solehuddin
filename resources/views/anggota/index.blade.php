@extends('layouts.app')

@section('content_header')
    <h1>Kelola Anggota</h1>
@stop

@section('content')
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

    <div class="card mt-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="align-middle m-0">Data Anggota</h5>
                <a class="btn btn-primary" href={{ route('anggota.create') }}>Tambah</a>
            </div>
        </div>

        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
