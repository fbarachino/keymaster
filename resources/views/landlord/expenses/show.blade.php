@extends('layouts.admin')

@section('title', 'Dettaglio spesa')

@section('content_header')
    <h1>Dettaglio spesa</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <dl class="row">

            <dt class="col-sm-3">Proprietà</dt>
            <dd class="col-sm-9">{{ $expense->property->name }}</dd>

            <dt class="col-sm-3">Contratto</dt>
            <dd class="col-sm-9">
                {{ $expense->lease->property->name }} —
                {{ $expense->lease->tenants->pluck('name')->join(', ') }}
            </dd>

            <dt class="col-sm-3">Categoria</dt>
            <dd class="col-sm-9">{{ ucfirst($expense->category) }}</dd>

            <dt class="col-sm-3">Descrizione</dt>
            <dd class="col-sm-9">{{ $expense->description ?? '-' }}</dd>

            <dt class="col-sm-3">Importo totale</dt>
            <dd class="col-sm-9">{{ number_format($expense->amount_total, 2, ',', '.') }} €</dd>

            <dt class="col-sm-3">Quota inquilino</dt>
            <dd class="col-sm-9">
                {{ $expense->amount_tenant ? number_format($expense->amount_tenant, 2, ',', '.') . ' €' : '-' }}
            </dd>

            <dt class="col-sm-3">Data spesa</dt>
            <dd class="col-sm-9">{{ $expense->expense_date->format('d/m/Y') }}</dd>

        </dl>

        <a href="{{ route('landlord.expenses.edit', $expense) }}" class="btn btn-primary">Modifica</a>
        <a href="{{ route('landlord.expenses.index') }}" class="btn btn-secondary">Torna all’elenco</a>

    </div>
</div>

@endsection
