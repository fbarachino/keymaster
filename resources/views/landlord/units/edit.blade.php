{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    Modifica unità {{ $unit->name }}
</h1>

<form method="POST" action="{{ route('landlord.units.update', [$property, $unit]) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $unit->name }}" class="w-full p-2 border rounded">

    <input type="number" name="floor" value="{{ $unit->floor }}" class="w-full p-2 border rounded">

    <input type="number" name="size" value="{{ $unit->size }}" class="w-full p-2 border rounded">

    <input type="number" step="0.01" name="monthly_rent" value="{{ $unit->monthly_rent }}" class="w-full p-2 border rounded">

    <select name="status" class="w-full p-2 border rounded">
        <option value="available" @selected($unit->status === 'available')>Disponibile</option>
        <option value="occupied" @selected($unit->status === 'occupied')>Occupata</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiorna unità</button>
</form>
<h2 class="text-xl font-semibold mt-8 mb-4">Foto unità</h2>

<form action="{{ route('landlord.units.photos.upload', [$property, $unit]) }}"
      method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="photos[]" multiple class="w-full p-2 border rounded">

    <button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">
        Carica foto
    </button>
</form>

<div class="grid grid-cols-4 gap-4 mt-4">
    @foreach($unit->photos as $photo)
        <img src="{{ asset('storage/' . $photo->path) }}" class="rounded shadow">
    @endforeach
</div>
<h2 class="text-xl font-semibold mt-8 mb-4">Inventario</h2>

<form action="{{ route('landlord.units.inventory.add', [$property, $unit]) }}" method="POST">
    @csrf

    <input type="text" name="item" placeholder="Oggetto" class="w-full p-2 border rounded mb-2">

    <select name="condition" class="w-full p-2 border rounded mb-2">
        <option value="good">Buono</option>
        <option value="worn">Usurato</option>
        <option value="damaged">Danneggiato</option>
    </select>

    <textarea name="notes" placeholder="Note" class="w-full p-2 border rounded mb-2"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiungi</button>
</form>

<ul class="mt-4 space-y-2">
    @foreach($unit->inventory as $item)
        <li class="bg-white p-3 shadow rounded">
            <strong>{{ $item->item }}</strong> — {{ $item->condition }}
            <p class="text-sm text-gray-600">{{ $item->notes }}</p>
        </li>
    @endforeach
</ul>
<h2 class="text-xl font-semibold mt-8 mb-4">QR Code</h2>

<img src="data:image/png;base64,{{ $qr }}" class="shadow rounded">
<h2 class="text-xl font-semibold mt-8 mb-4">Documenti</h2>

<form action="{{ route('landlord.units.documents.upload', [$property, $unit]) }}"
      method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name" placeholder="Nome documento" class="w-full p-2 border rounded mb-2">

    <input type="file" name="document" class="w-full p-2 border rounded mb-2">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Carica documento</button>
</form>

<ul class="mt-4 space-y-2">
    @foreach($unit->documents as $doc)
        <li class="bg-white p-3 shadow rounded">
            <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="text-blue-600">
                {{ $doc->name }}
            </a>
        </li>
    @endforeach
</ul>

@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Modifica unità')

@section('content_header')
    <h1>Modifica unità {{ $unit->name }}</h1>
@stop

@section('content')
@if ($errors->any()) <x-adminlte-alert theme="danger" title="Errore nella compilazione"> <ul class="mb-0"> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> </x-adminlte-alert> @endif
{{-- ===========================
    SEZIONE: MODIFICA UNITÀ
=========================== --}}
<div class="card card-dark mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-building"></i> Dati unità
        </h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.units.update', [$property, $unit]) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Nome unità</label>
                    <input type="text" name="name" value="{{ $unit->name }}" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">Piano</label>
                    <input type="number" name="floor" value="{{ $unit->floor }}" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">Dimensione (m²)</label>
                    <input type="number" name="size" value="{{ old('size', $unit->size) }}" class="form-control">
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Affitto mensile (€)</label>
                    <input type="number" step="0.01" name="monthly_rent"
                           value="{{ $unit->monthly_rent }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Stato</label>
                    <select name="status" class="form-control">
                        <option value="available" @selected($unit->status === 'available')>Disponibile</option>
                        <option value="occupied" @selected($unit->status === 'occupied')>Occupata</option>
                    </select>
                </div>

            </div>
            <h4>Dati unità</h4>

<div class="row">


    <div class="col-md-3 mb-3">
        <label>Interno</label>
        <input type="text" name="interior" class="form-control"
               value="{{ $unit->interior }}">
    </div>

    <div class="col-md-3 mb-3">
        <label>Vani</label>
        <input type="number" name="rooms" class="form-control"
               value="{{ $unit->rooms }}">
    </div>


</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Pertinenza</label>
        <input type="text" name="accessory" class="form-control"
               value="{{ $unit->accessory }}">
    </div>
</div>


            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna unità
            </button>

        </form>

    </div>
</div>



{{-- ===========================
    SEZIONE: FOTO UNITÀ
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-images"></i> Foto unità</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('landlord.units.photos.upload', [$property, $unit]) }}"
              method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="font-weight-bold">Carica nuove foto</label>
                <input type="file" name="photos[]" multiple class="form-control">
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-upload"></i> Carica foto
            </button>
        </form>

        <div class="row mt-4">
            @foreach($unit->photos as $photo)
                <div class="col-md-3 mb-3">
                    <img src="{{ asset('storage/' . $photo->path) }}"
                         class="img-fluid rounded shadow">
                </div>
            @endforeach
        </div>

    </div>
</div>



{{-- ===========================
    SEZIONE: INVENTARIO
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-boxes"></i> Inventario</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('landlord.units.inventory.add', [$property, $unit]) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="font-weight-bold">Oggetto</label>
                <input type="text" name="item" class="form-control" placeholder="Nome oggetto">
            </div>

            <div class="mb-3">
                <label class="font-weight-bold">Condizione</label>
                <select name="condition" class="form-control">
                    <option value="good">Buono</option>
                    <option value="worn">Usurato</option>
                    <option value="damaged">Danneggiato</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="font-weight-bold">Note</label>
                <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Aggiungi
            </button>
        </form>

        <ul class="list-group mt-4">
            @foreach($unit->inventory as $item)
                <li class="list-group-item">
                    <strong>{{ $item->item }}</strong> — {{ $item->condition }}
                    <p class="text-muted mb-0">{{ $item->notes }}</p>
                </li>
            @endforeach
        </ul>

    </div>
</div>



{{-- ===========================
    SEZIONE: QR CODE
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-qrcode"></i> QR Code</h3>
    </div>

    <div class="card-body text-center">
        <img src="data:image/png;base64,{{ $qr }}" class="img-fluid shadow rounded">
    </div>
</div>



{{-- ===========================
    SEZIONE: DOCUMENTI
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt"></i> Documenti</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('landlord.units.documents.upload', [$property, $unit]) }}"
              method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="font-weight-bold">Nome documento</label>
                <input type="text" name="name" class="form-control" placeholder="Nome documento">
            </div>

            <div class="mb-3">
                <label class="font-weight-bold">Carica file</label>
                <input type="file" name="document" class="form-control">
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-upload"></i> Carica documento
            </button>
        </form>

        <ul class="list-group mt-4">
            @foreach($unit->documents as $doc)
                <li class="list-group-item">
                    <a href="{{ asset('storage/' . $doc->path) }}" target="_blank">
                        <i class="fas fa-file"></i> {{ $doc->name }}
                    </a>
                </li>
            @endforeach
        </ul>

    </div>
</div>

@stop
