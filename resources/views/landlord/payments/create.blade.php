@extends('adminlte::page')

@section('title', 'Nuovo pagamento')

@section('content_header')
    <h1>Nuovo pagamento</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('landlord.payments.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="lease_id">Contratto</label>
                <select name="lease_id" id="lease_id" class="form-control">
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}">
                            {{ $lease->property->name }} — {{ $lease->tenants->pluck('name')->join(', ') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tenant_id">Inquilino</label>
                <select name="tenant_id" id="tenant_id" class="form-control">
                    @foreach($leases as $lease)
                        @foreach($lease->tenants as $tenant)
                            <option value="{{ $tenant->id }}">
                                {{ $tenant->name }} ({{ $lease->property->name }})
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Data scadenza</label>
                <input type="date" name="due_date" id="due_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="amount_total">Importo</label>
                <input type="number" step="0.01" name="amount_total" id="amount_total" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Descrizione</label>
                <input type="text" name="description" id="description" class="form-control">
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('landlord.payments.index') }}" class="btn btn-secondary">Annulla</a>
        </form>

    </div>
</div>
@endsection
