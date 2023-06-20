@extends('layouts.app')

@section('content_header')
    <h1>Home</h1>
@stop

@section('content')
    <p>Selamat datang di Sistem Peminjaman Buku, <b>{{ Auth::guard()->user()->name }}</b></p>
@stop
