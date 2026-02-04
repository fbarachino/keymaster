@extends('layouts.admin')

@section('title', 'Dettaglio spesa')

@section('content_header')
    <h1>Dettaglio spesa</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <dl class="row">

            <dt class="col-sm-3">Categoria</dt>
            <dd class="col-sm-9">{{ ucfirst($expense->category) }}</dd>

            <dt class="col-sm-3">Descrizione</dt>
            <dd class="col-sm-9">{{ $expense->description ?? '-' }}</dd>

            <dt class="col-sm-3">Quota personale</dt>
            <dd class="col-sm-9">{{ number_format($expense->amount_tenant, 2, ',', '.') }} €</dd>

            <dt class="col-sm-3">Data spesa</dt>
            <dd class="col-sm-9">{{ $expense->expense_date->format('d/m/Y') }}</dd>

        </dl>

        <a href="{{ route('tenant.expenses.index') }}" class="btn btn-secondary">Torna alle spese</a>

    </div>
</div>

@endsection
