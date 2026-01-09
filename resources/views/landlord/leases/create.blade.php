@extends('layouts.portal')

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
