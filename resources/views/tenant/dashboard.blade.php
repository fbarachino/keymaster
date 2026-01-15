{{-- @extends('layouts.portal')

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
 --}}
 @extends('adminlte::page')

@section('title', 'Dashboard Inquilino')

@section('content_header')
    <h1>Dashboard Inquilino</h1>
@stop

@section('content')

{{-- ===========================
    INFO BOX
=========================== --}}
<div class="row">

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Contratti Attivi"
            text="{{ $leases->count() }}"
            icon="fas fa-file-contract"
            icon-theme="purple"
        />
    </div>

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Pagamenti in sospeso"
            text="{{ $pending }}"
            icon="fas fa-coins"
            icon-theme="purple"
        />
    </div>

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Messaggi non letti"
            text="{{ $unread }}"
            icon="fas fa-envelope-open-text"
            icon-theme="purple"
        />
    </div>

    <div class="col-md-3">
        <x-adminlte-info-box
            title="Ticket aperti"
            text="{{ $openTickets }}"
            icon="fas fa-ticket-alt"
            icon-theme="purple"
            url="{{ route('tenant.tickets.index') }}"
        />
    </div>

</div>


{{-- ===========================
    NOTE RECENTI SUI TICKET
=========================== --}}
<div class="row mt-4">

    <div class="col-md-6">
        <x-adminlte-card theme="purple" icon="fas fa-comments" title="Note recenti sui ticket">

            @forelse($ticketNotes as $note)
                <div class="pb-2 mb-3 border-bottom">
                    <p class="mb-1">{{ $note->note }}</p>
                    <p class="text-muted small mb-0">
                        Ticket: <strong>{{ $note->ticket->title }}</strong><br>
                        {{ $note->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-muted">Nessuna nota recente.</p>
            @endforelse

            <a href="{{ route('tenant.tickets.index') }}" class="btn btn-link p-0 mt-2">
                Vai ai ticket
            </a>

        </x-adminlte-card>
    </div>


    {{-- ===========================
        MESSAGGI RECENTI
    =========================== --}}
    <div class="col-md-6">
        <x-adminlte-card theme="purple" icon="fas fa-envelope" title="Messaggi recenti">

            @forelse($threads as $msg)
                <div class="pb-2 mb-3 border-bottom">
                    <p class="font-weight-bold mb-1">
                        {{ $msg->subject ?? 'Senza oggetto' }}
                    </p>

                    <p class="mb-1">
                        {{ Str::limit($msg->message, 80) }}
                    </p>

                    <p class="text-muted small mb-0">
                        {{ $msg->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-muted">Nessun messaggio recente.</p>
            @endforelse

            <a href="{{ route('tenant.messages.index') }}" class="btn btn-link p-0 mt-2">
                Vai ai messaggi
            </a>

        </x-adminlte-card>
    </div>

</div>

@stop
