@extends('layouts.admin')

@section('title', $property->name)

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">{{ $property->name }}</h1>

        <a href="{{ route('landlord.units.index', $property) }}" class="btn btn-primary">
            <i class="fas fa-building"></i> Gestisci unità
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Dettagli proprietà</strong>
        </div>
        <div class="card-body">
            <p><strong>Indirizzo:</strong> {{ $property->address }}, {{ $property->city }}</p>
            <p><strong>Prezzo acquisto:</strong> {{ number_format($property->purchase_price, 2, ',', '.') }} €</p>
            <p><strong>Descrizione:</strong> {{ $property->description }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Unità immobiliari</strong>
        </div>
        <div class="card-body p-0">
            @include('landlord.units.index-table', ['units' => $property->units])
        </div>
    </div>

</div>
@endsection
