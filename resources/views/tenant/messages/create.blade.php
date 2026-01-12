@extends('layouts.portal')

@section('content')
{{-- <h1 class="text-2xl font-bold mb-6">Nuovo messaggio</h1> --}}
<x-adminlte-card theme="purple" icon="fas fa-lg fa-envelope" title="Componi un nuovo messaggio">
    <p class="text-sm text-gray-600 mb-4">
    Il messaggio sarà inviato a: <strong>{{ $landlords->name }}</strong>
</p>

<form method="POST" action="{{ route('tenant.messages.store') }}" class="space-y-4">
    @csrf
    <div class="row-form">
{{--         <div class="col">
    <label for="landlord_id" class="block font-medium text-gray-700 mb-2">Seleziona il Proprietario:</label>
    <select name="landlord_id" class="form-control">
    @foreach($landlords as $landlord)
        <option value="{{ $landlord->id }}">{{ $landlord->name }}</option>
    @endforeach
</select>
        </div> --}}
        <div class="col">
    <label for="oggetto" class="block font-medium text-gray-700 mb-2">Oggetto:</label>
    <input type="text" name="subject" placeholder="Oggetto" id="oggetto"
           class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
    <label for="message" class="block font-medium text-gray-700 mb-2">Messaggio:</label>

    <textarea name="message" placeholder="Scrivi il tuo messaggio..."
              class="form-control"></textarea>
        </div>
</div>
<div class="row">
    <div class="col">
    <button class="btn btn-primary mt-4" type="submit">
        Invia
    </button>
    </div>
</div>
</form>
</x-adminlte-card>
@endsection
