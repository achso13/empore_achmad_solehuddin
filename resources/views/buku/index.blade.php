@extends('layouts.app')

@section('content')
    <div class="container pt-3">
        @if (session('success'))
            <x-adminlte-alert theme="success" title="Success">
                {{ session('success') }}
            </x-adminlte-alert>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="align-middle m-0">Kelola Buku</h5>
                    <a class="btn btn-primary" href={{ route('buku.create') }}>Tambah</a>
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
