@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Pagamenti ricevuti</h1>

<a href="{{ route('landlord.payments.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
    Registra nuovo pagamento
</a>

@if($payments->isEmpty())
    <p class="text-gray-600">Nessun pagamento registrato.</p>
@else
    <div class="space-y-4">
        @foreach($payments as $payment)
            <div class="p-4 bg-white shadow rounded">
                <p class="font-semibold">
                    € {{ number_format($payment->amount, 2, ',', '.') }}
                </p>
                <p class="text-sm text-gray-600">
                    Tenant: {{ $payment->lease->tenant->name }}
                </p>
                <p class="text-sm text-gray-600">
                    Data: {{ $payment->created_at->format('d/m/Y') }}
                </p>

            </div>
        @endforeach
    </div>
@endif
@endsection
