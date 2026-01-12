@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Messaggi dagli inquilini</h1>

<div class="space-y-4">
    @foreach($threads as $thread)
    <a href="{{ route('landlord.messages.show', $thread) }}">
        <div class="p-4 bg-white shadow rounded mb-3">
            <p class="font-semibold">{{ $thread->subject ?? 'Conversazione' }}</p>
            <p class="text-sm text-gray-600">
                Tenant: {{ $thread->tenant->name }}
            </p>
        </div>
    </a>
@endforeach
</div>
@endsection
