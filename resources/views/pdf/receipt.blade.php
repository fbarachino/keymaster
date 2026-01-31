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
    </style>
</head>
<body>

<h1>Ricevuta di Pagamento</h1>

{{-- Numero progressivo ricevuta --}}
<p><strong>Ricevuta n°:</strong> {{ $payment->id }}</p>

<table>
    <tr>
        <th>Inquilino</th>
        <td>{{ $payment->lease->tenants->first()->name }}</td>
    </tr>

    <tr>
        <th>Proprietà</th>
        <td>{{ $payment->lease->unit->property->name }}</td>
    </tr>

    <tr>
        <th>Unità</th>
        <td>{{ $payment->lease->unit->name }}</td>
    </tr>

    <tr>
        <th>Importo</th>
        <td>€ {{ number_format($payment->amount, 2, ',', '.') }}</td>
    </tr>

    <tr>
        <th>Data pagamento</th>
        <td>{{ \Carbon\Carbon::parse($payment->paid_date)->format('d/m/Y') }}</td>
    </tr>

    <tr>
        <th>Riferimento</th>
        <td>{{ $payment->reference ?? '-' }}</td>
    </tr>
</table>

{{-- QR Code --}}
<div class="qr">
    <img src="data:image/png;base64, {!! base64_encode(
        QrCode::format('png')->size(150)->generate(
            'Ricevuta n° '.$payment->id.
            ' | Importo: '.$payment->amount.
            ' | Inquilino: '.$payment->lease->tenant->name.
            ' | Data: '.$payment->paid_date
        )
    ) !!} ">
    <p style="font-size: 11px; color: #666;">QR Code contenente i dati della ricevuta</p>
</div>

{{-- Firma digitale --}}
<div class="signature">
    <p><strong>Firma digitale:</strong></p>
    <p>{{ $payment->lease->unit->property->landlord->name }}</p>
    <p style="font-size: 11px; color: #666;">Documento firmato digitalmente</p>
</div>

<div class="footer">
    Documento generato automaticamente dal sistema gestionale.
</div>

</body>
</html>
