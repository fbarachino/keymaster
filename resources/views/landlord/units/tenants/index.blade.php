@extends('adminlte::page')

@section('title', 'Gestione coinquilini')

@section('content_header')
    <h1>Coinquilini di {{ $unit->name }} ({{ $property->name }})</h1>
@stop

@section('content')

{{-- FORM AGGIUNTA COINQUILINO --}}
<div class="card card-dark mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus"></i> Aggiungi coinquilino</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.units.tenants.store', [$property, $unit]) }}">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">Inquilino</label>
                    <select name="tenant_id" class="form-control">
                        @foreach($allTenants as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">Tipo quota</label>
                    <select name="share_type" class="form-control">
                        <option value="none">Nessuna</option>
                        <option value="equal">Divisione uguale</option>
                        <option value="custom">Personalizzata</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">Quota (%)</label>
                    <input type="number" step="0.01" name="share_value" class="form-control" placeholder="0.50">
                </div>

            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="is_primary" class="form-check-input" id="primary">
                <label for="primary" class="form-check-label">Intestatario principale</label>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiungi
            </button>

        </form>

    </div>
</div>


{{-- LISTA COINQUILINI --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Coinquilini attuali</h3>
    </div>

    <div class="card-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Intestatario</th>
                    <th>Quota</th>
                    <th class="text-center">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->name }}</td>

                        <td>
                            @if($tenant->pivot->is_primary)
                                <span class="badge badge-success">Sì</span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </td>

                        <td>
                            @if($tenant->pivot->share_type === 'equal')
                                <span class="badge badge-info">Divisione uguale</span>
                            @elseif($tenant->pivot->share_type === 'custom')
                                <span class="badge badge-warning">{{ $tenant->pivot->share_value * 100 }}%</span>
                            @else
                                <span class="badge badge-secondary">Nessuna</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <form method="POST" action="{{ route('landlord.units.tenants.destroy', [$property, $unit, $tenant]) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Rimuovere questo coinquilino?')">
                                    <i class="fas fa-trash"></i> Rimuovi
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@stop
