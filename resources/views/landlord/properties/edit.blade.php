@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-4">Modifica proprietà</h1>

<form method="POST" action="{{ route('properties.update', $property) }}" class="space-y-4">
    @csrf @method('PUT')

    <input type="text" name="name" value="{{ $property->name }}" class="w-full p-2 border rounded">
    <input type="text" name="address" value="{{ $property->address }}" class="w-full p-2 border rounded">
    <textarea name="description" class="w-full p-2 border rounded">{{ $property->description }}</textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiorna</button>
</form>
@endsection
