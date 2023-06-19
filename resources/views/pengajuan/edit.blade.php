@extends('layouts.app')

@section('content')
    <div class="container pt-3">
        <div class="card">
            <div class="card-header">
                Edit Anggota
            </div>

            <div class="card-body">
                <form action={{ route('anggota.update', $user['id']) }} method="post">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <x-adminlte-input name="name" label="Nama Anggota" placeholder="nama anggota" error-key="name"
                            enable-old-support value="{{ $user['name'] }}" fgroup-class="col-md-6" />

                        <x-adminlte-input name="email" type="email" label="Email" placeholder="mail@example.com"
                            error-key="email" enable-old-support value="{{ $user['email'] }}" fgroup-class="col-md-6" />
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
