@extends('layouts.portal')

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
