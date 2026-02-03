@extends('layouts.admin')

@section('title', 'Modifica Landlord')

@section('content_header')
    <h1>Modifica Landlord</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.landlords.update', $landlord) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Nome</label>
                    <input type="text" name="first_name" class="form-control"
                           value="{{ $landlord->first_name }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Cognome</label>
                    <input type="text" name="last_name" class="form-control"
                           value="{{ $landlord->last_name }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $landlord->email }}">
                </div>
            </div>

            <button class="btn btn-primary">Aggiorna</button>

        </form>

    </div>
</div>

@stop
