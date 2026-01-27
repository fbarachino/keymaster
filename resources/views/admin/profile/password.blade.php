@extends('adminlte::page')

@section('title', 'Cambia Password')

@section('content_header')
    <h1>Cambia Password</h1>
@stop

@section('content')

@if(session('success'))
    <x-adminlte-alert theme="success" title="Successo">
        {{ session('success') }}
    </x-adminlte-alert>
@endif

@if($errors->any())
    <x-adminlte-alert theme="danger" title="Errore">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-adminlte-alert>
@endif

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf

            <div class="mb-3">
                <label>Password attuale</label>
                <input type="password" name="current_password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nuova password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Conferma nuova password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button class="btn btn-primary">Aggiorna Password</button>
        </form>

    </div>
</div>

@stop
