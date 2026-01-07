@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Messaggi dagli inquilini</h1>

<div class="space-y-4">
    @foreach($messages as $message)
        <div class="bg-white p-4 shadow rounded">
            <p class="font-semibold">{{ $message->subject }}</p>
            <p class="text-gray-600 text-sm">
                Da: {{ $message->tenant->name }} — {{ $message->created_at->format('d/m/Y H:i') }}
            </p>

            <a href="{{ route('landlord.messages.show', $message) }}"
               class="text-blue-600 mt-2 inline-block">
                Apri conversazione
            </a>
        </div>
    @endforeach
</div>
@endsection
