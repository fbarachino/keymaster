<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #999;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }

        .qr {
            text-align: center;
            margin-top: 20px;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .positive { color: green; }
        .negative { color: red; }
    </style>
</head>
<body>

<h1>Conguaglio Spese - Anno {{ $year }}</h1>

<p><strong>Inquilino:</strong> {{ $lease->tenant->name }}</p>
<p><strong>Proprietà:</strong> {{ $lease->unit->property->name }}</p>
<p><strong>Unità:</strong> {{ $lease->unit->name }}</p>

<h3>Dettaglio Spese Annuali</h3>
<p>In queto documento, vengono riepilogate le spese sostenute nell'anno {{ $year }} e il relativo conguaglio.</p>
<p>Vengono inoltre riportati i pagamenti effettuati relativi al contratto in corso, per il canone di affitto e gli anticipi spesa.</p>
<p>Si prega di verificare attentamente i dati riportati e, in caso di discrepanze, contattare l'amministratore della proprietà.</p>
<p>Grazie per la collaborazione.</p>

<table>
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
            <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
            <td>{{ ucfirst($expense->type) }}</td>
            <td>€ {{ number_format($expense->amount, 2, ',', '.') }}</td>
            <td>€ {{ number_format($expense->tenant_share, 2, ',', '.') }}</td>
            <td>€ {{ number_format($expense->landlord_share, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tr>
        <th>Totale spese imputate all'inquilino</th>
        <td>€ {{ number_format($totalTenantExpenses, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Pagamenti effettuati dall'inquilino</th>
        <td>€ {{ number_format($payments, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Saldo finale</th>
        <td>
            @if($balance > 0)
                <span class="negative">Debito: € {{ number_format($balance, 2, ',', '.') }}</span>
            @elseif($balance < 0)
                <span class="positive">Credito: € {{ number_format(abs($balance), 2, ',', '.') }}</span>
            @else
                Nessuna differenza
            @endif
        </td>
    </tr>
</table>

{{-- // QRCode
<div class="qr">
    <img src="data:image/png;base64, {!! base64_encode(
        QrCode::format('png')->size(150)->generate(
            'Conguaglio '.$year.
            ' | Inquilino: '.$lease->tenant->name.
            ' | Totale spese: '.$totalTenantExpenses.
            ' | Pagamenti: '.$payments.
            ' | Saldo: '.$balance
        )
    ) !!}">
    <p style="font-size: 11px; color: #666;">QR Code riepilogo conguaglio</p>
</div>
 --}}
<hr>
<h3>Pagamenti del canone di affitto effettuati</h3>
@foreach($lease->payments()->whereYear('date', $year)->where('type', 'rent')->where('status', 'paid')->get() as $payment_rent)
    <p style="font-size: 11px; color: #666; text-align: center;">{{ $payment_rent->date }} - € {{ number_format($payment_rent->amount, 2, ',', '.') }} </p>
@endforeach
<hr>
<h3>Anticipi spese versati nell'anno</h3>
@foreach($lease->payments()->whereYear('date', $year)->where('type', 'advance-expenses')->where('status', 'paid')->get() as $payment_expense)
    <p style="font-size: 11px; color: #666; text-align: center;">{{ $payment_expense->date }} - € {{ number_format($payment_expense->amount, 2, ',', '.') }} </p>
@endforeach
<hr>
@foreach($lease->expenses()->whereYear('date', $year)->where('charged_to', 'tenant')->get() as $expense)
    <p style="font-size: 11px; color: #666; text-align: center;">Anticipo spese del {{ $expense->date }} - € {{ number_format($expense->amount, 2, ',', '.') }} </p>
@endforeach
<hr>
<p>Si attesta che il presente conguaglio spese è stato redatto in conformità ai dati contabili disponibili e riflette accuratamente le spese sostenute e i pagamenti effettuati nell'anno {{ $year }}.</p>
<p>Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
<br>
<p><small><i>In caso di domande o chiarimenti, si prega di contattare l'amministratore della proprietà.</i></small></p>
<div class="signature">
    <p><strong>Firma digitale:</strong></p>
    <p>{{ $lease->unit->property->landlord->name }}</p>
</div>

<div class="footer">
    Documento generato automaticamente dal sistema gestionale.
</div>

</body>
</html>
