{{-- <h2>Conguaglio Spese - Anno {{ $year }}</h2>

<p><strong>Inquilino:</strong> {{ $lease->tenant->name }}</p>
<p><strong>Proprietà:</strong> {{ $lease->unit->property->name }}</p>
<p><strong>Unità:</strong> {{ $lease->unit->name }}</p>

<h3>Spese dell'anno</h3>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Data</th>
            <th>Tipo</th>
            <th>Importo</th>
            <th>Quota Inquilino</th>
            <th>Quota Proprietario</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expenses as $expense)
        <tr>
            <td>{{ $expense->date }}</td>
            <td>{{ $expense->type }}</td>
            <td>€ {{ number_format($expense->amount, 2) }}</td>
            <td>€ {{ number_format($expense->tenant_share, 2) }}</td>
            <td>€ {{ number_format($expense->landlord_share, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Totale spese imputate all'inquilino: € {{ number_format($totalTenantExpenses, 2) }}</h3>
<h3>Pagamenti effettuati dall'inquilino: € {{ number_format($payments, 2) }}</h3>

@if($balance > 0)
    <h2 style="color:red">Saldo a debito dell'inquilino: € {{ number_format($balance, 2) }}</h2>
@elseif($balance < 0)
    <h2 style="color:green">Credito a favore dell'inquilino: € {{ number_format(abs($balance), 2) }}</h2>
@else
    <h2>Saldo perfettamente pareggiato</h2>
@endif
 --}}
 <!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; }
        h1 { text-align: center; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        th, td { padding: 10px; border: 1px solid #999; }
        th { background: #f2f2f2; text-align: left; }
        .qr { text-align: center; margin-top: 20px; }
        .signature { margin-top: 40px; text-align: right; font-size: 14px; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>

<h1>Conguaglio Finale</h1>

<p><strong>Periodo:</strong> {{ $start->format('d/m/Y') }} – {{ $end->format('d/m/Y') }}</p>
<p><strong>Inquilino:</strong> {{ $tenant->name }}</p>

<table>
    <tr>
        <th>Totale dovuto</th>
        <td>€ {{ number_format($total_due, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Totale pagato</th>
        <td>€ {{ number_format($total_paid, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Conguaglio</th>
        <td>
            @if($balance > 0)
                Debito: € {{ number_format($balance, 2, ',', '.') }}
            @elseif($balance < 0)
                Credito: € {{ number_format(abs($balance), 2, ',', '.') }}
            @else
                Nessuna differenza
            @endif
        </td>
    </tr>
</table>

<h3>Dettaglio Movimenti</h3>

<table>
    <thead>
        <tr>
            <th>Data</th>
            <th>Descrizione</th>
            <th>Importo</th>
            <th>Stato</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $p)
        <tr>
            <td>{{ $p->paid_date ? $p->paid_date->format('d/m/Y') : '-' }}</td>
            <td>{{ ucfirst($p->type) }}</td>
            <td>€ {{ number_format($p->amount, 2, ',', '.') }}</td>
            <td>{{ $p->status === 'paid' ? 'Pagato' : 'Non pagato' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="qr">
    <img src="data:image/png;base64, {!! base64_encode(
        QrCode::format('png')->size(150)->generate(
            'Conguaglio '.$start->format('Y').' | Totale dovuto: '.$total_due.' | Totale pagato: '.$total_paid
        )
    ) !!}">
    <p style="font-size: 11px; color: #666;">QR Code conguaglio</p>
</div>

<div class="signature">
    <p><strong>Firma digitale:</strong></p>
    <p>{{ $landlord->name }}</p>
</div>

<div class="footer">
    Documento generato automaticamente dal sistema gestionale.
</div>

</body>
</html>
