@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Contratti di locazione</h1>

<a href="{{ route('landlord.leases.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo contratto
</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-3 text-left">Unità</th>
            <th class="p-3 text-left">Proprietà</th>
            <th class="p-3 text-left">Inquilino</th>
            <th class="p-3 text-left">Inizio</th>
            <th class="p-3 text-left">Affitto</th>
            <th class="p-3 text-center">Azioni</th>
        </tr>
    </thead>

    <tbody>
        @foreach($leases as $lease)
        <tr class="border-b">
            <td class="p-3">{{ $lease->unit->name }}</td>
            <td class="p-3">{{ $lease->unit->property->name }}</td>
            <td class="p-3">{{ $lease->tenant->name }}</td>
            <td class="p-3">{{ $lease->start_date->format('d/m/Y') }}</td>
            <td class="p-3">€ {{ number_format($lease->rent_amount, 2, ',', '.') }}</td>
            <td class="p-3 text-center">
                <a href="{{ route('landlord.leases.edit', $lease) }}" class="text-blue-600">Modifica</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
