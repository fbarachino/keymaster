@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $ticket->title }}</h1>

<div class="bg-white p-4 shadow rounded space-y-4">
    <p><strong>Inquilino:</strong> {{ $ticket->tenant->name }}</p>
    <p><strong>Unità:</strong> {{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}</p>
    <p><strong>Descrizione:</strong> {{ $ticket->description }}</p>
    <p><strong>Stato:</strong> {{ ucfirst($ticket->status) }}</p>
    <p><strong>Priorità:</strong> {{ ucfirst($ticket->priority) }}</p>

    @if($ticket->attachments)
        <div>
            <strong>Allegati:</strong>
            <div class="flex gap-4 mt-2">
                @foreach($ticket->attachments as $file)
                    <img src="{{ asset('storage/' . $file) }}" class="w-32 rounded shadow">
                @endforeach
            </div>
        </div>
    @endif
</div>

<h2 class="text-xl font-semibold mt-6 mb-4">Note</h2>

<div class="space-y-4">
    @foreach($ticket->notes as $note)
        <div class="bg-gray-100 p-3 rounded">
            <p>{{ $note->note }}</p>
            <p class="text-sm text-gray-600 mt-1">
                {{ $note->user->name }} — {{ $note->created_at->format('d/m/Y H:i') }}
                @if($note->is_internal)
                    <span class="text-red-600">(Interna)</span>
                @endif
            </p>
        </div>
    @endforeach
</div>

<h2 class="text-xl font-semibold mt-6 mb-4">Aggiungi nota</h2>

<form method="POST" action="{{ route('landlord.tickets.notes', $ticket) }}" class="space-y-4">
    @csrf

    <textarea name="note" class="w-full p-2 border rounded h-32" placeholder="Scrivi una nota..."></textarea>

    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_internal">
        Nota interna (visibile solo a te)
    </label>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Aggiungi nota</button>
</form>

<h2 class="text-xl font-semibold mt-6 mb-4">Aggiorna stato</h2>

<form method="POST" action="{{ route('landlord.tickets.status', $ticket) }}" class="space-y-4">
    @csrf

    <select name="status" class="w-full p-2 border rounded">
        <option value="open">Aperto</option>
        <option value="in_progress">In lavorazione</option>
        <option value="closed">Chiuso</option>
    </select>

    <button class="bg-green-600 text-white px-4 py-2 rounded">Aggiorna stato</button>
</form>
@endsection
