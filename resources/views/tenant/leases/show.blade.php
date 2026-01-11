@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dettaglio contratto</h1>

<div class="bg-white p-6 shadow rounded space-y-4">
    <p><strong>Proprietà:</strong> {{ $lease->unit->property->name }}</p>
    <p><strong>Unità:</strong> {{ $lease->unit->name }}</p>
    <p><strong>Inizio:</strong> {{ $lease->start_date->format('d/m/Y') }}</p>
    <p><strong>Fine:</strong> {{ optional($lease->end_date)->format('d/m/Y') }}</p>
    <p><strong>Affitto:</strong> € {{ number_format($lease->rent_amount, 2, ',', '.') }}</p>
    <p><strong>Deposito:</strong> € {{ number_format($lease->deposit_amount, 2, ',', '.') }}</p>

    @if($lease->signature_path)
        <p><strong>Firma inquilino:</strong></p>
        <img src="{{ asset('storage/' . $lease->signature_path) }}" width="200">
    @endif

    <a href="{{ route('tenant.leases.pdf', $lease) }}"
   class="bg-gray-700 text-white px-3 py-1 rounded"
   target="_blank">
    Scarica PDF
</a>
</div>

<a href="{{ route('tenant.leases.index') }}" class="text-blue-600 mt-4 inline-block">
    ← Torna ai contratti
</a>
@endsection
