@extends('layouts.portal')

@section('title', 'Nuova Spesa')

@section('content_header')
    <h1>Registra una nuova spesa</h1>
@stop

@section('content')

<form action="{{ route('landlord.expenses.store') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label>Contratto</label>
                <select name="lease_id" class="form-control" required>
                    <option value="">Seleziona...</option>
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}">
                           {{--  #{{ $lease->id }} - {{ $lease->tenant->name }} ({{ $lease->unit->property->name }}) --}}
                            #{{ $lease->id }} -
{{ $lease->tenants->pluck('name')->join(', ') }}
({{ $lease->unit->property->name }})

                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tipo di spesa</label>
                <input type="text" name="type" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Importo</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Imputazione</label>
                <select name="charged_to" class="form-control" required>
                    <option value="tenant">Tenant</option>
                    <option value="landlord">Landlord</option>
                    <option value="both">50 / 50</option>
                </select>
            </div>

            <div class="form-group">
                <label>Data</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Note</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-success">Salva</button>
            <a href="{{ route('landlord.expenses.index') }}" class="btn btn-secondary">Annulla</a>
        </div>
    </div>

</form>

@stop
