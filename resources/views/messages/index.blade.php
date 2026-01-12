{{-- @extends('layouts.portal')

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
@endsection --}}
@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">I tuoi messaggi</h1>

@forelse($threads as $thread)
    <a href="{{ route('tenant.messages.show', $thread) }}">
        <div class="p-4 bg-white shadow rounded mb-3">
            <p class="font-semibold">{{ $thread->subject ?? 'Conversazione' }}</p>
            <p class="text-sm text-gray-600">
                Landlord: {{ $thread->landlord->name }}
            </p>
        </div>
    </a>
@empty
    <p class="text-gray-500">Nessun messaggio presente.</p>
@endforelse
@endsection
