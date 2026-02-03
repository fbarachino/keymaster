@extends('adminlte::page')

@section('title', 'Dettaglio pagamento')

@section('content_header')
    <h1>Dettaglio pagamento</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <dl class="row">
            <dt class="col-sm-3">Proprietà</dt>
            <dd class="col-sm-9">{{ $payment->lease->property->name }}</dd>

            <dt class="col-sm-3">Inquilino</dt>
            <dd class="col-sm-9">{{ $payment->tenant->name }}</dd>

            <dt class="col-sm-3">Scadenza</dt>
            <dd class="col-sm-9">{{ $payment->due_date }}</dd>

            <dt class="col-sm-3">Importo</dt>
            <dd class="col-sm-9">{{ number_format($payment->amount_total, 2, ',', '.') }} €</dd>

            <dt class="col-sm-3">Stato</dt>
            <dd class="col-sm-9">
                @if($payment->status === 'paid')
                    <span class="badge badge-success">Pagato</span>
                @else
                    <span class="badge badge-warning">Da pagare</span>
                @endif
            </dd>

            <dt class="col-sm-3">Data pagamento</dt>
            <dd class="col-sm-9">{{ $payment->paid_date ?? '-' }}</dd>

            <dt class="col-sm-3">Descrizione</dt>
            <dd class="col-sm-9">{{ $payment->description ?? '-' }}</dd>
        </dl>

        <a href="{{ route('landlord.payments.edit', $payment) }}" class="btn btn-primary">Modifica</a>
        <a href="{{ route('landlord.payments.index') }}" class="btn btn-secondary">Torna all’elenco</a>

    </div>
</div>
@endsection
