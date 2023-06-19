@extends('layouts.app')

@section('content')
    <div class="container pt-3">
        <div class="card">
            <div class="card-header">
                Tambah Anggota
            </div>

            <div class="card-body">
                <form action={{ route('anggota.store') }} method="post">
                    @csrf

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

                    <x-adminlte-button label="Submit" type="submit" theme="primary" />
                </form>
            </div>
        </div>
    </div>
@endsection
