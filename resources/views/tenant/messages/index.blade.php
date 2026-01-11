@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">I tuoi messaggi</h1>

<a href="{{ route('tenant.messages.create') }}"
   class="btn btn-primary mb-4">
    Nuovo messaggio
</a>
<x-adminlte-card theme="purple" icon="fas fa-lg fa-envelope" title="Messaggi recenti">
<div class="mt-6 space-y-4">
    @foreach($messages as $message)
        <div class="bg-white p-4 shadow rounded">
            <p class="font-semibold">{{ $message->subject }}</p>
            <p class="text-gray-600 text-sm">{{ $message->created_at->format('d/m/Y H:i') }}</p>

            <a href="{{ route('tenant.messages.show', $message) }}"
               class="text-blue-600 mt-2 inline-block">
                Apri conversazione
            </a>
        </div>
    @endforeach
</div>
</x-adminlte-card>
@endsection
