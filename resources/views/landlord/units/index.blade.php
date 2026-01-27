{{-- @extends('layouts.portal')

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
 --}}
 @extends('adminlte::page')

@section('title', 'Unità di ' . $property->name)

@section('content_header')
    <h1>Unità di {{ $property->name }}</h1>
@stop

@section('content')

<a href="{{ route('landlord.units.create', $property) }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Aggiungi unità
</a>

<div class="card">
    <div class="card-body p-0">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Piano</th>
                    <th>Dimensione</th>
                    <th>Affitto</th>
                    <th>Stato</th>
                    <th class="text-center">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->floor }}</td>
                    <td>{{ $unit->size }} m²</td>
                    <td>€ {{ number_format($unit->monthly_rent, 2, ',', '.') }}</td>

                    <td>
                        @if($unit->status === 'available')
                            <span class="badge badge-success">Disponibile</span>
                        @else
                            <span class="badge badge-secondary">Occupata</span>
                        @endif
                    </td>

                    <td class="text-center">

                        <a href="{{ route('landlord.units.edit', [$property, $unit]) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Modifica
                        </a>
                        <a href="{{ route('landlord.units.report', $unit) }}" class="btn btn-info mb-3">
                            <i class="fas fa-file-alt"></i> Dossier Unit
                        </a>

                        <form action="{{ route('landlord.units.destroy', [$property, $unit]) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Sei sicuro di voler eliminare questa unità?')">
                                <i class="fas fa-trash"></i> Elimina
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@stop
