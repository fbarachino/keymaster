@extends('adminlte::page')

@section('title', 'Spese')

@section('content_header')
    <h1>Spese</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Elenco spese</h3>

        <a href="{{ route('landlord.expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuova spesa
        </a>
    </div>

    <div class="card-body p-0">

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Proprietà</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Importo</th>
                    <th>Quota inquilino</th>
                    <th class="text-right">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @forelse($expenses as $e)
                    <tr>
                        <td>{{ $e->property->name }}</td>
                        <td>{{ ucfirst($e->category) }}</td>
                        <td>{{ $e->expense_date->format('d/m/Y') }}</td>
                        <td>{{ number_format($e->amount_total, 2, ',', '.') }} €</td>
                        <td>{{ $e->amount_tenant ? number_format($e->amount_tenant, 2, ',', '.') . ' €' : '-' }}</td>

                        <td class="text-right">
                            <a href="{{ route('landlord.expenses.show', $e) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('landlord.expenses.edit', $e) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('landlord.expenses.destroy', $e) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Eliminare questa spesa?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Nessuna spesa trovata.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="card-footer">
        {{ $expenses->links() }}
    </div>

</div>

@endsection
