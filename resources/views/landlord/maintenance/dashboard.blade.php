@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Manutenzioni</h1>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 shadow rounded">Aperti: {{ $stats['open'] }}</div>
    <div class="bg-white p-4 shadow rounded">In corso: {{ $stats['in_progress'] }}</div>
    <div class="bg-white p-4 shadow rounded">Chiusi: {{ $stats['closed'] }}</div>
</div>

<h2 class="text-xl font-semibold mb-4">Ticket recenti</h2>

@foreach($tickets as $ticket)
<div class="bg-white p-4 shadow rounded mb-3">
    <strong>{{ $ticket->title }}</strong>
    <p>{{ $ticket->description }}</p>
    <p class="text-sm text-gray-500">
        {{ $ticket->tenant->name }} — {{ $ticket->unit->name }}
    </p>
</div>
@endforeach
@endsection
