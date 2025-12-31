@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    Unità di {{ $property->name }}
</h1>

<a href="{{ route('landlord.units.create', $property) }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Aggiungi unità
</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-3 text-left">Nome</th>
            <th class="p-3 text-left">Piano</th>
            <th class="p-3 text-left">Dimensione</th>
            <th class="p-3 text-left">Affitto</th>
            <th class="p-3 text-left">Stato</th>
            <th class="p-3 text-center">Azioni</th>
        </tr>
    </thead>

    <tbody>
        @foreach($units as $unit)
        <tr class="border-b">
            <td class="p-3">{{ $unit->name }}</td>
            <td class="p-3">{{ $unit->floor }}</td>
            <td class="p-3">{{ $unit->size }} m²</td>
            <td class="p-3">€ {{ number_format($unit->monthly_rent, 2, ',', '.') }}</td>
            <td class="p-3">{{ ucfirst($unit->status) }}</td>
            <td class="p-3 text-center">
                <a href="{{ route('landlord.units.edit', [$property, $unit]) }}" class="text-blue-600">Modifica</a>

                <form action="{{ route('landlord.units.destroy', [$property, $unit]) }}"
                      method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-600 ml-2">Elimina</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
