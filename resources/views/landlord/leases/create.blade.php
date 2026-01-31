@extends('adminlte::page')

@section('title', 'Nuovo contratto')

@section('content_header')
    <h1>Nuovo contratto</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-contract"></i> Nuovo contratto</h3>
    </div>

    <div class="card-body">
        <p class="mb-4">
            Compila il modulo sottostante per creare un nuovo contratto di locazione.
        </p>

        <form method="POST" action="{{ route('landlord.leases.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Unità</label>
                    <select name="unit_id" class="form-control">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">
                                {{ $unit->property->name }} — {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold">Conduttori</label>
                    <select name="tenants[]" class="form-control" multiple>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}"
                                {{ isset($lease) && $lease->tenants->contains($tenant->id) ? 'selected' : '' }}>
                                {{ $tenant->first_name }} {{ $tenant->last_name }} ({{ $tenant->email }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Seleziona uno o più conduttori</small>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Data inizio</label>
                    <input type="date" name="start_date" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Data fine (opzionale)</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Affitto mensile (€)</label>
                    <input type="number" step="0.01" name="rent_amount" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Anticipo spese mensile (€)</label>
                    <input type="number" step="0.01" name="advance_expenses" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Deposito cauzionale (€)</label>
                    <input type="number" step="0.01" name="deposit_amount" class="form-control">
                </div>
            </div>


            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Crea contratto
            </button>

        </form>
    </div>
</div>

@stop
