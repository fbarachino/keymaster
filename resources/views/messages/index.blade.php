@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Messaggi</h1>

<a href="{{ route('messages.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo messaggio
</a>

<div class="mt-6 space-y-4">
    @foreach($messages as $msg)
    <div class="bg-white shadow p-4 rounded">
        <p class="text-sm text-gray-600">
            Da: <strong>{{ $msg->sender->name }}</strong>
            A: <strong>{{ $msg->receiver->name }}</strong>
        </p>
        <p class="mt-2">{{ $msg->content }}</p>
        <a href="{{ route('messages.show', $msg) }}" class="text-blue-600 text-sm">Apri</a>
    </div>
    @endforeach
</div>
@endsection
