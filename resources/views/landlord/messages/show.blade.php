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
    <input type="hidden" name="tenant_ids[]" value="{{ $message->tenant_id }}">
    <input type="hidden" name="parent_id" value="{{ $message->id }}">
    <input type="hidden" name="subject" value="Re: {{ $message->subject }}">

    <textarea name="message" placeholder="Scrivi una risposta..."
              class="form-control"></textarea>

    <button class="btn btn-primary">
        Rispondi
    </button>
</form>
@endsection
