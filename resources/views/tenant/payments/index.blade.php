@extends('adminlte::page')

@section('title', 'I tuoi pagamenti')

@section('content_header')
    <h1>I tuoi pagamenti</h1>
@stop

@section('content')
<div class="card card-dark mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-credit-card"></i> Andamento dei tuoi pagamenti
        </h3>
    </div>
    <div class="card-body">
        <canvas id="tenantPaymentsChart" height="100"></canvas>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
<h3>I tuoi pagamenti</h3>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Quota</th>
            <th>Pagato</th>
            <th>Stato</th>
            <th>Scadenza</th>
            <th>PDF</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
            <td>€ {{ number_format($payment->amount_due, 2, ',', '.') }}</td>
            <td>€ {{ number_format($payment->amount_paid, 2, ',', '.') }}</td>
            <td>
                <span class="badge badge-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'overdue' ? 'danger' : 'warning') }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </td>
            <td>{{ $payment->due_date->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('tenant.payments.pdf', $payment) }}" class="btn btn-sm btn-outline-primary">
                    PDF
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx2 = document.getElementById('tenantPaymentsChart').getContext('2d');

new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [
            {
                label: 'Dovuto',
                data: @json($chartDue),
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            },
            {
                label: 'Pagato',
                data: @json($chartPaid),
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@stop
