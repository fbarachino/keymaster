@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Registra un pagamento</h1>

<form method="POST" action="{{ route('landlord.payments.store') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block font-semibold mb-1">Tenant</label>
        <select name="tenant_id" class="w-full p-2 border rounded">
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Importo (€)</label>
        <input type="number" step="0.01" name="amount" class="w-full p-2 border rounded">
    </div>

    <div>
        <label class="block font-semibold mb-1">Riferimento (opzionale)</label>
        <input type="text" name="reference" class="w-full p-2 border rounded">
    </div>
    <div>
        <label class="block font-semibold mb-1">Data scadenza</label>
        <input type="date" name="due_date" class="w-full p-2 border rounded" required>
    </div>

    <div>
        <label class="block font-semibold mb-1">Note (opzionale)</label>
        <textarea name="notes" class="w-full p-2 border rounded h-24"></textarea>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Salva pagamento
    </button>
</form>
@endsection
