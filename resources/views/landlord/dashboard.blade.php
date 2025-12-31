@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Proprietario</h1>

<div class="grid grid-cols-2 gap-6">

    <div class="bg-white p-6 shadow rounded">
        <h2 class="font-semibold mb-4">Entrate mensili</h2>
        <canvas id="paymentsChart"></canvas>
    </div>

    <div class="bg-white p-6 shadow rounded">
        <h2 class="font-semibold mb-4">Contratti attivi</h2>
        <p class="text-4xl">{{ $leases }}</p>
    </div>

</div>

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
