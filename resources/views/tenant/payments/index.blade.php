@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">I miei pagamenti</h1>

@if($payments->isEmpty())
    <p class="text-gray-600">Non hai ancora effettuato pagamenti.</p>
@else
    <div class="space-y-4">
        @foreach($payments as $payment)
            <div class="p-4 bg-white shadow rounded flex justify-between items-center">
                <div>
                    <p class="font-semibold">
                        € {{ number_format($payment->amount, 2, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ $payment->created_at->format('d/m/Y') }}
                    </p>
                    <p class="text-sm">
                        Stato:
                        <span class="{{ $payment->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                </div>

                <a href="{{ route('tenant.payments.show', $payment) }}"
                   class="text-blue-600 underline">
                    Dettagli
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection
