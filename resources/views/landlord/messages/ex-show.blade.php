@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    {{ $thread->subject ?? 'Conversazione' }}
</h1>
<div class="card-direct-chat direct-chat-primary">
    <div class="card-header">
        <h3 class="card-title">Conversazione con {{ $thread->tenant->name }}</h3>
    </div>
    <div class="card-body">
<div class="direct-chat-messages">
    @foreach($messages as $msg)
        <div class="direct-chat-msg {{ $msg->sender === 'tenant' ? '' : 'right' }}">
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name {{ $msg->sender === 'tenant' ? 'float-left' : 'float-right' }}">
                    {{ $msg->sender === 'tenant' ? $thread->tenant->name : 'Tu' }}
                </span>
                <span class="direct-chat-timestamp {{ $msg->sender === 'tenant' ? 'float-right' : 'float-left' }}">
                    {{ $msg->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
            <div class="direct-chat-text ">
                <p>{{ $msg->message }}</p>
            </div>
        </div>
    @endforeach
</div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <form method="POST" action="{{ route('landlord.messages.reply', $thread) }}" class="mt-6">
            @csrf
            <textarea name="message" class="form-control" placeholder="Scrivi una risposta..."></textarea>
            <button class="btn btn-primary mt-2" type="submit">
                Invia
            </button>
        </form>
    </div>
</div>

@endsection
