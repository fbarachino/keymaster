{{-- @extends('layouts.portal')

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
    <a href="{{ route('landlord.leases.pdf', $lease) }}"
    class="bg-gray-700 text-white px-3 py-1 rounded"
    target="_blank">
        Scarica PDF
    </a>
    @if(!$lease->signed_by_landlord_at)
    <form method="POST" action="{{ route('landlord.leases.sign', $lease) }}" class="inline">
        @csrf
        <button class="btn-primary rounded">
            Firma come locatore
        </button>
    </form>
@else
    <span class="text-green-700 font-semibold">
        Firmato dal locatore il {{ $lease->signed_by_landlord_at->format('d/m/Y') }}
    </span>
@endif
</div>

<a href="{{ route('landlord.leases.index') }}" class="mt-4 inline-block text-blue-600">← Torna ai contratti</a>
@endsection
 --}}
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

<a href="{{ route('landlord.leases.index') }}" class="btn btn-link pl-0">
    <i class="fas fa-arrow-left"></i> Torna ai contratti
</a>

@stop
