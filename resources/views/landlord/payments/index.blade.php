@extends('adminlte::page')

@section('title', 'Pagamenti')

@section('content_header')
    <h1>Pagamenti</h1>
@stop

@section('content')

<div class="mb-3">
    <a href="{{ route('landlord.payments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuovo Pagamento
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Contratto</th>
                    <th>Inquilino</th>
                    <th>Tipo</th>
                    <th>Importo</th>
                    <th>Scadenza</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>#{{ $payment->lease->id }}</td>
                        {{-- <td> @foreach($payment->lease->tenants as $tenant) {{ $tenant->first_name }} {{ $tenant->last_name }}<br> @endforeach </td> --}}
                        <td>{{ $payment->tenant->user->name }}</td>

                        {{-- Tipo pagamento --}}
                        <td>
                            @php
                                $colors = [
                                    'rent' => 'badge-primary',
                                    'deposit' => 'badge-warning',
                                    'expense' => 'badge-info',
                                    'other' => 'badge-secondary',
                                ];
                            @endphp

                            <span class="badge {{ $colors[$payment->type] ?? 'badge-secondary' }}">
                                {{ ucfirst($payment->type) }}
                            </span>
                        </td>

                        <td>€ {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->due_date }}</td>

                        {{-- Stato pagamento --}}
                        <td>
                            @if($payment->status === 'paid')
                                <span class="badge badge-success">Pagato</span>
                            @else
                                <span class="badge badge-danger">Non pagato</span>
                            @endif
                        </td>

                        <td>
                            {{-- Modifica --}}
                            <a href="{{ route('landlord.payments.edit', $payment) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Segna come pagato --}}
                            @if($payment->status !== 'paid')
                                <form action="{{ route('landlord.payments.markPaid', $payment) }}"
                                      method="POST"
                                      style="display:inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Elimina --}}
                            <form action="{{ route('landlord.payments.destroy', $payment) }}"
                                  method="POST"
                                  style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Eliminare questo pagamento?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nessun pagamento registrato.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
