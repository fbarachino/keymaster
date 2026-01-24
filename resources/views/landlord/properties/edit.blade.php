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
{{-- <div class="row">

    <div class="col-md-4">
        <x-adminlte-info-box
            title="Valore di acquisto"
            text="€ {{ number_format($property->purchase_price, 2, ',', '.') }}"
            icon="fas fa-home"
            theme="info"/>
    </div>

    <div class="col-md-4">
        <x-adminlte-info-box
            title="Rendita lorda"
            text="{{ number_format($property->grossYield(), 2, ',', '.') }}%"
            icon="fas fa-chart-line"
            theme="success"/>
    </div>

    <div class="col-md-4">
        <x-adminlte-info-box
            title="Rendita netta"
            text="{{ number_format($property->netYield(), 2, ',', '.') }}%"
            icon="fas fa-chart-pie"
            theme="warning"/>
    </div>

</div>
 --}}
 <div class="row">

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Valore di acquisto"
            text="€ {{ number_format($property->purchase_price, 2, ',', '.') }}"
            icon="fas fa-home"
            theme="info"/>
    </div>

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Rendita lorda"
            text="{{ number_format($property->grossYield(), 2, ',', '.') }}%"
            icon="fas fa-chart-line"
            theme="success"/>
    </div>

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Costi annuali landlord"
            text="€ {{ number_format($property->annualLandlordCosts(), 2, ',', '.') }}"
            icon="fas fa-wallet"
            theme="warning"/>
    </div>

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Rendita netta"
            text="{{ number_format($property->netYield(), 2, ',', '.') }}%"
            icon="fas fa-chart-pie"
            theme="danger"/>
    </div>

</div>

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

            <div class="col-md-6 mb-3">
                <label class="form-label font-weight-bold">Valore di acquisto (€)</label>
                <input type="number" step="0.01" name="purchase_price" class="form-control"
                    value="{{ $property->purchase_price }}">
            </div>


            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna
            </button>

        </form>

    </div>
</div>

@stop
