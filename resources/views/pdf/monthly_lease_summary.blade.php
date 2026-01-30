<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riepilogo Mensile Lease - {{ $period }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<h1>Riepilogo Mensile Lease</h1>

<p><strong>Periodo:</strong> {{ $period }}</p>
<p><strong>Lease:</strong> {{ $lease->unit->name }} ({{ $lease->unit->property->name }})</p>

<h3>Totali Mensili</h3>
<table>
    <tr>
        <th>Affitto totale</th>
        <td>€ {{ number_format($total->rent_total, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Anticipo spese</th>
        <td>€ {{ number_format($total->advance_total, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Totale complessivo</th>
        <td>
            € {{ number_format($total->rent_total + $total->advance_total, 2, ',', '.') }}
        </td>
    </tr>
</table>

<h3>Tenants</h3>
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lease->tenants as $tenant)
        <tr>
            <td>{{ $tenant->name }}</td>
            <td>{{ $tenant->email }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="margin-top: 40px; font-size: 11px;">
    Documento generato automaticamente dal sistema KeyMaster.
</p>

</body>
</html>
