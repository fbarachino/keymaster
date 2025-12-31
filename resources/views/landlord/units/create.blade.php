@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    Aggiungi unità a {{ $property->name }}
</h1>

<form method="POST" action="{{ route('landlord.units.store', $property) }}" class="space-y-4">
    @csrf

    <input type="text" name="name" placeholder="Nome unità" class="w-full p-2 border rounded">

    <input type="number" name="floor" placeholder="Piano" class="w-full p-2 border rounded">

    <input type="number" name="size" placeholder="Dimensione (m²)" class="w-full p-2 border rounded">

    <input type="number" step="0.01" name="monthly_rent" placeholder="Affitto mensile (€)" class="w-full p-2 border rounded">

    <select name="status" class="w-full p-2 border rounded">
        <option value="available">Disponibile</option>
        <option value="occupied">Occupata</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Crea unità</button>
</form>
@endsection
