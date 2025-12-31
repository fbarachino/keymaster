@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Aggiungi nuovo inquilino e assegna contratto</h1>

<form method="POST" action="{{ route('landlord.tenants.store') }}" class="space-y-6">
    @csrf

    <!-- DATI INQUILINO -->
    <div class="bg-white p-6 shadow rounded">
        <h2 class="text-xl font-semibold mb-4">Dati inquilino</h2>

        <input type="text" name="name" placeholder="Nome completo"
               class="w-full p-2 border rounded mb-3">

        <input type="email" name="email" placeholder="Email"
               class="w-full p-2 border rounded mb-3">

        <input type="password" name="password" placeholder="Password"
               class="w-full p-2 border rounded mb-3">
    </div>

    <!-- DATI CONTRATTO -->
    <div class="bg-white p-6 shadow rounded">
        <h2 class="text-xl font-semibold mb-4">Dati contratto</h2>

        <label class="block font-semibold mb-1">Unità disponibile</label>
        <select name="unit_id" class="w-full p-2 border rounded mb-3">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">
                    {{ $unit->property->name }} — {{ $unit->name }}
                </option>
            @endforeach
        </select>

        <label class="block font-semibold mb-1">Data inizio</label>
        <input type="date" name="start_date" class="w-full p-2 border rounded mb-3">

        <label class="block font-semibold mb-1">Data fine (opzionale)</label>
        <input type="date" name="end_date" class="w-full p-2 border rounded mb-3">

        <label class="block font-semibold mb-1">Affitto mensile (€)</label>
        <input type="number" step="0.01" name="rent_amount"
               class="w-full p-2 border rounded mb-3">

        <label class="block font-semibold mb-1">Deposito cauzionale (€)</label>
        <input type="number" step="0.01" name="deposit_amount"
               class="w-full p-2 border rounded mb-3">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Crea inquilino e assegna contratto
    </button>
</form>
@endsection
