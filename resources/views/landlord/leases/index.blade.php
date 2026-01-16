@extends('adminlte::page')

@section('title', 'Contratti di locazione')

@section('content_header')
    <h1>Contratti di locazione</h1>
@stop

@section('content')

<a href="{{ route('landlord.leases.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Nuovo contratto
</a>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Unità</th>
                    <th>Proprietà</th>
                    <th>Inquilino</th>
                    <th>Inizio</th>
                    <th>Affitto</th>
                    <th>Saldo Spese</th>
                    <th class="text-center">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @foreach($leases as $lease)
                @php
                    $balance = $lease->currentBalance();
                @endphp

                <tr>
                    <td>{{ $lease->unit->name }}</td>
                    <td>{{ $lease->unit->property->name }}</td>
                    <td>{{ $lease->tenant->name }}</td>
                    <td>{{ $lease->start_date->format('d/m/Y') }}</td>
                    <td>€ {{ number_format($lease->rent_amount, 2, ',', '.') }}</td>

                    <td>
                        @if($balance > 0)
                            <span class="badge badge-danger">
                                Debito: € {{ number_format($balance, 2, ',', '.') }}
                            </span>
                        @elseif($balance < 0)
                            <span class="badge badge-success">
                                Credito: € {{ number_format(abs($balance), 2, ',', '.') }}
                            </span>
                        @else
                            <span class="badge badge-secondary">Saldo pari</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('landlord.leases.edit', $lease) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Modifica
                        </a>
{{--                         <a href="{{ route('landlord.leases.show', $lease) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i> Dettagli
                        </a> --}}
                        <a href="{{ route('landlord.leases.pdf', $lease) }}" class="btn btn-sm btn-dark" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@stop
