@extends('adminlte::page')

@section('title', 'Contratti di ' . $property->name)

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Contratti di {{ $property->name }}</h1>

        <a href="{{ route('landlord.leases.create', $property) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuovo contratto
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Periodo</th>
                        <th>Unità</th>
                        <th>Inquilini</th>
                        <th>Canone</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leases as $lease)
                        <tr>
                            <td>
                                {{ $lease->start_date }} →
                                {{ $lease->end_date ?? 'In corso' }}
                            </td>

                            <td>
                                @foreach ($lease->units as $unit)
                                    <span class="badge badge-info">{{ $unit->name }}</span>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($lease->tenants as $tenant)
                                    <span class="badge badge-secondary">{{ $tenant->name }}</span>
                                @endforeach
                            </td>

                            <td>{{ number_format($lease->rent_total, 2, ',', '.') }} €</td>

                            <td>
                                <span class="badge badge-{{ $lease->status == 'active' ? 'success' : ($lease->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($lease->status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('landlord.leases.edit', [$property, $lease]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('landlord.leases.destroy', [$property, $lease]) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Eliminare questo contratto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Nessun contratto trovato.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $leases->links() }}
        </div>
    </div>

</div>
@endsection
