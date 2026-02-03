@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <form method="GET" class="mb-4">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">Filtri avanzati</h3>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <label>Proprietà</label>
                    <select name="property_id" class="form-control">
                        <option value="">Tutte</option>
                        @foreach ($properties as $p)
                            <option value="{{ $p->id }}" {{ request('property_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Mese</label>
                    <input type="month" name="month" class="form-control"
                           value="{{ request('month') }}">
                </div>

                <div class="col-md-2">
                    <label>Stato contratto</label>
                    <select name="lease_status" class="form-control">
                        <option value="">Tutti</option>
                        <option value="active" {{ request('lease_status') == 'active' ? 'selected' : '' }}>Attivi</option>
                        <option value="pending" {{ request('lease_status') == 'pending' ? 'selected' : '' }}>In attesa</option>
                        <option value="terminated" {{ request('lease_status') == 'terminated' ? 'selected' : '' }}>Terminati</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Stato unità</label>
                    <select name="unit_status" class="form-control">
                        <option value="">Tutte</option>
                        <option value="available" {{ request('unit_status') == 'available' ? 'selected' : '' }}>Disponibili</option>
                        <option value="occupied" {{ request('unit_status') == 'occupied' ? 'selected' : '' }}>Occupate</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Applica filtri
                    </button>
                </div>

            </div>
        </div>
    </div>
</form>

    {{-- KPI TOP ROW --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $propertiesCount }}</h3>
                    <p>Proprietà</p>
                </div>
                <div class="icon">
                    <i class="fas fa-city"></i>
                </div>
                <a href="{{ route('landlord.properties.index') }}" class="small-box-footer">
                    Gestisci proprietà <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $unitsCount }}</h3>
                    <p>Unità totali</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $activeLeasesCount }}</h3>
                    <p>Contratti attivi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-contract"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $occupancyRate }}<sup style="font-size: 20px">%</sup></h3>
                    <p>Tasso di occupazione</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ROW 2: AFFITTI MENSILI + GRAFICO --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline card-success h-100">
                <div class="card-header">
                    <h3 class="card-title">Affitti mensili attesi</h3>
                </div>
                <div class="card-body">
                    <h2>{{ number_format($monthlyRent, 2, ',', '.') }} €</h2>
                    <p class="text-muted mb-0">
                        Somma dei canoni mensili dei contratti attivi.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Entrate vs Uscite (ultimi 6 mesi)</h3>
                </div>
                <div class="card-body">
                    <canvas id="paymentsExpensesChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ROW 3: ULTIMI PAGAMENTI / ULTIME SPESE --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Ultimi pagamenti</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Proprietà</th>
                                <th>Importo</th>
                                <th>Stato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestPayments as $payment)
                                <tr>
                                    <td>{{ $payment->due_date }}</td>
                                    <td>{{ $payment->lease->property->name ?? '-' }}</td>
                                    <td>{{ number_format($payment->amount_total, 2, ',', '.') }} €</td>
                                    <td>
                                        <span class="badge badge-{{ $payment->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">Nessun pagamento trovato.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Ultime spese</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Proprietà</th>
                                <th>Importo</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestExpenses as $expense)
                                <tr>
                                    <td>{{ $expense->date }}</td>
                                    <td>{{ $expense->lease->property->name ?? '-' }}</td>
                                    <td>{{ number_format($expense->amount_total, 2, ',', '.') }} €</td>
                                    <td>{{ $expense->type ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">Nessuna spesa trovata.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('paymentsExpensesChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Pagamenti incassati',
                    data: @json($paymentsPerMonth),
                    borderColor: 'rgba(40, 167, 69, 1)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                },
                {
                    label: 'Spese',
                    data: @json($expensesPerMonth),
                    borderColor: 'rgba(220, 53, 69, 1)',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('it-IT') + ' €';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
