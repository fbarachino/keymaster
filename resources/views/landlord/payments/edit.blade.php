@extends('adminlte::page')

@section('title', 'Modifica pagamento')

@section('content_header')
    <h1>Modifica pagamento</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('landlord.payments.update', $payment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Contratto</label>
                <input type="text" class="form-control" value="{{ $payment->lease->property->name }}" disabled>
            </div>

            <div class="form-group">
                <label>Inquilino</label>
                <input type="text" class="form-control" value="{{ $payment->tenant->name }}" disabled>
            </div>

            <div class="form-group">
                <label for="due_date">Data scadenza</label>
                <input type="date" name="due_date" id="due_date" class="form-control"
                       value="{{ $payment->due_date->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="amount_total">Importo</label>
                <input type="number" step="0.01" name="amount_total" id="amount_total" class="form-control"
                       value="{{ $payment->amount_total }}" required>
            </div>

            <div class="form-group">
                <label for="status">Stato</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending" @selected($payment->status === 'pending')>Da pagare</option>
                    <option value="paid" @selected($payment->status === 'paid')>Pagato</option>
                </select>
            </div>

            <div class="form-group">
                <label for="paid_date">Data pagamento</label>
                <input type="date" name="paid_date" id="paid_date" class="form-control"
                       value="{{ $payment->paid_date ? $payment->paid_date->format('Y-m-d') : '' }}">
            </div>

            <div class="form-group">
                <label for="description">Descrizione</label>
                <input type="text" name="description" id="description" class="form-control"
                       value="{{ $payment->description }}">
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('landlord.payments.index') }}" class="btn btn-secondary">Annulla</a>
        </form>

    </div>
</div>
@endsection
