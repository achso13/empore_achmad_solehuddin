@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="card">
            <div class="card-header">
                Edit Buku
            </div>

            <div class="card-body">
                <form action={{ route('books.update', $buku['id']) }} method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        <x-adminlte-input name="judul_buku" label="Judul Buku" placeholder="judul buku" error-key="judul_buku"
                            fgroup-class="col-md-6" value="{{ $buku['judul_buku'] }}" />

                        <x-adminlte-input name="penulis" label="Penulis" placeholder="penulis buku" error-key="penulis"
                            fgroup-class="col-md-6" value="{{ $buku['penulis'] }}" />
                    </div>

                    <div class="row">
                        @php
                            $config = ['format' => 'YYYY'];
                        @endphp
                        <x-adminlte-input-date name="tahun_terbit" :config="$config" placeholder="tahun terbit buku"
                            label="Tahun Terbit" fgroup-class="col-md-6" value="{{ $buku['tahun_terbit'] }}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>

                        <x-adminlte-input name="stok" type="number" label="Stok" placeholder="stok buku"
                            error-key="stok" fgroup-class="col-md-6" value="{{ $buku['stok'] }}" />
                    </div>

                    <x-adminlte-button label="Submit" type="submit" theme="primary" />
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: $(this).attr("action"),
                    method: "PUT",
                    data: {
                        judul_buku: formData.get("judul_buku"),
                        penulis: formData.get("penulis"),
                        tahun_terbit: formData.get("tahun_terbit"),
                        stok: formData.get("stok"),
                    },
                    success: (response) => {
                        var url =
                            "{{ route('buku.index') }}";
                        $(location).attr('href', url);
                    },
                    error: (error) => {
                        $('input').removeClass('is-invalid');
                        $('select').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $('.admin-lte-invalid-igroup').removeClass('admin-lte-invalid-igroup');
                        $('.invalid-feedback').remove();

                        $.each(error.responseJSON.error, function(key, value) {
                            $(`[name=${key}]`).addClass('is-invalid');
                            $(`[name=${key}]`).parent().addClass(
                                'adminlte-invalid-igroup');
                            $(`[name=${key}]`).parent().parent().append(
                                `<span class = "invalid-feedback d-block" role="alert"><strong>${value}</strong></span>`
                            );
                        });
                    }
                })
            })
        })
    </script>
@endsection
