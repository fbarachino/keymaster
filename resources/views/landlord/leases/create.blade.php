@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nuovo contratto</h1>

<form method="POST" action="{{ route('landlord.leases.store') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block font-semibold mb-1">Unità</label>
        <select name="unit_id" class="w-full p-2 border rounded">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">
                    {{ $unit->property->name }} — {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Inquilino</label>
        <select name="tenant_id" class="w-full p-2 border rounded">
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Data inizio</label>
        <input type="date" name="start_date" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Data fine (opzionale)</label>
        <input type="date" name="end_date" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Affitto mensile (€)</label>
        <input type="number" step="0.01" name="rent_amount" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Deposito cauzionale (€)</label>
        <input type="number" step="0.01" name="deposit_amount" class="w-full p-2 border rounded">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Crea contratto</button>
</form>
@endsection
