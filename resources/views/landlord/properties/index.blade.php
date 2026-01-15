{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-4">Le mie proprietà</h1>

<a href="{{ route('landlord.properties.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Aggiungi proprietà</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <tr class="border-b">
        <th class="p-3 text-left">Nome</th>
        <th class="p-3 text-left">Indirizzo</th>
        <th class="p-3">Azioni</th>
    </tr>

    @foreach($properties as $property)
    <tr class="border-b">
        <td class="p-3">{{ $property->name }}</td>
        <td class="p-3">{{ $property->address }}</td>
        <td class="p-3 text-center">
            <a href="{{ route('landlord.properties.edit', $property) }}" class="text-blue-600">Modifica</a>
            <form action="{{ route('landlord.properties.destroy', $property) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button class="text-red-600 ml-2">Elimina</button>
            </form>
            <a href="{{ route('landlord.units.index', $property) }}" class="text-blue-600">
    Gestisci unità
</a>

        </td>
    </tr>
    @endforeach
</table>
@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Le mie proprietà')

@section('content_header')
    <h1>Le mie proprietà</h1>
@stop

@section('content')

<a href="{{ route('landlord.properties.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Aggiungi proprietà
</a>

<div class="card">
    <div class="card-body p-0">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Indirizzo</th>
                    <th class="text-center">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @foreach($properties as $property)
                <tr>
                    <td>{{ $property->name }}</td>
                    <td>{{ $property->address }}</td>
                    <td class="text-center">

                        <a href="{{ route('landlord.properties.edit', $property) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Modifica
                        </a>

                        <form action="{{ route('landlord.properties.destroy', $property) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Sei sicuro di voler eliminare questa proprietà?')">
                                <i class="fas fa-trash"></i> Elimina
                            </button>
                        </form>

                        <a href="{{ route('landlord.units.index', $property) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-building"></i> Gestisci unità
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@stop
