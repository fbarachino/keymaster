@extends('layouts.admin')

@section('title', 'Messaggi')

@section('content_header')
    <h1>I tuoi messaggi</h1>
@stop

@section('content')

<div class="mb-3">
    <a href="{{ route('tenant.messages.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuovo messaggio
    </a>
</div>

<div class="row">

    @forelse($threads as $thread)
        <div class="col-md-6">
            <a href="{{ route('tenant.messages.show', $thread) }}" class="text-dark">
                <div class="card shadow-sm">

                    <div class="card-body">

                        {{-- Oggetto conversazione --}}
                        <h5 class="card-title font-weight-bold">
                            {{ $thread->subject ?? 'Conversazione' }}
                        </h5>

                        {{-- Landlord --}}
                        <p class="text-muted mb-1">
                            <i class="fas fa-user"></i>
                            Landlord: <strong>{{ $thread->landlord->name }}</strong>
                        </p>

                        {{-- Ultimo messaggio --}}
                        @if($thread->lastMessage)
                            <p class="text-muted small">
                                <i class="fas fa-comment"></i>
                                Ultimo messaggio:
                                {{ Str::limit($thread->lastMessage->content, 60) }}
                            </p>
                        @endif

                    </div>

                </div>
            </a>
        </div>

    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Nessun messaggio presente.
            </div>
        </div>
    @endforelse

</div>

@stop
