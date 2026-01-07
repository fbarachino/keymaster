@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nuovo messaggio</h1>

<form method="POST" action="{{ route('tenant.messages.store') }}" class="space-y-4">
    @csrf

    <input type="text" name="subject" placeholder="Oggetto"
           class="w-full p-2 border rounded">

    <textarea name="message" placeholder="Scrivi il tuo messaggio..."
              class="w-full p-2 border rounded h-40"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Invia
    </button>
</form>
@endsection
