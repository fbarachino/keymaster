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
            <strong>Inquilino:</strong> @foreach($lease->tenants as $tenant)
    <li>{{ $tenant->name }} ({{ $tenant->email }})</li>
@endforeach

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
<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i> Andamento Pagamenti
        </h3>
    </div>
    <div class="card-body">
       <h3>Andamento Pagamenti</h3>

    </div>
    <div class="card-body">
        <canvas id="paymentsChart" width="400" height="200"></canvas>
    </div>
</div>
<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-invoice-dollar"></i> Totali Lease

        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Tipo</th>
                    <th>Affitto</th>
                    <th>Anticipo</th>
                    <th>Spese</th>
                    <th>Conguaglio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totals as $total)
                <tr>
                    <td>{{ $total->period }}</td>
                    <td>{{ ucfirst($total->period_type) }}</td>
                    <td>€ {{ number_format($total->rent_total, 2, ',', '.') }}</td>
                    <td>€ {{ number_format($total->advance_total, 2, ',', '.') }}</td>
                    <td>€ {{ number_format($total->expenses_total, 2, ',', '.') }}</td>
                    <td>€ {{ number_format($total->settlement_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-receipt"></i> Pagamenti individuali
        </h3>
    </div>
    <div class="card-body">

   <table class="table table-striped">
    <thead>
        <tr>
            <th>Tenant</th>
            <th>Tipo</th>
            <th>Quota</th>
            <th>Pagato</th>
            <th>Stato</th>
            <th>Scadenza</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lease->payments as $payment)
        <tr>
            <td>{{ $payment->tenant->name }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
            <td>€ {{ number_format($payment->amount_due, 2, ',', '.') }}</td>
            <td>€ {{ number_format($payment->amount_paid, 2, ',', '.') }}</td>
            <td>
                <span class="badge badge-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'overdue' ? 'danger' : 'warning') }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </td>
            <td>{{ $payment->due_date->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>
<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-pdf"></i> PDF Mensili
        </h3>
    </div>
    <div class="card-body">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>Tipo</th>
                <th>Scarica PDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totals->where('period_type', 'monthly') as $total)
            <tr>
                <td>{{ $total->period }}</td>
                <td>{{ ucfirst($total->period_type) }}</td>
                <td>
                    <a href="{{ route('landlord.lease.monthly.pdf', [$lease->id, $total->period]) }}" class="btn btn-sm btn-outline-primary">
                        PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
<div class="card card-dark mb-4">
    <div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-file-pdf"></i> PDF Mensili
    </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Affitto</th>
                    <th>Anticipo Spese</th>
                    <th>Totale</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyTotals as $total)
                <tr>
                    <td>{{ $total->period }}</td>
                    <td>€ {{ number_format($total->rent_total, 2, ',', '.') }}</td>
                    <td>€ {{ number_format($total->advance_total, 2, ',', '.') }}</td>
                    <td>€ {{ number_format($total->rent_total + $total->advance_total, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('landlord.lease.monthly.pdf', [$lease->id, $total->period]) }}"
                        class="btn btn-sm btn-outline-primary">
                            Scarica PDF
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card card-dark mb-4">
    <div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-file-pdf"></i> PDF Annuali
    </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Anno</th>
                    <th>Spese Inquilino</th>
                    <th>Conguaglio</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($yearlyTotals as $total)
                <tr>
                    <td>{{ $total->period }}</td>
                    <td>€ {{ number_format($total->expenses_total, 2, ',', '.') }}</td>
                    <td>€ {{ number_format($total->settlement_total, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('landlord.lease.yearly.pdf', [$lease->id, $total->period]) }}"
                        class="btn btn-sm btn-outline-primary">
                            Scarica PDF
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<a href="{{ route('landlord.leases.index') }}" class="btn btn-link pl-0">
    <i class="fas fa-arrow-left"></i> Torna ai contratti
</a>

@stop

@section('js')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('paymentsChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [
            {
                label: 'Dovuto',
                data: @json($chartDue),
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Pagato',
                data: @json($chartPaid),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }
        ]
    },
    options: {
        responsive: true,
        tension: 0.3
    }
});
</script>
@stop
