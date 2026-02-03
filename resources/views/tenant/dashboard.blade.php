
 @extends('layouts.admin')

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
