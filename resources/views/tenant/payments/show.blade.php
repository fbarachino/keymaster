@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dettaglio pagamento</h1>

<div class="p-6 bg-white shadow rounded space-y-4">

    <p><strong>Importo:</strong>
        € {{ number_format($payment->amount, 2, ',', '.') }}
    </p>

    <p><strong>Data pagamento:</strong>
        {{ $payment->created_at->format('d/m/Y H:i') }}
    </p>

    <p><strong>Stato:</strong>
        <span class="{{ $payment->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
            {{ ucfirst($payment->status) }}
        </span>
    </p>

    @if($payment->reference)
        <p><strong>Riferimento transazione:</strong> {{ $payment->reference }}</p>
    @endif

    @if($payment->notes)
        <p><strong>Note:</strong> {{ $payment->notes }}</p>
    @endif

    <a href="{{ route('tenant.payments.index') }}"
       class="text-blue-600 underline block mt-4">
        Torna ai pagamenti
    </a>
</div>
@endsection
