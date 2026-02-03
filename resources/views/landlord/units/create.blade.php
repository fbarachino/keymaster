@extends('adminlte::page')

@section('title', 'Aggiungi unità')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Aggiungi unità a {{ $property->name }}</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('landlord.units.store', $property) }}" method="POST">
                @csrf

                @include('landlord.units.partials.form')

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Salva unità
                </button>

                <a href="{{ route('landlord.units.index', $property) }}" class="btn btn-secondary mt-3">
                    Annulla
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
