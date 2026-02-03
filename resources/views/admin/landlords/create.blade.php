@extends('layouts.admin')

@section('title', 'Nuovo Landlord')

@section('content_header')
    <h1>Nuovo Landlord</h1>
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
<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.landlords.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Nome</label>
                    <input type="text" name="first_name" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Cognome</label>
                    <input type="text" name="last_name" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <button class="btn btn-primary">Crea Landlord</button>

        </form>

    </div>
</div>

@stop
