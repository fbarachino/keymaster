{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-4">Modifica proprietà</h1>

<form method="POST" action="{{ route('landlord.properties.update', $property) }}" class="space-y-4">
    @csrf @method('PUT')

    <input type="text" name="name" value="{{ $property->name }}" class="w-full p-2 border rounded">
    <input type="text" name="address" value="{{ $property->address }}" class="w-full p-2 border rounded">
    <textarea name="description" class="w-full p-2 border rounded">{{ $property->description }}</textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiorna</button>
</form>
@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Modifica proprietà')

@section('content_header')
    <h1>Modifica proprietà</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-home"></i> Aggiorna proprietà
        </h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.properties.update', $property) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label font-weight-bold">Nome</label>
                <input type="text"
                       name="name"
                       value="{{ $property->name }}"
                       class="form-control"
                       placeholder="Nome della proprietà">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Indirizzo</label>
                <input type="text"
                       name="address"
                       value="{{ $property->address }}"
                       class="form-control"
                       placeholder="Indirizzo completo">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Descrizione</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Descrizione della proprietà">{{ $property->description }}</textarea>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna
            </button>

        </form>

    </div>
</div>

@stop
