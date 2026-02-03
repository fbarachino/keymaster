@extends('layouts.admin')

@section('title', 'Unità di ' . $property->name)

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Unità di {{ $property->name }}</h1>

        <a href="{{ route('landlord.units.create', $property) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Aggiungi unità
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Piano</th>
                        <th>Vani</th>
                        <th>MQ</th>
                        <th>Stato</th>
                        <th>Affitto</th>
                        <th>Azioni</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($units as $unit)
                        <tr>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->type }}</td>
                            <td>{{ $unit->floor }}</td>
                            <td>{{ $unit->rooms }}</td>
                            <td>{{ $unit->size_sqm }}</td>
                            <td>
                                <span class="badge badge-{{ $unit->status == 'available' ? 'success' : 'danger' }}">
                                    {{ $unit->status == 'available' ? 'Disponibile' : 'Occupata' }}
                                </span>
                            </td>
                            <td>{{ number_format($unit->monthly_rent, 2, ',', '.') }} €</td>
                            <td>
                                <a href="{{ route('landlord.units.edit', [$property, $unit]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('landlord.units.destroy', [$property, $unit]) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Eliminare questa unità?')">
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
                            <td colspan="5" class="text-center py-4">
                                Nessuna unità trovata.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $units->links() }}
        </div>
    </div>

</div>
@endsection
