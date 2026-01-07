@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Pagamenti</h1>

<a href="{{ route('landlord.payments.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo pagamento
</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-3 text-left">Inquilino</th>
            <th class="p-3 text-left">Unità</th>
            <th class="p-3 text-left">Scadenza</th>
            <th class="p-3 text-left">Importo</th>
            <th class="p-3 text-left">Stato</th>
            <th class="p-3 text-center">Azioni</th>
        </tr>
    </thead>

    <tbody>
        @foreach($payments as $payment)
        <tr class="border-b">
            <td class="p-3">{{ $payment->lease->tenant->name }}</td>
            <td class="p-3">{{ $payment->lease->unit->name }}</td>
            <td class="p-3">{{ $payment->due_date->format('d/m/Y') }}</td>
            <td class="p-3">€ {{ number_format($payment->amount, 2, ',', '.') }}</td>
            <td class="p-3">{{ ucfirst($payment->status) }}</td>
            <td class="p-3 text-center">
                <a href="{{ route('landlord.payments.edit', $payment) }}" class="text-blue-600">Modifica</a>
                <form action="{{ route('landlord.payments.destroy', $payment) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-600 ml-2">Elimina</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
