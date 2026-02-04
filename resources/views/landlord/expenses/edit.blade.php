@extends('layouts.admin')

@section('title', 'Modifica spesa')

@section('content_header')
    <h1>Modifica spesa</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('landlord.expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="property_id">Proprietà</label>
                <select name="property_id" id="property_id" class="form-control" required>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}" @selected($property->id == $expense->property_id)>
                            {{ $property->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="lease_id">Contratto</label>
                <select name="lease_id" id="lease_id" class="form-control" required>
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}" @selected($lease->id == $expense->lease_id)>
                            {{ $lease->property->name }} — {{ $lease->tenants->pluck('name')->join(', ') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tenant_id">Inquilino (opzionale)</label>
                <select name="tenant_id" id="tenant_id" class="form-control">
                    <option value="">— Spesa condivisa —</option>
                    @foreach($leases as $lease)
                        @foreach($lease->tenants as $tenant)
                            <option value="{{ $tenant->id }}" @selected($tenant->id == $expense->tenant_id)>
                                {{ $tenant->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" id="category" class="form-control"
                       value="{{ $expense->category }}" required>
            </div>

            <div class="form-group">
                <label for="description">Descrizione</label>
                <input type="text" name="description" id="description" class="form-control"
                       value="{{ $expense->description }}">
            </div>

            <div class="form-group">
                <label for="amount_total">Importo totale</label>
                <input type="number" step="0.01" name="amount_total" id="amount_total" class="form-control"
                       value="{{ $expense->amount_total }}" required>
            </div>

            <div class="form-group">
                <label for="amount_tenant">Quota inquilino</label>
                <input type="number" step="0.01" name="amount_tenant" id="amount_tenant" class="form-control"
                       value="{{ $expense->amount_tenant }}">
            </div>

            <div class="form-group">
                <label for="expense_date">Data spesa</label>
                <input type="date" name="expense_date" id="expense_date" class="form-control"
                       value="{{ $expense->expense_date->format('Y-m-d') }}" required>
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('landlord.expenses.index') }}" class="btn btn-secondary">Annulla</a>

        </form>

    </div>
</div>

@endsection
