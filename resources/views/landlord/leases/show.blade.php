@extends('adminlte::page')

@section('title', 'Dettaglio contratto')

@section('content_header')
    <h1>Dettaglio contratto</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-contract"></i> Informazioni contratto
        </h3>
    </div>
            <form method="POST" action="{{ route('landlord.tenants.detach', [$lease, $tenant]) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    <i class="fas fa-user-minus"></i> Rimuovi
                </button>
            </form>

    <div class="card-body">

        <div class="mb-3">
            <strong>Unità:</strong> {{ $lease->unit->name }}
        </div>

        <div class="mb-3">
            <strong>Proprietà:</strong> {{ $lease->unit->property->name }}
        </div>

        <div class="mb-3">
            <strong>Inquilino:</strong> {{ $lease->tenant->name }}
        </div>

        <div class="mb-3">
            <strong>Data inizio:</strong> {{ $lease->start_date->format('d/m/Y') }}
        </div>

        <div class="mb-3">
            <strong>Data fine:</strong> {{ optional($lease->end_date)->format('d/m/Y') }}
        </div>

        <div class="mb-3">
            <strong>Affitto mensile:</strong>
            € {{ number_format($lease->rent_amount, 2, ',', '.') }}
        </div>

        <div class="mb-3">
            <strong>Deposito cauzionale:</strong>
            € {{ number_format($lease->deposit_amount, 2, ',', '.') }}
        </div>

        <div class="mt-4">
            <a href="{{ route('landlord.leases.pdf', $lease) }}"
               class="btn btn-secondary"
               target="_blank">
                <i class="fas fa-file-pdf"></i> Scarica PDF
            </a>
            <a href="{{ route('leases.contract.3plus2', $lease) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-file-pdf"></i> Contratto 3+2 (PDF)
            </a>

            @if(!$lease->signed_by_landlord_at)
                <form method="POST"
                      action="{{ route('landlord.leases.sign', $lease) }}"
                      class="d-inline">
                    @csrf
                    <button class="btn btn-primary">
                        <i class="fas fa-pen-nib"></i> Firma come locatore
                    </button>
                </form>
            @else
                <span class="badge badge-success ml-2">
                    Firmato dal locatore il {{ $lease->signed_by_landlord_at->format('d/m/Y') }}
                </span>
            @endif
        </div>

    </div>
</div>

<a href="{{ route('landlord.leases.index', $lease->property_id) }}" class="btn btn-link pl-0">
    <i class="fas fa-arrow-left"></i> Torna ai contratti
</a>

@stop
