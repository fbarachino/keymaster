@extends('layouts.portal')

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
