@extends('layouts.app')

@section('content_header')
    <h1>Pengajuan Peminjaman</h1>
@stop

@section('content')
    <div class="card mt-2">
        <div class="card-header">
            Form Pengajuan Peminjaman
        </div>

        <form action={{ route('pengajuan.store', $buku['id']) }} method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-adminlte-input name="judul_buku" label="Judul Buku" value="{{ $buku['judul_buku'] }}"
                        fgroup-class="col-md-6" disabled />
                    <x-adminlte-input name="penulis" label="Penulis" value="{{ $buku['penulis'] }}" fgroup-class="col-md-6"
                        disabled />
                </div>
                <div class="row">
                    <x-adminlte-input name="tahun_terbit" label="Tahun Terbit" value="{{ $buku['tahun_terbit'] }}"
                        fgroup-class="col-md-6" disabled />
                    <x-adminlte-input name="stok" label="Stok" value="{{ $buku['stok'] }}" fgroup-class="col-md-6"
                        disabled />
                </div>

                <div class="row">
                    @php
                        $config = [
                            'format' => 'YYYY-MM-DD',
                            'minDate' => 'js:moment()',
                        ];
                    @endphp
                    <x-adminlte-input-date name="tanggal_peminjaman" :config="$config" placeholder="tanggal peminjaman buku"
                        label="Tanggal Peminjaman" fgroup-class="col-md-6" enable-old-support
                        error-key="tanggal_peminjaman">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-input-date name="tanggal_pengembalian" :config="$config"
                        placeholder="tanggal pengembalian buku" label="Tanggal Pengembalian" fgroup-class="col-md-6"
                        enable-old-support error-key="tanggal_peminjaman">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
            </div>

            <div class="card-footer">
                <x-adminlte-button label="Submit" type="submit" class="float-right" theme="primary" />
            </div>
        </form>
    </div>

@endsection
