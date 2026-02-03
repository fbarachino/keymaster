@extends('layouts.admin')

@section('title', 'Modifica Pagamento')

@section('content_header')
    <h1>Modifica Pagamento</h1>
@stop

@section('content')

<form action="{{ route('landlord.payments.update', $payment) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">

            {{-- Selezione contratto --}}
            <div class="form-group">
                <label>Contratto</label>
                <select name="lease_id" class="form-control" required>
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}"
                            @selected($lease->id == $payment->lease_id)>
                            #{{ $lease->id }} - {{ $lease->tenants->pluck('name')->join(', ') }} ({{ $lease->unit->property->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo pagamento --}}
            <div class="form-group">
                <label>Tipo di pagamento</label>
                <select name="type" class="form-control" required>
                    <option value="rent" @selected($payment->type === 'rent')>Affitto</option>
                    <option value="deposit" @selected($payment->type === 'deposit')>Cauzione</option>
                    <option value="expense" @selected($payment->type === 'expense')>Spesa imputata</option>
                    <option value="advance-expenses" @selected($payment->type === 'advance-expenses')>Anticipo spese</option>
                    <option value="expense-settlement" @selected($payment->type === 'expense-settlement')>Conguaglio spese</option>
                    <option value="other" @selected($payment->type === 'other')>Altro</option>
                </select>
            </div>

            {{-- Importo --}}
            <div class="form-group">
                <label>Importo</label>
                <input type="number" step="0.01" name="amount" class="form-control"
                       value="{{ $payment->amount }}" required>
            </div>

            {{-- Data scadenza --}}
            <div class="form-group">
                <label>Data scadenza</label>
                <input type="date" name="due_date" class="form-control"
                       value="{{ $payment->due_date }}" required>
            </div>

            {{-- Data pagamento (se già pagato) --}}
            <div class="form-group">
                <label>Data pagamento</label>
                <input type="date" name="paid_date" class="form-control"
                       value="{{ $payment->paid_date }}">
            </div>

            {{-- Riferimento --}}
            <div class="form-group">
                <label>Riferimento</label>
                <input type="text" name="reference" class="form-control"
                       value="{{ $payment->reference }}">
            </div>

            {{-- Note --}}
            <div class="form-group">
                <label>Note</label>
                <textarea name="notes" class="form-control">{{ $payment->notes }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-success">Aggiorna</button>
            <a href="{{ route('landlord.payments.index') }}" class="btn btn-secondary">Annulla</a>
        </div>
    </div>

</form>

@stop
