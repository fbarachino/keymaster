@extends('layouts.admin')

@section('title', 'Dettaglio Pagamento')

@section('content_header')
    <h1>Dettaglio Pagamento</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        {{-- Tipo pagamento --}}
        <div class="mb-3">
            <strong>Tipo:</strong>
            @php
                $colors = [
                    'rent' => 'badge-primary',
                    'deposit' => 'badge-warning',
                    'expense' => 'badge-info',
                    'other' => 'badge-secondary',
                ];
            @endphp

            <span class="badge {{ $colors[$payment->type] ?? 'badge-secondary' }}">
                {{ ucfirst($payment->type) }}
            </span>
        </div>

        {{-- Importo --}}
        <div class="mb-3">
            <strong>Importo:</strong>
            € {{ number_format($payment->amount, 2) }}
        </div>

        {{-- Scadenza --}}
        <div class="mb-3">
            <strong>Data scadenza:</strong>
            {{ $payment->due_date }}
        </div>

        {{-- Stato --}}
        <div class="mb-3">
            <strong>Stato:</strong>
            @if($payment->status === 'paid')
                <span class="badge badge-success">Pagato</span>
            @else
                <span class="badge badge-danger">Non pagato</span>
            @endif
        </div>

        {{-- Data pagamento --}}
        @if($payment->paid_date)
            <div class="mb-3">
                <strong>Data pagamento:</strong>
                {{ $payment->paid_date }}
            </div>
        @endif

        {{-- Riferimento --}}
        <div class="mb-3">
            <strong>Riferimento:</strong>
            {{ $payment->reference ?? '-' }}
        </div>

        {{-- Note --}}
        <div class="mb-3">
            <strong>Note:</strong>
            {{ $payment->notes ?? '-' }}
        </div>

        {{-- Ricevuta --}}
        @if($payment->status === 'paid')
            <div class="mt-4">
                <a href="{{ route('tenant.payments.receipt', $payment) }}"
                   class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Scarica ricevuta
                </a>
            </div>
        @endif

    </div>

    <div class="card-footer">
        <a href="{{ route('tenant.payments.index') }}" class="btn btn-secondary">
            Torna ai pagamenti
        </a>
    </div>
</div>

@stop
