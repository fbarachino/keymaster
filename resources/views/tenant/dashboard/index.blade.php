@extends('layouts.admin')

@section('title', 'Dashboard Inquilino')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Benvenuto, {{ $tenant->name }}</h1>

    {{-- ========================= --}}
    {{-- KPI TOP ROW --}}
    {{-- ========================= --}}
    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalPaid, 2, ',', '.') }} €</h3>
                    <p>Totale pagato</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($totalDue, 2, ',', '.') }} €</h3>
                    <p>Da pagare</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $latePaymentsCount }}</h3>
                    <p>Pagamenti in ritardo</p>
                </div>
                <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $nextPayment ? $nextPayment->due_date : '-' }}</h3>
                    <p>Prossima scadenza</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            </div>
        </div>

    </div>

    {{-- ========================= --}}
    {{-- GRAFICO PAGAMENTI --}}
    {{-- ========================= --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Pagamenti ultimi 12 mesi</h3>
        </div>
        <div class="card-body">
            <canvas id="paymentsChart" height="120"></canvas>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- GRAFICO SPESE --}}
    {{-- ========================= --}}
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Ripartizione spese</h3>
        </div>
        <div class="card-body">
            <canvas id="expensesChart" height="120"></canvas>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TIMELINE PAGAMENTI --}}
    {{-- ========================= --}}
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Timeline pagamenti</h3>
        </div>
        <div class="card-body">

            <ul class="timeline">

                @foreach ($timelinePayments as $p)
                    <li class="time-label">
                        <span class="bg-{{ $p->status == 'paid' ? 'success' : ($p->due_date < now() ? 'danger' : 'warning') }}">
                            {{ $p->due_date }}
                        </span>
                    </li>

                    <li>
                        <i class="fas fa-receipt bg-{{ $p->status == 'paid' ? 'success' : 'warning' }}"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-euro-sign"></i>
                                {{ number_format($p->amount_total, 2, ',', '.') }}
                            </span>
                            <h3 class="timeline-header">
                                {{ ucfirst($p->status) }}
                            </h3>
                        </div>
                    </li>
                @endforeach

            </ul>

        </div>
    </div>

    {{-- ========================= --}}
    {{-- PDF & DOCUMENTI --}}
    {{-- ========================= --}}
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">Documenti</h3>
        </div>
        <div class="card-body">

            <a href="{{ route('tenant.yearly-reports.index') }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Report annuali
            </a>

            @if($lease)
                <a href="{{ route('tenant.leases.pdf', $lease->id) }}" class="btn btn-secondary">
                    <i class="fas fa-file-contract"></i> Contratto PDF
                </a>
            @endif

        </div>
    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // PAGAMENTI ULTIMI 12 MESI
    new Chart(document.getElementById('paymentsChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Pagato',
                data: @json($paymentsPerMonth),
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // RIPARTIZIONE SPESE
    new Chart(document.getElementById('expensesChart'), {
        type: 'pie',
        data: {
            labels: @json($expenseCategories),
            datasets: [{
                data: @json($expenseData),
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d'
                ]
            }]
        }
    });
</script>
@endpush
