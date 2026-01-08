@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nuovo ticket</h1>

<form method="POST" action="{{ route('tenant.tickets.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <select name="unit_id" class="w-full p-2 border rounded">
        @foreach($units as $unit)
            <option value="{{ $unit->id }}">
                {{ $unit->property->name }} — {{ $unit->name }}
            </option>
        @endforeach
    </select>

    <input type="text" name="title" placeholder="Titolo" class="w-full p-2 border rounded">

    <textarea name="description" placeholder="Descrizione del problema" class="w-full p-2 border rounded h-32"></textarea>

    <select name="priority" class="w-full p-2 border rounded">
        <option value="low">Bassa</option>
        <option value="medium">Media</option>
        <option value="high">Alta</option>
    </select>

    <input type="file" name="attachments[]" multiple class="w-full">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Invia ticket</button>
</form>
@endsection
