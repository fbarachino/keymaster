@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $ticket->title }}</h1>

<div class="bg-white p-4 shadow rounded space-y-4">
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
        @if(!$note->is_internal)
            <div class="bg-gray-100 p-3 rounded">
                <p>{{ $note->note }}</p>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $note->user->name }} — {{ $note->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        @endif
    @endforeach
</div>
@endsection
