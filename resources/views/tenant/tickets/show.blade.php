{{-- @extends('layouts.portal')

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
 --}}
 @extends('adminlte::page')

@section('title', $ticket->title)

@section('content_header')
    <h1>{{ $ticket->title }}</h1>
@stop

@section('content')

{{-- ===========================
    DETTAGLI TICKET
=========================== --}}
<div class="card card-dark mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-ticket-alt"></i> Dettagli ticket
        </h3>
    </div>

    <div class="card-body">

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

        {{-- Allegati --}}
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
    NOTE
=========================== --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-comments"></i> Note
        </h3>
    </div>

    <div class="card-body">

        @forelse($ticket->notes as $note)
            @if(!$note->is_internal)
                <div class="alert alert-secondary">
                    <p class="mb-1">{{ $note->note }}</p>
                    <p class="text-muted small mb-0">
                        {{ $note->user->name }} — {{ $note->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @endif
        @empty
            <p class="text-muted">Nessuna nota disponibile.</p>
        @endforelse

    </div>
</div>

@stop
