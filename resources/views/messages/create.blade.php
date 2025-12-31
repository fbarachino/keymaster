@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nuovo messaggio</h1>

<form method="POST" action="{{ route('messages.store') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block font-semibold mb-1">Destinatario</label>
        <select name="receiver_id" class="w-full p-2 border rounded">
            @foreach($users as $user)
                @if($user->id !== auth()->id())
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                @endif
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Messaggio</label>
        <textarea name="content" class="w-full p-2 border rounded" rows="5"></textarea>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Invia</button>
</form>
@endsection
