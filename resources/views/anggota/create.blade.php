@extends('layouts.app')

@section('content_header')
    <h1>Tambah Anggota</h1>
@stop

@section('content')
    <div class="card mt-2">
        <div class="card-header">
            Form Tambah Anggota
        </div>

        <form action={{ route('anggota.store') }} method="post">
            @csrf
            <div class="card-body">

                <div class="row">
                    <x-adminlte-input name="name" label="Nama Anggota" placeholder="nama anggota" error-key="name"
                        enable-old-support fgroup-class="col-md-6" />

                    <x-adminlte-input name="email" type="email" label="Email" placeholder="mail@example.com"
                        error-key="email" enable-old-support fgroup-class="col-md-6" />
                </div>

                <div class="row">
                    <x-adminlte-input name="password" type="password" label="Password" placeholder="password"
                        error-key="password" enable-old-support fgroup-class="col-md-6" />
                </div>
            </div>
            <div class="card-footer">
                <x-adminlte-button label="Submit" type="submit" class="float-right" theme="primary" />
            </div>
        </form>
    </div>
@endsection
