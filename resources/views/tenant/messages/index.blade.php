@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">I tuoi messaggi</h1>
<a href="{{ route('tenant.messages.create') }}"
   class="btn btn-primary mb-4">
    Nuovo messaggio
</a>

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
