@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Inquilino</h1>
    <div class="row">
        <div class="col-md-3">
        <x-adminlte-info-box title="Contratti Attivi" text="{{ $leases->count() }}" icon="fas fa-lg fa-download" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Pagamenti in sospeso" text="{{ $pending }}" icon="fas fa-lg fa-coins" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Messaggi non letti" text="{{ $unread }}" icon="fas fa-lg fa-file" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Ticket aperti" text="{{ $openTickets }}" icon="fas fa-lg fa-ticket-alt" icon-theme="purple" url="{{ route('tenant.tickets.index') }}"/>
        </div>

</div>
<div class="row">
    <div class="col">
    {{-- <h2 class="text-xl font-semibold mb-4">Ultime note ai ticket</h2> --}}
    <x-adminlte-card theme="purple" icon="fas fa-lg fa-comments" title="Note recenti sui ticket">

    @forelse($ticketNotes as $note)
        <div class="border-b pb-2 mb-2">
            <p class="text-gray-700">{{ $note->note }}</p>
            <p class="text-sm text-gray-500">
                Ticket: {{ $note->ticket->title }}<br>
                {{ $note->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    @empty
        <p class="text-gray-500">Nessuna nota recente.</p>
    @endforelse

    <a href="{{ route('tenant.tickets.index') }}" class="text-blue-600 underline mt-2 inline-block">
        Vai ai ticket
    </a>
    </x-adminlte-card>
    </div>
<div class="col">
    {{-- <h2 class="text-xl font-semibold mb-4">Messaggi dal landlord</h2> --}}
    <x-adminlte-card theme="purple" icon="fas fa-lg fa-envelope" title="Messaggi recenti">
    @forelse($threads as $msg)

        <div class="border-b pb-2 mb-2">
            <p class="font-semibold"><strong>{{ $msg->subject ?? 'Senza oggetto' }}</strong></p>
            <p class="text-gray-700">{{ Str::limit($msg->message, 80) }}</p>
            <p class="text-sm text-gray-500">{{ $msg->created_at->format('d/m/Y H:i') }}</p>
        </div>
    @empty
        <p class="text-gray-500">Nessun messaggio recente.</p>
    @endforelse

    <a href="{{ route('tenant.messages.index') }}" class="text-blue-600 underline mt-2 inline-block">
        Vai ai messaggi
    </a>
    </x-adminlte-card>
</div>
</div>
@endsection
