@extends('layouts.portal')

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
