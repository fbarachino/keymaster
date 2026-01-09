@extends('layouts.portal')

@section('content')
{{-- <h1 class="text-2xl font-bold mb-6">Nuovo ticket</h1> --}}
<x-adminlte-card title="Nuovo ticket" theme="dark" icon="fas fa-ticket-alt" class="mb-6">
<form method="POST" action="{{ route('tenant.tickets.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div class="row">
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1" for="unit_id">Unità</label>
    <select name="unit_id" class="form-control" id="unit_id">
        @foreach($units as $unit)
            <option value="{{ $unit->id }}">
                {{ $unit->property->name }} — {{ $unit->name }}
            </option>
        @endforeach
    </select>
    </div>
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Titolo</label>
    <input type="text" name="title" placeholder="Titolo" class="form-control">
    </div>
    </div>
    <div class="row">
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Descrizione</label>
    <textarea name="description" placeholder="Descrizione del problema" class="form-control"></textarea>
    </div>
    </div>
    <div class="row">
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Priorità</label>
    <select name="priority" class="form-control">
        <option value="low">Bassa</option>
        <option value="medium">Media</option>
        <option value="high">Alta</option>
    </select>
    </div>
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Allegati</label>
    <input type="file" name="attachments[]" multiple class="form-control-file">
    </div>
    </div>
    <div class="row">
    <div class="col mr-4 mb-4">
    <button class="btn btn-primary">Invia ticket</button>
    </div>
    </div>
</form>
</x-adminlte-card>
@endsection
