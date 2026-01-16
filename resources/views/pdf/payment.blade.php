<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ricevuta pagamento</title>
</head>
<body>
    <h1>Ricevuta pagamento</h1>
@php
    $tenant = $payment->lease->tenant ?? null;
@endphp

@if($tenant)
    Ciao {{ $tenant->name }},
@else
    Ciao,
@endif
    <p>Pagamento ID: {{ $payment->id }}</p>
    <p>Inquilino: {{  $payment->lease->tenant->name ?? null }}</p>
    <p>Importo: € {{ number_format($payment->amount, 2, ',', '.') }}</p>
    <p>Data: {{ $payment->created_at->format('d/m/Y') }}</p>
</body>
</html>
