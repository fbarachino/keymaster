@extends('layouts.admin')

@section('title', 'Pagamenti')

@section('content_header')
    <h1>Pagamenti</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Elenco pagamenti</h3>

        <a href="{{ route('landlord.payments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuovo pagamento
        </a>
    </div>

    <div class="card-body p-0">

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Proprietà</th>
                    <th>Inquilino</th>
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
                        <td>{{ $p->tenant->name }}</td>
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
                            <a href="{{ route('landlord.payments.show', $p) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('landlord.payments.edit', $p) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('landlord.payments.destroy', $p) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Sei sicuro di voler eliminare questo pagamento?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
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
