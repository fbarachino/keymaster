{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nuovo contratto</h1>
<x-adminlte-card title="Nuovo contratto" theme="dark" icon="fas fa-file-contract" class="mb-6">
    <div class="row">
    <div class="col mr-4 mb-4">
    Compila il modulo sottostante per creare un nuovo contratto di locazione.
    </div>
    </div>
<form method="POST" action="{{ route('landlord.leases.store') }}" class="space-y-4">
    @csrf
<div class="row">
    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Unità</label>
        <select name="unit_id" class="w-full p-2 border rounded">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">
                    {{ $unit->property->name }} — {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Inquilino</label>
        <select name="tenant_id" class="w-full p-2 border rounded">
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col mr-4 mb-4">

        <label class="block font-semibold mb-1">Data inizio</label>
        <input type="date" name="start_date" class="w-full p-2 border rounded">
    </div>

   <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Data fine (opzionale)</label>
        <input type="date" name="end_date" class="w-full p-2 border rounded">
    </div>
</div>
<div class="row">
    <div class="col mr-4 mb-4">

        <label class="block font-semibold mb-1">Affitto mensile (€)</label>
        <input type="number" step="0.01" name="rent_amount" class="w-full p-2 border rounded">
    </div>

    <div class="col mr-4 mb-4">
        <label class="block font-semibold mb-1">Deposito cauzionale (€)</label>
        <input type="number" step="0.01" name="deposit_amount" class="w-full p-2 border rounded">
    </div>
</div>
    <button class="btn btn-primary">Crea contratto</button>
</form>
</x-adminlte-card>
@endsection
 --}}
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

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Inquilino</label>
                    <select name="tenant_id" class="form-control">
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                        @endforeach
                    </select>
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
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Affitto mensile (€)</label>
                    <input type="number" step="0.01" name="rent_amount" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
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
