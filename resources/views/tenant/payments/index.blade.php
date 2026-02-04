@extends('layouts.admin')

@section('title', 'I miei pagamenti')

@section('content_header')
    <h1>I miei pagamenti</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-body p-0">

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Proprietà</th>
                    <th>Scadenza</th>
                    <th>Importo</th>
                    <th>Stato</th>
                    <th class="text-right">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $p)
                    <tr>
                        <td>{{ $p->lease->property->name }}</td>
                        <td>{{ $p->due_date->format('d/m/Y') }}</td>
                        <td>{{ number_format($p->amount_total, 2, ',', '.') }} €</td>

                        <td>
                            @if($p->status === 'paid')
                                <span class="badge badge-success">Pagato</span>
                            @elseif($p->due_date->isPast())
                                <span class="badge badge-danger">In ritardo</span>
                            @else
                                <span class="badge badge-warning">Da pagare</span>
                            @endif
                        </td>

                        <td class="text-right">
                            <a href="{{ route('tenant.payments.show', $p) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            Nessun pagamento trovato.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="card-footer">
        {{ $payments->links() }}
    </div>

</div>

@endsection
