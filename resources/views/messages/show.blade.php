@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Messaggio</h1>

<div class="bg-white shadow p-6 rounded space-y-4">
    <p><strong>Da:</strong> {{ $message->sender->name }}</p>
    <p><strong>A:</strong> {{ $message->receiver->name }}</p>
    <p class="mt-4">{{ $message->content }}</p>
</div>

<a href="{{ route('messages.index') }}" class="text-blue-600 mt-4 inline-block">← Torna ai messaggi</a>
@endsection
