
@extends('layouts.admin')

@section('title', 'Le tue proprietà')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Le tue proprietà</h1>
        <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Aggiungi proprietà
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Indirizzo</th>
                        <th>Città</th>
                        <th>Prezzo Acquisto</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($properties as $property)
                        <tr>
                            <td>{{ $property->name }}</td>
                            <td>{{ $property->address }}</td>
                            <td>{{ $property->city }}</td>
                            <td>{{ number_format($property->purchase_price, 2, ',', '.') }} €</td>
                            <td>
                                <a href="{{ route('landlord.properties.edit', $property) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('landlord.units.index', $property) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-building"></i>
                                </a>


                                <form action="{{ route('landlord.properties.destroy', $property) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Sei sicuro di voler eliminare questa proprietà?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Nessuna proprietà trovata.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $properties->links() }}
        </div>
    </div>

</div>
@endsection
