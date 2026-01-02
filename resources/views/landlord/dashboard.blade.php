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
@endsection
