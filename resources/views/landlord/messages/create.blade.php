@extends('layouts.portal')

@section('content')

<x-adminlte-card title="Nuovo messaggio" theme="dark" icon="fas fa-envelope" class="mb-6">

<form method="POST" action="{{ route('landlord.messages.store') }}" class="space-y-4">
    @csrf
<div class="row">
    <div class="col mr-4 mb-4">
    <h2 class="text-lg font-semibold">Destinatari</h2>

    <select name="tenant_ids" multiple class="form-control">
        @foreach($tenants as $tenant)
            <option value="{{ $tenant->id }}">
                {{ $tenant->name }} ({{ $tenant->email }})
            </option>
        @endforeach
    </select>
    </div>
    <div class="col mr-4 mb-4">
        <div class="row">
            <div class="col mr-4 mb-4">
    <input type="text" name="subject" placeholder="Oggetto" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Corpo del messaggio</label>
    <textarea name="message" placeholder="Scrivi il messaggio..."
              class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <button class="btn btn-primary">
        Invia messaggio
    </button>
</div>
</form>
</x-adminlte-card>
@endsection
