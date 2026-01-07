@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $message->subject }}</h1>

<div class="bg-white p-4 shadow rounded mb-6">
    <p>{{ $message->message }}</p>
    <p class="text-gray-500 text-sm mt-2">
        Da: {{ $message->tenant->name }} — {{ $message->created_at->format('d/m/Y H:i') }}
    </p>
</div>

<h2 class="text-xl font-semibold mb-4">Rispondi</h2>

<form method="POST" action="{{ route('landlord.messages.store') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="tenant_id" value="{{ $message->tenant_id }}">
    <input type="hidden" name="parent_id" value="{{ $message->id }}">

    <textarea name="message" placeholder="Scrivi una risposta..."
              class="w-full p-2 border rounded h-32"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Rispondi
    </button>
</form>
@endsection
