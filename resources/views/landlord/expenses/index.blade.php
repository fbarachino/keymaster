@extends('layouts.portal')

@section('title', 'Spese')

@section('content_header')
    <h1>Spese dei contratti</h1>
@stop

@section('content')

<div class="mb-3">
    <a href="{{ route('landlord.expenses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuova Spesa
    </a>
</div>
@php
    function expenseBadge($type) {
        return match(strtolower($type)) {
            'condominio' => 'badge-primary',
            'imu' => 'badge-danger',
            'tasse' => 'badge-warning',
            'manutenzione' => 'badge-info',
            'elettrodomestici' => 'badge-success',
            default => 'badge-secondary',
        };
    }
@endphp

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Contratto</th>
                    <th>Inquilino</th>
                    <th>Importo</th>
                    <th>Categoria</th>
                    <th>Imputazione</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $expense->date }}</td>
                        <td>{{ $expense->type }}</td>
                        <td>{{ $expense->lease->id }}</td>
                        <td> @foreach($expense->lease->tenants as $tenant) {{ $tenant->first_name }} {{ $tenant->last_name }}<br> @endforeach </td>
                        <td>€ {{ number_format($expense->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ expenseBadge($expense->type) }}">
                                {{ $expense->type }}
                            </span>
                        </td>

                        <td>
                            @if($expense->charged_to === 'tenant')
                                <span class="badge badge-info">Tenant</span>
                            @elseif($expense->charged_to === 'landlord')
                                <span class="badge badge-secondary">Landlord</span>
                            @else
                                <span class="badge badge-warning">50 / 50</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('landlord.expenses.edit', $expense) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('landlord.expenses.destroy', $expense) }}"
                                  method="POST"
                                  style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Eliminare questa spesa?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nessuna spesa registrata.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
