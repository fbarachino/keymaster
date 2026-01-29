{{-- {{-- @extends('layouts.portal')

@section('content')
<x-adminlte-card title="Modifica contratto" theme="dark" icon="fas fa-file-contract" class="mb-6">

<form method="POST" action="{{ route('landlord.leases.update', $lease) }}" class="space-y-4">
    @csrf
    @method('PUT')
<div class="row">
    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Unità</label>
        <select name="unit_id" class="w-full p-2 border rounded">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}" @selected($lease->unit_id == $unit->id)>
                    {{ $unit->property->name }} — {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col mr-4 mb-4">

        <label class="block font-semibold mb-1">Inquilino</label>
        <select name="tenant_id" class="w-full p-2 border rounded">
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected($lease->tenant_id == $tenant->id)>
                    {{ $tenant->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Data inizio</label>
        <input type="date" name="start_date" value="{{ $lease->start_date->format('Y-m-d') }}" class="w-full p-2 border rounded">
    </div>

    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Data fine</label>
        <input type="date" name="end_date" value="{{ optional($lease->end_date)->format('Y-m-d') }}" class="w-full p-2 border rounded">
    </div>
</div>
<div class="row">
    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Affitto mensile (€)</label>
        <input type="number" step="0.01" name="rent_amount" value="{{ $lease->rent_amount }}" class="w-full p-2 border rounded">
    </div>

    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Deposito cauzionale (€)</label>
        <input type="number" step="0.01" name="deposit_amount" value="{{ $lease->deposit_amount }}" class="w-full p-2 border rounded">
    </div>
</div>
<div class="row">
    <div class="col mr-4 mb-4">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiorna contratto</button>
    </div>
</div>
</x-adminlte-card>
</form>
@endsection
 --}}{{--
 @extends('adminlte::page')

@section('title', 'Modifica contratto')

@section('content_header')
    <h1>Modifica contratto</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-contract"></i> Modifica contratto
        </h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.leases.update', $lease) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Unità</label>
                    <select name="unit_id" class="form-control">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" @selected($lease->unit_id == $unit->id)>
                                {{ $unit->property->name }} — {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Inquilino</label>
                    <select name="tenant_id" class="form-control">
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" @selected($lease->tenant_id == $tenant->id)>
                                {{ $tenant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Data inizio</label>
                    <input type="date" name="start_date"
                           value="{{ $lease->start_date->format('Y-m-d') }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Data fine</label>
                    <input type="date" name="end_date"
                           value="{{ optional($lease->end_date)->format('Y-m-d') }}"
                           class="form-control">
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Affitto mensile (€)</label>
                    <input type="number" step="0.01" name="rent_amount"
                           value="{{ $lease->rent_amount }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Deposito cauzionale (€)</label>
                    <input type="number" step="0.01" name="deposit_amount"
                           value="{{ $lease->deposit_amount }}"
                           class="form-control">
                </div>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna contratto
            </button>

        </form>

    </div>
</div>

@stop
 --}}
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
