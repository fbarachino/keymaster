@extends('layouts.admin')

@section('title', 'Le mie spese')

@section('content_header')
    <h1>Le mie spese</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-body p-0">

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Quota personale</th>
                    <th class="text-right">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @forelse($expenses as $e)
                    <tr>
                        <td>{{ ucfirst($e->category) }}</td>
                        <td>{{ $e->expense_date->format('d/m/Y') }}</td>
                        <td>{{ number_format($e->amount_tenant, 2, ',', '.') }} €</td>

                        <td class="text-right">
                            <a href="{{ route('tenant.expenses.show', $e) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
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
