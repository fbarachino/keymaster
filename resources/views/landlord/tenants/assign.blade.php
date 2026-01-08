@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Assegna unità a {{ $tenant->name }}</h1>

<form method="POST" action="{{ route('landlord.tenants.assignStore', $tenant) }}" class="space-y-4">
    @csrf

    <select name="unit_id" class="w-full p-2 border rounded">
        @foreach($units as $unit)
            <option value="{{ $unit->id }}">
                {{ $unit->property->name }} — {{ $unit->name }}
            </option>
        @endforeach
    </select>

    <input type="date" name="start_date" class="w-full p-2 border rounded">

    <input type="date" name="end_date" class="w-full p-2 border rounded">

    <input type="number" step="0.01" name="rent_amount" placeholder="Canone mensile"
           class="w-full p-2 border rounded">

    <input type="number" step="0.01" name="deposit_amount" placeholder="Deposito cauzionale"
           class="w-full p-2 border rounded">

    <textarea name="notes" placeholder="Note opzionali"
              class="w-full p-2 border rounded h-32"></textarea>

    <button class="bg-green-600 text-white px-4 py-2 rounded">Crea contratto</button>
</form>
@endsection
