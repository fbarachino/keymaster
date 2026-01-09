@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Contratti attivi</h1>

<div class="space-y-4">
    @forelse($leases as $lease)
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold">
                {{ $lease->unit->property->name }} — {{ $lease->unit->name }}
            </h2>

            <p class="text-gray-600">
                <strong>Inizio:</strong> {{ $lease->start_date?->format('d/m/Y') }}<br>
                @if($lease->end_date)
                    <strong>Fine:</strong> {{ $lease->end_date->format('d/m/Y') }}<br>
                @endif
                <strong>Canone:</strong> € {{ number_format($lease->rent_amount, 2, ',', '.') }}<br>
                @if($lease->deposit_amount)
                    <strong>Deposito:</strong> € {{ number_format($lease->deposit_amount, 2, ',', '.') }}
                @endif
                <a href="{{ route('landlord.leases.pdf', $lease) }}"
                class="text-blue-600 underline ml-2"
                target="_blank">
                    Scarica PDF
                </a>
                @if(!$lease->signed_by_tenant_at)
                    <a href="{{ route('tenant.leases.sign.show', $lease) }}"
                    class="button btn-primary rounded">
                        Firma digitalmente
                    </a>
                @else
                    <span class="text-green-700 font-semibold ml-2">
                        Firmato il {{ $lease->signed_by_tenant_at->format('d/m/Y') }}
                    </span>
                @endif
                @if($lease->signed_by_tenant_at)
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">
                        Firmato
                    </span>
                @else
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-sm">
                        In attesa firma
                    </span>
                @endif
            </p>
        </div>
    @empty
        <p>Nessun contratto attivo al momento.</p>
    @endforelse
</div>
@endsection
