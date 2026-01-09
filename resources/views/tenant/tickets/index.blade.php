@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">I tuoi ticket</h1>

<a href="{{ route('tenant.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo ticket
</a>

<div class="mt-6 space-y-4">
    @foreach($tickets as $ticket)
        <x-adminlte-card title="Ticket: TK{{ $ticket->id }} - {{ $ticket->title }}" theme="dark" icon="fas fa-ticket-alt" class="mb-6">
            <h2 class="text-xl font-semibold">{{ $ticket->title }}</h2>
            <p class="text-gray-600">{{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}</p>

            <span class="inline-block mt-2 px-2 py-1 text-sm rounded bg-gray-200">
                Stato: {{ ucfirst($ticket->status) }}
            </span>

            <a href="{{ route('tenant.tickets.show', $ticket) }}" class="text-blue-600 mt-3 inline-block">
                Apri ticket
            </a>
        </x-adminlte-card>
    @endforeach
</div>
@endsection
