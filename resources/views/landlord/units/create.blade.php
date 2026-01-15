{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    Aggiungi unità a {{ $property->name }}
</h1>

<form method="POST" action="{{ route('landlord.units.store', $property) }}" class="space-y-4">
    @csrf

    <input type="text" name="name" placeholder="Nome unità" class="w-full p-2 border rounded">

    <input type="number" name="floor" placeholder="Piano" class="w-full p-2 border rounded">

    <input type="number" name="size" placeholder="Dimensione (m²)" class="w-full p-2 border rounded">

    <input type="number" step="0.01" name="monthly_rent" placeholder="Affitto mensile (€)" class="w-full p-2 border rounded">

    <select name="status" class="w-full p-2 border rounded">
        <option value="available">Disponibile</option>
        <option value="occupied">Occupata</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Crea unità</button>
</form>
@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Aggiungi unità')

@section('content_header')
    <h1>Aggiungi unità a {{ $property->name }}</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-building"></i> Nuova unità
        </h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.units.store', $property) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label font-weight-bold">Nome unità</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Nome unità">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Piano</label>
                <input type="number"
                       name="floor"
                       class="form-control"
                       placeholder="Piano">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Dimensione (m²)</label>
                <input type="number"
                       name="size"
                       class="form-control"
                       placeholder="Dimensione in metri quadrati">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Affitto mensile (€)</label>
                <input type="number"
                       step="0.01"
                       name="monthly_rent"
                       class="form-control"
                       placeholder="Affitto mensile">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Stato</label>
                <select name="status" class="form-control">
                    <option value="available">Disponibile</option>
                    <option value="occupied">Occupata</option>
                </select>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Crea unità
            </button>

        </form>

    </div>
</div>

@stop
