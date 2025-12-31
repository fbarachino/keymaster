@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dettaglio contratto</h1>

<div class="bg-white shadow rounded p-6 space-y-4">

    <p><strong>Unità:</strong> {{ $lease->unit->name }}</p>
    <p><strong>Proprietà:</strong> {{ $lease->unit->property->name }}</p>
    <p><strong>Inquilino:</strong> {{ $lease->tenant->name }}</p>
    <p><strong>Data inizio:</strong> {{ $lease->start_date->format('d/m/Y') }}</p>
    <p><strong>Data fine:</strong> {{ optional($lease->end_date)->format('d/m/Y') }}</p>
    <p><strong>Affitto mensile:</strong> € {{ number_format($lease->rent_amount, 2, ',', '.') }}</p>
    <p><strong>Deposito:</strong> € {{ number_format($lease->deposit_amount, 2, ',', '.') }}</p>

</div>

<a href="{{ route('leases.index') }}" class="mt-4 inline-block text-blue-600">← Torna ai contratti</a>
@endsection
