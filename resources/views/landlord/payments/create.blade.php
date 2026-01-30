@extends('adminlte::page')

@section('title', 'Registra Pagamento')

@section('content_header')
    <h1>Registra un nuovo pagamento</h1>
@stop

@section('content')

<form action="{{ route('landlord.payments.store') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-body">

            {{-- Selezione contratto --}}
            <div class="form-group">
                <label>Contratto</label>
                <select name="lease_id" class="form-control" required>
                    <option value="">Seleziona...</option>
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}">
                            #{{ $lease->id }} - {{ $lease->tenants->pluck('name')->join(', ') }} - ({{ $lease->unit->property->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo pagamento --}}
            <div class="form-group">
                <label>Tipo di pagamento</label>
                <select name="type" class="form-control" required>
                    <option value="rent">Affitto</option>
                    <option value="deposit">Cauzione</option>
                    <option value="expense">Spesa imputata</option>
                    <option value="other">Altro</option>
                </select>
            </div>

            {{-- Importo --}}
            <div class="form-group">
                <label>Importo</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>

            {{-- Data scadenza --}}
            <div class="form-group">
                <label>Data scadenza</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>

            {{-- Riferimento --}}
            <div class="form-group">
                <label>Riferimento</label>
                <input type="text" name="reference" class="form-control" placeholder="Es: Affitto Gennaio, Cauzione, Spesa condominiale...">
            </div>

            {{-- Note --}}
            <div class="form-group">
                <label>Note</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-success">Salva</button>
            <a href="{{ route('landlord.payments.index') }}" class="btn btn-secondary">Annulla</a>
        </div>
    </div>

</form>

@stop
