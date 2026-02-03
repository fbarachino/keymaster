@extends('adminlte::page')

@section('title', 'Unità disponibili')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Unità disponibili</h1>

    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Elenco unità disponibili</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Unità</th>
                        <th>Proprietà</th>
                        <th>Tipo</th>
                        <th>Superficie</th>
                        <th>Stato</th>
                        <th class="text-right">Azioni</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($units as $unit)
                        <tr>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->property->name }}</td>
                            <td>{{ $unit->type }}</td>
                            <td>{{ $unit->size ? $unit->size . ' m²' : '-' }}</td>
                            <td>
                                <span class="badge badge-success">Disponibile</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('landlord.units.edit', [$unit->property_id, $unit->id]) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Modifica
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Nessuna unità disponibile al momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
