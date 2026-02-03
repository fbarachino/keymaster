@extends('layouts.admin')

@section('title', 'Modifica Tenant')

@section('content_header')
    <h1>Modifica Tenant</h1>
@stop

@section('content')

@if ($errors->any())
    <x-adminlte-alert theme="danger" title="Errore">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-adminlte-alert>
@endif

<div class="card card-dark">
    <div class="card-body">

        <form method="POST" action="{{ route('landlord.tenants.update', $tenant) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $tenant->email) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Nome</label>
                    <input type="text" name="first_name" class="form-control"
                           value="{{ old('first_name', $tenant->first_name) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Cognome</label>
                    <input type="text" name="last_name" class="form-control"
                           value="{{ old('last_name', $tenant->last_name) }}">
                </div>
            </div>

            <button class="btn btn-primary">Aggiorna</button>

        </form>

    </div>
</div>

@stop
