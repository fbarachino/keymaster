@extends('adminlte::page')

@section('title', 'Nuovo messaggio')

@section('content_header')
    <h1>Nuovo messaggio</h1>
@stop

@section('content')

<x-adminlte-card theme="purple" icon="fas fa-lg fa-envelope" title="Invia un nuovo messaggio">

    <form method="POST" action="{{ route('landlord.messages.store') }}">
        @csrf

        {{-- Destinatario --}}
        <div class="form-group">
        <label for="tenant_ids">Destinatari</label>
            <select name="tenant_ids[]" id="tenant_ids" class="form-control" multiple required>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">
                        {{ $tenant->name }}
                    </option>
                @endforeach
            </select>

            <small class="form-text text-muted">
                Tieni premuto CTRL (Windows) o CMD (Mac) per selezionare più inquilini.
            </small>
        </div>


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

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Invia
        </button>

        <a href="{{ route('landlord.messages.index') }}" class="btn btn-secondary ml-2">
            Annulla
        </a>

    </form>

</x-adminlte-card>

@stop
