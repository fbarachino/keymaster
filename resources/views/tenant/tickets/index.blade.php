@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Ticket di manutenzione</h1>

<a href="{{ route('tenant.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo ticket
</a>

<div class="mt-6 space-y-4">
    @foreach($tickets as $ticket)
        <div class="bg-white p-4 shadow rounded">
            <h2 class="font-semibold">{{ $ticket->title }}</h2>
            <p>{{ $ticket->description }}</p>
            <p class="text-sm text-gray-500">Stato: {{ $ticket->status }}</p>
        </div>
    @endforeach
</div>
@endsection
