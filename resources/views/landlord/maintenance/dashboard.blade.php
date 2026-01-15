{{-- @extends('layouts.portal')

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
 --}}
 @extends('adminlte::page')

@section('title', 'Dashboard Manutenzioni')

@section('content_header')
    <h1>Dashboard Manutenzioni</h1>
@stop

@section('content')

{{-- ===========================
    INFO BOX
=========================== --}}
<div class="row">

    <div class="col-md-4">
        <x-adminlte-info-box
            title="Ticket aperti"
            text="{{ $open }}"
            icon="fas fa-ticket-alt"
            icon-theme="purple"
        />
    </div>

    <div class="col-md-4">
        <x-adminlte-info-box
            title="In lavorazione"
            text="{{ $inProgress }}"
            icon="fas fa-tools"
            icon-theme="purple"
        />
    </div>

    <div class="col-md-4">
        <x-adminlte-info-box
            title="Chiusi"
            text="{{ $closed }}"
            icon="fas fa-check-circle"
            icon-theme="purple"
        />
    </div>

</div>


{{-- ===========================
    TICKET RECENTI
=========================== --}}
<div class="card mt-5">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i> Ticket recenti
        </h3>
    </div>

    <div class="card-body">

        @forelse($recent as $ticket)
            <div class="card mb-3 shadow-sm">

                <div class="card-body">

                    <h4 class="font-weight-bold mb-1">
                        {{ $ticket->title }}
                    </h4>

                    <p class="text-muted mb-1">
                        {{ $ticket->unit->property->name }} — {{ $ticket->unit->name }}
                    </p>

                    <p class="text-muted small mb-2">
                        {{ $ticket->created_at->diffForHumans() }}
                    </p>

                    <a href="{{ route('landlord.tickets.show', $ticket) }}"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-tools"></i> Gestisci
                    </a>

                </div>

            </div>
        @empty
            <p class="text-muted">Nessun ticket recente.</p>
        @endforelse

    </div>
</div>

@stop
