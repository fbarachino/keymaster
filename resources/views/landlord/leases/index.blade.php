{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Contratti di locazione</h1>

<a href="{{ route('landlord.leases.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo contratto
</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-3 text-left">Unità</th>
            <th class="p-3 text-left">Proprietà</th>
            <th class="p-3 text-left">Inquilino</th>
            <th class="p-3 text-left">Inizio</th>
            <th class="p-3 text-left">Affitto</th>
            <th class="p-3 text-center">Azioni</th>
        </tr>
    </thead>

    <tbody>
        @foreach($leases as $lease)
        <tr class="border-b">
            <td class="p-3">{{ $lease->unit->name }}</td>
            <td class="p-3">{{ $lease->unit->property->name }}</td>
            <td class="p-3">{{ $lease->tenant->name }}</td>
            <td class="p-3">{{ $lease->start_date->format('d/m/Y') }}</td>
            <td class="p-3">€ {{ number_format($lease->rent_amount, 2, ',', '.') }}</td>
            <td class="p-3 text-center">
                <a href="{{ route('landlord.leases.edit', $lease) }}" class="text-blue-600">Modifica</a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
 --}}
{{--  @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Contratti di locazione</h1>

<a href="{{ route('landlord.leases.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Nuovo contratto
</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-3 text-left">Unità</th>
            <th class="p-3 text-left">Proprietà</th>
            <th class="p-3 text-left">Inquilino</th>
            <th class="p-3 text-left">Inizio</th>
            <th class="p-3 text-left">Affitto</th>
            <th class="p-3 text-left">Saldo</th>
            <th class="p-3 text-center">Azioni</th>
        </tr>
    </thead>

    <tbody>
        @foreach($leases as $lease)
        @php
            $balance = $lease->currentBalance();
        @endphp

        <tr class="border-b">
            <td class="p-3">{{ $lease->unit->name }}</td>
            <td class="p-3">{{ $lease->unit->property->name }}</td>
            <td class="p-3">{{ $lease->tenant->name }}</td>
            <td class="p-3">{{ $lease->start_date->format('d/m/Y') }}</td>
            <td class="p-3">€ {{ number_format($lease->rent_amount, 2, ',', '.') }}</td>

            <td class="p-3">
                @if($balance > 0)
                    <span class="text-red-600 font-semibold">
                        Debito: € {{ number_format($balance, 2, ',', '.') }}
                    </span>
                @elseif($balance < 0)
                    <span class="text-green-600 font-semibold">
                        Credito: € {{ number_format(abs($balance), 2, ',', '.') }}
                    </span>
                @else
                    <span class="text-gray-600">Saldo pari</span>
                @endif
            </td>

            <td class="p-3 text-center">
                <a href="{{ route('landlord.leases.edit', $lease) }}" class="text-blue-600">Modifica</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
 --}}
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
                    <th>Saldo</th>
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
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@stop
