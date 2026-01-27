{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-4">Aggiungi proprietà</h1>

<form method="POST" action="{{ route('landlord.properties.store') }}" class="space-y-4">
    @csrf

    <input type="text" name="name" placeholder="Nome" class="w-full p-2 border rounded">
    <input type="text" name="address" placeholder="Indirizzo" class="w-full p-2 border rounded">
    <textarea name="description" placeholder="Descrizione" class="w-full p-2 border rounded"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Salva</button>
</form>
@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Aggiungi proprietà')

@section('content_header')
    <h1>Aggiungi proprietà</h1>
@stop

@section('content')

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-home"></i> Nuova proprietà
        </h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.properties.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label font-weight-bold">Nome</label>
                <input type="text" name="name" class="form-control" placeholder="Nome della proprietà">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Indirizzo</label>
                <input type="text" name="address" class="form-control" placeholder="Indirizzo completo">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Descrizione</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Descrizione della proprietà"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label font-weight-bold">Valore di acquisto (€)</label>
                <input type="number" step="0.01" name="purchase_price" class="form-control">
            </div>
            <h4>Dati catastali</h4>

<div class="row">
    <div class="col-md-2 mb-3">
        <label>Foglio</label>
        <input type="text" name="cadastral_sheet" class="form-control"
               >
    </div>

    <div class="col-md-2 mb-3">
        <label>Particella</label>
        <input type="text" name="cadastral_particle" class="form-control"
               >
    </div>

    <div class="col-md-2 mb-3">
        <label>Subalterno</label>
        <input type="text" name="cadastral_sub" class="form-control"
               >
    </div>

    <div class="col-md-2 mb-3">
        <label>Categoria</label>
        <input type="text" name="cadastral_category" class="form-control"
              >
    </div>

    <div class="col-md-2 mb-3">
        <label>Classe</label>
        <input type="text" name="cadastral_class" class="form-control"
               >
    </div>

    <div class="col-md-2 mb-3">
        <label>Rendita catastale</label>
        <input type="number" step="0.01" name="cadastral_rent" class="form-control">

    </div>
</div>


            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Salva
            </button>

        </form>

    </div>
</div>

@stop
