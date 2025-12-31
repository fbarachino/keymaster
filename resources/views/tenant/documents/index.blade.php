@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Documenti della tua unità</h1>

@foreach($leases as $lease)
    <h2 class="text-xl font-semibold mb-2">
        {{ $lease->unit->property->name }} — {{ $lease->unit->name }}
    </h2>

    <ul class="mb-6">
        @foreach($lease->unit->documents as $doc)
            <li class="bg-white p-3 shadow rounded mb-2">
                <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="text-blue-600">
                    {{ $doc->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endforeach
@endsection
