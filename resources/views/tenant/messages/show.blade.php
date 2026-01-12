{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $message->subject }}</h1>

<div class="bg-white p-4 shadow rounded mb-6">
    <p>{{ $message->message }}</p>
    <p class="text-gray-500 text-sm mt-2">
        Inviato il {{ $message->created_at->format('d/m/Y H:i') }}
    </p>
</div>

<h2 class="text-xl font-semibold mb-4">Rispondi</h2>

<form method="POST" action="{{ route('tenant.messages.store') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="parent_id" value="{{ $message->id }}">
    <input type="hidden" name="landlord_id" value="{{ $message->landlord_id }}">
    <input type="hidden" name="tenant_id" value="{{ $message->tenant_id }}">

    <textarea name="message" placeholder="Scrivi una risposta..."
              class="form-control"></textarea>

    <button class="btn btn-primary" type="submit">
        Rispondi
    </button>
</form>
@endsection
 --}}
{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $thread->subject ?? 'Conversazione' }}</h1>

<div class="space-y-4">
    @foreach($messages as $msg)
        <div class="p-3 rounded shadow
            {{ $msg->sender === 'tenant' ? 'bg-blue-100 ml-6' : 'bg-gray-100 mr-6' }}">
            <p>{{ $msg->message }}</p>
            <p class="text-sm text-gray-500 mt-1">
                {{ $msg->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route('tenant.messages.reply', $thread) }}" class="mt-6">
    @csrf
    <textarea name="message" class="w-full p-2 border rounded h-24"></textarea>
    <button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Invia</button>
</form>
@endsection --}}
@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    {{ $thread->subject ?? 'Conversazione' }}
</h1>
<div class="card-direct-chat direct-chat-primary">
    <div class="card-header">
        <h3 class="card-title">Conversazione con {{ $thread->landlord->name }}</h3>
    </div>
    <div class="card-body">
<div class="direct-chat-messages">
    @foreach($messages as $msg)
        <div class="direct-chat-msg {{ $msg->sender === 'landlord' ? '' : 'right' }}">
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name {{ $msg->sender === 'landlord' ? 'float-left' : 'float-right' }}">
                    {{ $msg->sender === 'landlord' ? $thread->landlord->name : 'Tu' }}
                </span>
                <span class="direct-chat-timestamp {{ $msg->sender === 'landlord' ? 'float-right' : 'float-left' }}">
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
        <form method="POST" action="{{ route('tenant.messages.reply', $thread) }}" class="mt-6">
            @csrf
            <textarea name="message" class="form-control" placeholder="Scrivi una risposta..."></textarea>
            <button class="btn btn-primary mt-2" type="submit">
                Invia
            </button>
        </form>
    </div>
</div>

@endsection
