<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riepilogo Mensile - {{ $period }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<h1>Riepilogo Mensile</h1>

<p><strong>Tenant:</strong> {{ $tenant->name }}</p>
<p><strong>Lease:</strong> {{ $lease->unit->name }} ({{ $lease->unit->property->name }})</p>
<p><strong>Periodo:</strong> {{ $period }}</p>

<h3>Dettaglio Pagamenti</h3>
<table>
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Quota</th>
            <th>Scadenza</th>
            <th>Stato</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
            <td>€ {{ number_format($payment->amount_due, 2, ',', '.') }}</td>
            <td>{{ $payment->due_date->format('d/m/Y') }}</td>
            <td>{{ ucfirst($payment->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Totale Mensile</h3>
<table>
    <tr>
        <th>Totale dovuto</th>
        <td>
            € {{ number_format($payments->sum('amount_due'), 2, ',', '.') }}
        </td>
    </tr>
</table>

<p style="margin-top: 40px; font-size: 11px;">
    Documento generato automaticamente dal sistema KeyMaster.
</p>

</body>
</html>
