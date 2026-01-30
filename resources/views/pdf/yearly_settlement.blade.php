<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Conguaglio Annuale {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<h1>Conguaglio Annuale {{ $year }}</h1>

<p><strong>Lease:</strong> {{ $lease->unit->name }} ({{ $lease->unit->property->name }})</p>

<h3>Totali Lease</h3>
<table>
    <tr>
        <th>Totale spese inquilino</th>
        <td>€ {{ number_format($totalTenantExpenses, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Totale spese proprietario</th>
        <td>€ {{ number_format($totalLandlordExpenses, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Totale pagato dai tenants</th>
        <td>€ {{ number_format($payments, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Saldo finale</th>
        <td>
            @if($balance >= 0)
                € {{ number_format($balance, 2, ',', '.') }} (a credito)
            @else
                € {{ number_format(abs($balance), 2, ',', '.') }} (a debito)
            @endif
        </td>
    </tr>
</table>

<h3>Dettaglio Spese</h3>
<table>
    <thead>
        <tr>
            <th>Data</th>
            <th>Descrizione</th>
            <th>Quota Tenant</th>
            <th>Quota Landlord</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expenses as $expense)
        <tr>
            <td>{{ $expense->date->format('d/m/Y') }}</td>
            <td>{{ $expense->description }}</td>
            <td>€ {{ number_format($expense->tenant_share, 2, ',', '.') }}</td>
            <td>€ {{ number_format($expense->landlord_share, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- SE VUOI MOSTRARE LE QUOTE INDIVIDUALI, ATTIVA QUESTA SEZIONE
<h3>Quote Individuali Tenants</h3>
<table>
    <thead>
        <tr>
            <th>Tenant</th>
            <th>Quota Conguaglio</th>
        </tr>
    </thead>
    <tbody>
        @php $quota = $balance < 0 ? abs($balance) / $lease->tenants->count() : 0; @endphp
        @foreach($lease->tenants as $tenant)
        <tr>
            <td>{{ $tenant->name }}</td>
            <td>€ {{ number_format($quota, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
--}}

</body>
</html>
