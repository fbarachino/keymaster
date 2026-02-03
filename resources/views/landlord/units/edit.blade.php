@extends('layouts.admin')

@section('title', 'Modifica unità')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Modifica unità di {{ $property->name }}</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('landlord.units.update', [$property, $unit]) }}" method="POST">
                @csrf
                @method('PUT')

                @include('landlord.units.partials.form', ['unit' => $unit])

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Aggiorna unità
                </button>

                <a href="{{ route('landlord.units.index', $property) }}" class="btn btn-secondary mt-3">
                    Annulla
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
