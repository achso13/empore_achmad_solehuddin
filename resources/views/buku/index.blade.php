@extends('layouts.app')

@section('content_header')
    <h1>Kelola Buku</h1>
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
                <h5 class="align-middle m-0">Data Buku</h5>
                @auth('admin')
                    <a class="btn btn-primary" href={{ route('buku.create') }}>Tambah</a>
                @endauth
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

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", ".btn-delete", function() {
                const id = $(this).data("id");


                if (confirm("Hapus data?")) {
                    $.ajax({
                        url: `/api/books/${id}`,
                        method: "DELETE",
                        success: (response) => {
                            var url =
                                "{{ route('buku.index') }}";
                            $(location).attr('href', url);
                        },
                    })
                }
            });
        });
    </script>
@endsection
