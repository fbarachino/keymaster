
@extends('adminlte::page')

@section('title', 'Aggiungi proprietà')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Aggiungi proprietà</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('landlord.properties.store') }}" method="POST">
                @csrf

                @include('landlord.properties.partials.form')

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Salva proprietà
                </button>

                <a href="{{ route('landlord.properties.index') }}" class="btn btn-secondary mt-3">
                    Annulla
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
