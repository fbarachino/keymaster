@extends('adminlte::page')

@section('title', 'I tuoi pagamenti')

@section('content_header')
    <h1>I tuoi pagamenti</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body p-0">
 <h3>I tuoi pagamenti</h3>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Quota</th>
            <th>Pagato</th>
            <th>Stato</th>
            <th>Scadenza</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
            <td>€ {{ number_format($payment->amount_due, 2, ',', '.') }}</td>
            <td>€ {{ number_format($payment->amount_paid, 2, ',', '.') }}</td>
            <td>
                <span class="badge badge-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'overdue' ? 'danger' : 'warning') }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </td>
            <td>{{ $payment->due_date->format('d/m/Y') }}</td>
        </tr>
        @endforeach
        @empty
            <tr>
                <td colspan="6" class="text-center">Nessun pagamento registrato.</td>
            </tr>
        @endforelse
    </tbody>
</table>



    </tbody>
</table>

    </div>
</div>

@stop
