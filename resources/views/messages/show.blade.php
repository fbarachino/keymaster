{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Messaggio</h1>

<div class="bg-white shadow p-6 rounded space-y-4">
    <p><strong>Da:</strong> {{ $message->sender->name }}</p>
    <p><strong>A:</strong> {{ $message->receiver->name }}</p>
    <p class="mt-4">{{ $message->content }}</p>
</div>

<a href="{{ route('messages.index') }}" class="text-blue-600 mt-4 inline-block">← Torna ai messaggi</a>
@endsection
 --}}
 @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $thread->subject ?? 'Conversazione' }}</h1>
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

<form method="POST" action="{{ route($role.'.messages.reply', $thread) }}" class="mt-6">
    @csrf
    <textarea name="message" class="w-full p-2 border rounded h-24"></textarea>
    <button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Invia</button>
</form>
    </div>
</div>
@endsection
