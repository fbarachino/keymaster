@extends('adminlte::page')

@section('title', 'Modifica contratto')

@section('content_header')
    <h1>Modifica contratto</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-contract"></i> Modifica contratto</h3>
    </div>
    <a href="{{ route('landlord.tenants.create', ['lease_id' => $lease->id]) }}"
        class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus"></i> Aggiungi Tenant
        </a>
    <div class="card-body">
        <p class="mb-4">
            Aggiorna i dati del contratto di locazione.
        </p>

        <form method="POST" action="{{ route('landlord.leases.update', $lease) }}">
            @csrf
            @method('PUT')

            {{-- UNITÀ E INQUILINO --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Unità</label>
                    <select name="unit_id" class="form-control">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ $lease->unit_id == $unit->id ? 'selected' : '' }}>
                                {{ $unit->property->name }} — {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Inquilini</label>
                    <select name="tenants[]" class="form-control" multiple>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}"
                                {{ $lease->tenants->contains($tenant->id) ? 'selected' : '' }}>
                                {{ $tenant->first_name }} {{ $tenant->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- DATE --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Data inizio</label>
                    <input type="date" name="start_date" class="form-control"
                           value="{{ $lease->start_date }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Data fine (opzionale)</label>
                    <input type="date" name="end_date" class="form-control"
                           value="{{ $lease->end_date }}">
                </div>
            </div>

            {{-- IMPORTI ECONOMICI --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Affitto mensile (€)</label>
                    <input type="number" step="0.01" name="rent_amount" class="form-control"
                           value="{{ $lease->rent_amount }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Anticipo spese mensile (€)</label>
                    <input type="number" step="0.01" name="advance_expenses" class="form-control"
                           value="{{ $lease->advance_expenses }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Deposito cauzionale (€)</label>
                    <input type="number" step="0.01" name="deposit_amount" class="form-control"
                           value="{{ $lease->deposit_amount }}">
                </div>
                <div class="form-group">
                    <label>Modalità di ripartizione</label>
                    <select name="split_mode" class="form-control">
                        <option value="equal" {{ $lease->split_mode === 'equal' ? 'selected' : '' }}>
                            Dividi in parti uguali
                        </option>
                        <option value="full" {{ $lease->split_mode === 'full' ? 'selected' : '' }}>
                            Report unico per tutti
                        </option>
                    </select>
                </div>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna contratto
            </button>

        </form>
    </div>
</div>

@stop
