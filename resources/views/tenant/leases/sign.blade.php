@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Firma contratto</h1>

<div class="bg-white p-4 shadow rounded space-y-4">
    <p><strong>Unità:</strong> {{ $lease->unit->property->name }} — {{ $lease->unit->name }}</p>
    <p><strong>Periodo:</strong> {{ $lease->start_date->format('d/m/Y') }}
        @if($lease->end_date) - {{ $lease->end_date->format('d/m/Y') }} @endif
    </p>
    <p><strong>Canone:</strong> € {{ number_format($lease->rent_amount, 2, ',', '.') }}</p>

    <hr>

    <p class="text-sm text-gray-700">
        Confermando, dichiari di aver letto, compreso e accettato tutte le clausole del contratto.
    </p>

    <form method="POST" action="{{ route('tenant.leases.sign.perform', $lease) }}" class="space-y-4">
        @csrf

        <label class="flex items-center gap-2">
            <input type="checkbox" name="accept">
            Confermo di accettare il contratto.
        </label>

        <button class="button btn-primary rounded">
            Firma digitalmente
        </button>
    </form>
</div>
@endsection
