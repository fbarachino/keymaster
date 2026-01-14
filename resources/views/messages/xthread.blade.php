@extends('adminlte::page')

@section('title', $thread->subject ?? 'Conversazione')

@section('content_header')
    <h1>{{ $thread->subject ?? 'Conversazione' }}</h1>
@stop

@section('content')

<div class="card card-primary card-outline direct-chat direct-chat-primary">

    {{-- Header --}}
    <div class="card-header">
        <h3 class="card-title">
            Conversazione con
            @if($role === 'tenant')
                {{ $thread->landlord->name }}
            @else
                {{ $thread->tenant->name }}
            @endif
        </h3>
    </div>

    {{-- Corpo chat --}}
    <div class="card-body">

        <div class="direct-chat-messages">

            @foreach($thread->messages as $msg)

                {{-- Messaggio dell'altro utente --}}
                @if($msg->sender !== $role)
                    <div class="direct-chat-msg">

                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">
                                @if($msg->sender === 'tenant')
                                    {{ $thread->tenant->name }}
                                @else
                                    {{ $thread->landlord->name }}
                                @endif
                            </span>
                            <span class="direct-chat-timestamp float-right">
                                {{ $msg->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <div class="direct-chat-text">
                            {{ $msg->message }}
                        </div>

                    </div>

                {{-- Messaggio dell'utente corrente --}}
                @else
                    <div class="direct-chat-msg right">

                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-right">Tu</span>
                            <span class="direct-chat-timestamp float-left">
                                {{ $msg->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <div class="direct-chat-text bg-primary text-white">
                            {{ $msg->message }}
                        </div>

                    </div>
                @endif

            @endforeach

        </div>

    </div>

    {{-- Footer: form risposta --}}
    <div class="card-footer">

        <form method="POST" action="{{ route($role.'.messages.reply', $thread) }}">
            @csrf

            <div class="input-group">
                <textarea name="message"
                          class="form-control"
                          placeholder="Scrivi una risposta..."
                          rows="2"
                          required></textarea>

                <div class="input-group-append">
                    <button class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Invia
                    </button>
                </div>
            </div>

        </form>

    </div>

</div>

{{-- Pulsante torna indietro --}}
<a href="{{ route($role.'.messages.index') }}" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left"></i> Torna ai messaggi
</a>

@stop
