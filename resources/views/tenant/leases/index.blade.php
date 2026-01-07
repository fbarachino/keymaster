@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">I tuoi contratti di locazione</h1>

@if($leases->isEmpty())
    <p class="text-gray-600">Non hai contratti attivi al momento.</p>
@else
    <div class="space-y-4">
        @foreach($leases as $lease)
            <div class="bg-white p-4 shadow rounded">
                <h2 class="text-xl font-semibold">
                    {{ $lease->unit->property->name }} — {{ $lease->unit->name }}
                </h2>

                <p class="mt-2">
                    <strong>Inizio:</strong> {{ $lease->start_date->format('d/m/Y') }}<br>
                    <strong>Fine:</strong>
                    {{ $lease->end_date ? $lease->end_date->format('d/m/Y') : 'N/D' }}<br>
                    <strong>Affitto mensile:</strong> € {{ number_format($lease->rent_amount, 2, ',', '.') }}
                </p>

                <div class="mt-4 flex gap-4">
                    <a href="{{ route('tenant.leases.show', $lease) }}"
                       class="text-blue-600 font-semibold">
                        Dettagli contratto
                    </a>

                    <a href="{{ route('tenant.leases.pdf', $lease) }}"
                       class="text-green-600 font-semibold">
                        Scarica PDF
                    </a>

                    @if(!$lease->signed_at)
                        <a href="{{ route('tenant.leases.sign.form', $lease) }}"
                           class="text-orange-600 font-semibold">
                            Firma contratto
                        </a>
                    @else
                        <span class="text-gray-600">Firmato il {{ $lease->signed_at->format('d/m/Y') }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
