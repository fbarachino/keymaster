@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Manutenzioni</h1>

<div class="row">


    <div class="col md-3 text-center">
        <x-adminlte-info-box title="Ticket aperti" text="{{ $open }}" icon="fas fa-lg fa-ticket-alt" icon-theme="purple"/>

    </div>

    <div class="col md-3 text-center">
        <x-adminlte-info-box title="In lavorazione" text="{{ $inProgress }}" icon="fas fa-lg fa-tools" icon-theme="purple"/>
    </div>

    <div class="col md-3 text-center">
        <x-adminlte-info-box title="Chiusi" text="{{ $closed }}" icon="fas fa-lg fa-check-circle" icon-theme="purple"/>
    </div>

</div>

<h2 class="text-xl font-semibold mt-10 mb-4">Ticket recenti</h2>

<div class="space-y-4">
    @foreach($recent as $ticket)
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-semibold">{{ $ticket->title }}</h3>
            <p class="text-gray-600">{{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}</p>
            <p class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>

            <a href="{{ route('landlord.tickets.show', $ticket) }}" class="text-blue-600 mt-2 inline-block">
                Gestisci
            </a>
        </div>
    @endforeach
</div>
@endsection
