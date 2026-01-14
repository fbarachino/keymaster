@extends('adminlte::page')

@section('title', 'Nuovo messaggio')

@section('content_header')
    <h1>Componi un nuovo messaggio</h1>
@stop

@section('content')

<x-adminlte-card theme="purple" icon="fas fa-lg fa-envelope" title="Componi un nuovo messaggio">

    <p class="text-muted mb-3">
        Il messaggio sarà inviato a:
        <strong>{{ $landlords->name }}</strong>
    </p>

    <form method="POST" action="{{ route('tenant.messages.store') }}">
        @csrf

        {{-- Oggetto --}}
        <div class="form-group">
            <label for="subject">Oggetto</label>
            <input type="text"
                   name="subject"
                   id="subject"
                   class="form-control"
                   placeholder="Oggetto del messaggio"
                   required>
        </div>

        {{-- Messaggio --}}
        <div class="form-group">
            <label for="message">Messaggio</label>
            <textarea name="message"
                      id="message"
                      class="form-control"
                      rows="5"
                      placeholder="Scrivi il tuo messaggio..."
                      required></textarea>
        </div>

        {{-- Pulsanti --}}
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Invia
        </button>

        <a href="{{ route('tenant.messages.index') }}" class="btn btn-secondary ml-2">
            Annulla
        </a>

    </form>

</x-adminlte-card>

@stop
