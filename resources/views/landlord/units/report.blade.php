@extends('layouts.admin')

@section('title', 'Dossier Unit')

@section('content_header')
    <h1>Dossier Unità: {{ $unit->name }}</h1>
@stop

@section('content')

<a href="{{ route('landlord.units.report.pdf', $unit) }}" class="btn btn-primary mb-3">
    <i class="fas fa-file-pdf"></i> Esporta PDF
</a>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Informazioni Unità</h5>
    </div>
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 60px;">
        <h2 class="ml-3 mb-0">Dossier Unità: {{ $unit->name }}</h2>
    </div>

    <div class="card-body">
        <p><strong>Proprietà:</strong> {{ $unit->property->name }}</p>
        <p><strong>Indirizzo:</strong> {{ $unit->property->address }}</p>
        <p><strong>Piano:</strong> {{ $unit->floor }}</p>
        <p><strong>Codice interno:</strong> {{ $unit->internal_code }}</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Inquilini Attuali</h5>
    </div>
    <div class="card-body">
        @foreach($unit->leases as $lease)
            @foreach($lease->tenants as $tenant)
                <p>{{ $tenant->first_name }} {{ $tenant->last_name }} ({{ $tenant->email }})</p>
            @endforeach
        @endforeach
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Pagamenti</h5>
    </div>
    <div class="card-body">
        @foreach($unit->leases as $lease)
            @foreach($lease->payments as $payment)
                <p>
                    {{ $payment->date }} —
                    €{{ number_format($payment->amount, 2) }}
                    ({{ $payment->status }})
                </p>
            @endforeach
        @endforeach
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Spese</h5>
    </div>
    <div class="card-body">
        @foreach($unit->expenses as $expense)
            <p>
                {{ $expense->date }} —
                €{{ number_format($expense->amount, 2) }} —
                {{ $expense->description }}
            </p>
        @endforeach
    </div>
</div>


<canvas id="unitChart" height="120"></canvas>
<div class="row">
    @foreach($unit->inventory as $item)
        <p>{{ $item->item }} ({{ $item->condition }})</p>
    @endforeach
</div>

<div class="row">
    @foreach($unit->photos as $photo)
        <div class="col-md-3 mb-3">
            <img src="{{ asset('storage/'.$photo->path) }}" class="img-fluid rounded">
        </div>
    @endforeach
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('unitChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Incassi',
                    data: {!! json_encode($income) !!},
                    borderColor: 'green',
                    fill: false
                },
                {
                    label: 'Spese',
                    data: {!! json_encode($expenses) !!},
                    borderColor: 'red',
                    fill: false
                },
                {
                    label: 'Rendita',
                    data: {!! json_encode($profit) !!},
                    borderColor: 'blue',
                    fill: false
                }
            ]
        }
    });
</script>

@stop
