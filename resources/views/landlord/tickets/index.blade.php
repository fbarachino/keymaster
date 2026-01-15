{{-- @extends('layouts.portal')

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
 --}}
 @extends('adminlte::page')

@section('title', 'Ticket di manutenzione')

@section('content_header')
    <h1>Ticket di manutenzione</h1>
@stop

@section('content')

<div class="row">
    @foreach($tickets as $ticket)
        <div class="col-md-6">
            <div class="card shadow-sm">

                <div class="card-body">

                    <h4 class="font-weight-bold mb-1">
                        {{ $ticket->title }}
                    </h4>

                    <p class="text-muted mb-2">
                        {{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}
                        ({{ $ticket->tenant->name }})
                    </p>

                    {{-- Badge stato --}}
                    @php
                        $statusColors = [
                            'open' => 'warning',
                            'in_progress' => 'info',
                            'closed' => 'success',
                        ];
                        $color = $statusColors[$ticket->status] ?? 'secondary';
                    @endphp

                    <span class="badge badge-{{ $color }}">
                        Stato: {{ ucfirst($ticket->status) }}
                    </span>

                    <div class="mt-3">
                        <a href="{{ route('landlord.tickets.show', $ticket) }}"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-tools"></i> Gestisci ticket
                        </a>
                    </div>

                </div>

            </div>
        </div>
    @endforeach
</div>

@stop
