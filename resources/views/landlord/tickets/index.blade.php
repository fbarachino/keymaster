@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Ticket di manutenzione</h1>

<div class="space-y-4">
    @foreach($tickets as $ticket)
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-xl font-semibold">{{ $ticket->title }}</h2>
            <p class="text-gray-600">
                {{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}
                ({{ $ticket->tenant->name }})
            </p>

            <span class="inline-block mt-2 px-2 py-1 text-sm rounded bg-gray-200">
                Stato: {{ ucfirst($ticket->status) }}
            </span>

            <a href="{{ route('landlord.tickets.show', $ticket) }}" class="text-blue-600 mt-3 inline-block">
                Gestisci ticket
            </a>
        </div>
    @endforeach
</div>
@endsection
