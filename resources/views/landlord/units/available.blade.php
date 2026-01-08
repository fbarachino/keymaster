@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Unità disponibili</h1>

<div class="space-y-4">
    @forelse($units as $unit)
        <div class="bg-white p-4 shadow rounded flex justify-between items-center">
            <div>
                <p class="font-semibold">{{ $unit->property->name }} — {{ $unit->name }}</p>
                @if($unit->description)
                    <p class="text-gray-600 text-sm">{{ $unit->description }}</p>
                @endif
            </div>

            <a href="{{ route('landlord.tenants.index') }}"
            class="bg-blue-600 text-white px-3 py-1 rounded">
                Assegna a un inquilino
            </a>
        </div>
    @empty
        <p>Nessuna unità disponibile al momento.</p>
    @endforelse
</div>
@endsection
