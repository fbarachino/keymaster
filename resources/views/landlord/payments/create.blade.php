@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nuovo pagamento</h1>

<form method="POST" action="{{ route('landlord.payments.store') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block font-semibold mb-1">Contratto</label>
        <select name="lease_id" class="w-full p-2 border rounded">
            @foreach($leases as $lease)
                <option value="{{ $lease->id }}">
                    {{ $lease->tenant->name }} — {{ $lease->unit->property->name }} / {{ $lease->unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Data scadenza</label>
        <input type="date" name="due_date" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Data pagamento</label>
        <input type="date" name="paid_date" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Importo (€)</label>
        <input type="number" step="0.01" name="amount" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Stato</label>
        <select name="status" class="w-full p-2 border rounded">
            <option value="pending">In sospeso</option>
            <option value="paid">Pagato</option>
            <option value="overdue">In ritardo</option>
        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Crea pagamento</button>
</form>
@endsection
