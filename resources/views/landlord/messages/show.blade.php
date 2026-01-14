@extends('adminlte::page')

@section('title', $thread->subject ?? 'Conversazione')

@section('content_header')
    <h1>{{ $thread->subject ?? 'Conversazione' }}</h1>
@stop

@section('content')

<div class="card card-primary card-outline direct-chat direct-chat-primary">

    <div class="card-header">
        <h3 class="card-title">
            Conversazione con {{ $thread->tenant->name }}
        </h3>
    </div>

    <div class="card-body">

        <div class="direct-chat-messages">

            @foreach($messages as $msg)

                {{-- Messaggio del tenant --}}
                @if($msg->sender === 'tenant')
                    <div class="direct-chat-msg">

                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">
                                {{ $thread->tenant->name }}
                            </span>
                            <span class="direct-chat-timestamp float-right">
                                {{ $msg->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <div class="direct-chat-text">
                            {{ $msg->message }}
                        </div>

                    </div>

                {{-- Messaggio del landlord --}}
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

    <div class="card-footer">

        <form method="POST" action="{{ route('landlord.messages.reply', $thread) }}">
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

<a href="{{ route('landlord.messages.index') }}" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left"></i> Torna ai messaggi
</a>

@stop
