@extends('layouts.admin')

@section('title', 'I tuoi pagamenti')

@section('content_header')
    <h1>I tuoi pagamenti</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body p-0">
 <table class="table table-striped">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Importo</th>
            <th>Scadenza</th>
            <th>Stato</th>
            <th>Riferimento</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ dd($payments) }} --}}
        @forelse($payments as $payment)
            <tr>

                {{-- Tipo pagamento --}}
                <td>
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
                </td>

                {{-- Importo --}}
                <td>€ {{ number_format($payment->amount, 2) }}</td>

                {{-- Scadenza --}}
                <td>{{ $payment->due_date }}</td>

                {{-- Stato --}}
                <td>
                    @if($payment->status === 'paid')
                        <span class="badge badge-success">Pagato</span>
                    @else
                        <span class="badge badge-danger">Non pagato</span>
                    @endif
                </td>

                {{-- Riferimento --}}
                <td>{{ $payment->reference ?? '-' }}</td>

                {{-- Azioni --}}
                <td>

                    {{-- 🔍 Pulsante dettaglio --}}
                    <a href="{{ route('tenant.payments.show', $payment) }}"
                       class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>

                    {{-- 📄 Ricevuta (solo se pagato) --}}
                    @if($payment->status === 'paid')
                        <a href="{{ route('tenant.payments.receipt', $payment) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    @endif

                </td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Nessun pagamento registrato.</td>
            </tr>
        @endforelse

    </tbody>
</table>

    </div>
</div>

@stop
