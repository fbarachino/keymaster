@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $thread->subject ?? 'Conversazione' }}</h1>

<div class="space-y-4">
    @foreach($thread->messages as $msg)
        <div class="p-3 rounded shadow
            {{ $msg->sender === 'tenant' ? 'bg-blue-100 ml-6' : 'bg-gray-100 mr-6' }}">
            <p>{{ $msg->message }}</p>
            <p class="text-sm text-gray-500 mt-1">
                {{ $msg->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route($role.'.messages.reply', $thread) }}" class="mt-6">
    @csrf
    <textarea name="message" class="w-full p-2 border rounded h-24"></textarea>
    <button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Invia</button>
</form>
@endsection
