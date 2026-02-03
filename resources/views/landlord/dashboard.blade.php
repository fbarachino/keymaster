{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Proprietario</h1>
<div class="row">
        <div class="col-md-3">
        <x-adminlte-info-box title="Contratti Attivi" text="{{ $leases}}" icon="fas fa-lg fa-download" icon-theme="purple"/>
        </div>
</div>
<div class="row">

    <div class="col grid grid-cols-2 gap-6">

        <div class="bg-white p-6 shadow rounded">
            <h2 class="font-semibold mb-4">Entrate mensili</h2>
            <canvas id="paymentsChart"></canvas>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Spese mensili</h3>
    </div>
    <div class="card-body">
        <canvas id="expensesChart"></canvas>
    </div>
</div>


@endsection

@section('js')
<script>
    const ctx = document.getElementById('paymentsChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($payments->pluck('month')) !!},
            datasets: [{
                label: 'Entrate (€)',
                data: {!! json_encode($payments->pluck('total')) !!},
                backgroundColor: '#3b82f6'
            }]
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('expensesChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyExpenses->keys()) !!},
            datasets: [{
                label: 'Spese (€)',
                data: {!! json_encode($monthlyExpenses->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
            }]
        }
    });
</script>

@endsection
 --}}
 @extends('layouts.admin')

@section('title', 'Dashboard Proprietario')

@section('content_header')
    <h1>Dashboard Proprietario</h1>
@stop

@section('content')

<div class="row">

    {{-- INFO BOX CONTRATTI ATTIVI --}}
    <div class="col-md-3">
        <x-adminlte-info-box
            title="Contratti Attivi"
            text="{{ $leases }}"
            icon="fas fa-file-contract"
            icon-theme="purple"
        />
    </div>

</div>


{{-- ===========================
    GRAFICO ENTRATE MENSILI
=========================== --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i> Entrate mensili
                </h3>
            </div>
            <div class="card-body">
                <canvas id="paymentsChart" height="100"></canvas>
            </div>
        </div>
    </div>
{{-- ===========================
    GRAFICO SPESE MENSILI
=========================== --}}
    <div class="col-md-6">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> Spese mensili
                </h3>
            </div>
            <div class="card-body">
                <canvas id="expensesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>


@stop


@section('js')
{{-- Caricamento Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ==========================
    // GRAFICO ENTRATE
    // ==========================
    const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');

    new Chart(paymentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($payments->pluck('month')) !!},
            datasets: [{
                label: 'Entrate (€)',
                data: {!! json_encode($payments->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });


    // ==========================
    // GRAFICO SPESE
    // ==========================
    const expensesCtx = document.getElementById('expensesChart').getContext('2d');

    new Chart(expensesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyExpenses->keys()) !!},
            datasets: [{
                label: 'Spese (€)',
                data: {!! json_encode($monthlyExpenses->values()) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.4)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
