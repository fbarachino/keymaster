@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifica contratto</h1>

<form method="POST" action="{{ route('landlord.leases.update', $lease) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-semibold mb-1">Unità</label>
        <select name="unit_id" class="w-full p-2 border rounded">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}" @selected($lease->unit_id == $unit->id)>
                    {{ $unit->property->name }} — {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Inquilino</label>
        <select name="tenant_id" class="w-full p-2 border rounded">
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected($lease->tenant_id == $tenant->id)>
                    {{ $tenant->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Data inizio</label>
        <input type="date" name="start_date" value="{{ $lease->start_date->format('Y-m-d') }}" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Data fine</label>
        <input type="date" name="end_date" value="{{ optional($lease->end_date)->format('Y-m-d') }}" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Affitto mensile (€)</label>
        <input type="number" step="0.01" name="rent_amount" value="{{ $lease->rent_amount }}" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Deposito cauzionale (€)</label>
        <input type="number" step="0.01" name="deposit_amount" value="{{ $lease->deposit_amount }}" class="w-full p-2 border rounded">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiorna contratto</button>
</form>
@endsection
