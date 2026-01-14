@extends('layouts.portal')

@section('title', 'Modifica Spesa')

@section('content_header')
    <h1>Modifica Spesa</h1>
@stop

@section('content')

<form action="{{ route('landlord.expenses.update', $expense) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label>Contratto</label>
                <select name="lease_id" class="form-control" required>
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}"
                            @selected($lease->id == $expense->lease_id)>
                            #{{ $lease->id }} - {{ $lease->tenant->name }} ({{ $lease->unit->property->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tipo di spesa</label>
                <input type="text" name="type" class="form-control" value="{{ $expense->type }}" required>
            </div>

            <div class="form-group">
                <label>Importo</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ $expense->amount }}" required>
            </div>

            <div class="form-group">
                <label>Imputazione</label>
                <select name="charged_to" class="form-control" required>
                    <option value="tenant" @selected($expense->charged_to === 'tenant')>Tenant</option>
                    <option value="landlord" @selected($expense->charged_to === 'landlord')>Landlord</option>
                    <option value="both" @selected($expense->charged_to === 'both')>50 / 50</option>
                </select>
            </div>

            <div class="form-group">
                <label>Data</label>
                <input type="date" name="date" class="form-control" value="{{ $expense->date }}" required>
            </div>

            <div class="form-group">
                <label>Note</label>
                <textarea name="notes" class="form-control">{{ $expense->notes }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-success">Aggiorna</button>
            <a href="{{ route('landlord.expenses.index') }}" class="btn btn-secondary">Annulla</a>
        </div>
    </div>

</form>

@stop
