{{-- @extends('layouts.portal')

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
 --}}
 @extends('adminlte::page')

@section('title', $ticket->title)

@section('content_header')
    <h1>{{ $ticket->title }}</h1>
@stop

@section('content')

{{-- ===========================
    SEZIONE: DETTAGLI TICKET
=========================== --}}
<div class="card card-dark mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tools"></i> Dettagli ticket
        </h3>
    </div>

    <div class="card-body">

        <p><strong>Inquilino:</strong> {{ $ticket->tenant->name }}</p>
        <p><strong>Unità:</strong> {{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}</p>
        <p><strong>Descrizione:</strong> {{ $ticket->description }}</p>

        {{-- Badge stato --}}
        @php
            $statusColors = [
                'open' => 'warning',
                'in_progress' => 'info',
                'closed' => 'success',
            ];
            $color = $statusColors[$ticket->status] ?? 'secondary';
        @endphp

        <p>
            <strong>Stato:</strong>
            <span class="badge badge-{{ $color }}">
                {{ ucfirst($ticket->status) }}
            </span>
        </p>

        <p><strong>Priorità:</strong> {{ ucfirst($ticket->priority) }}</p>

        @if($ticket->attachments)
            <div class="mt-3">
                <strong>Allegati:</strong>
                <div class="row mt-2">
                    @foreach($ticket->attachments as $file)
                        <div class="col-md-2 mb-3">
                            <img src="{{ asset('storage/' . $file) }}"
                                 class="img-fluid rounded shadow">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>



{{-- ===========================
    SEZIONE: NOTE
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-comment"></i> Note</h3>
    </div>

    <div class="card-body">

        @forelse($ticket->notes as $note)
            <div class="alert alert-secondary">
                <p class="mb-1">{{ $note->note }}</p>
                <p class="text-muted mb-0">
                    {{ $note->user->name }} — {{ $note->created_at->format('d/m/Y H:i') }}
                    @if($note->is_internal)
                        <span class="badge badge-danger ml-2">Interna</span>
                    @endif
                </p>
            </div>
        @empty
            <p class="text-muted">Nessuna nota presente.</p>
        @endforelse

    </div>
</div>



{{-- ===========================
    SEZIONE: AGGIUNGI NOTA
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus"></i> Aggiungi nota</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.tickets.notes', $ticket) }}">
            @csrf

            <div class="mb-3">
                <textarea name="note" class="form-control" rows="4"
                          placeholder="Scrivi una nota..."></textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="is_internal" class="form-check-input" id="internalNote">
                <label for="internalNote" class="form-check-label">
                    Nota interna (visibile solo a te)
                </label>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiungi nota
            </button>

        </form>

    </div>
</div>



{{-- ===========================
    SEZIONE: AGGIORNA STATO
=========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-sync"></i> Aggiorna stato</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('landlord.tickets.status', $ticket) }}">
            @csrf

            <div class="mb-3">
                <select name="status" class="form-control">
                    <option value="open">Aperto</option>
                    <option value="in_progress">In lavorazione</option>
                    <option value="closed">Chiuso</option>
                </select>
            </div>

            <button class="btn btn-success">
                <i class="fas fa-check"></i> Aggiorna stato
            </button>

        </form>

    </div>
</div>

@stop
