<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Contratto #{{ $lease->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 10px; }
        h2 { font-size: 14px; margin-top: 20px; }
        .section { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Contratto di locazione</h1>

    <div class="section">
        <h2>Dati del locatore</h2>
        <p>{{ $lease->unit->property->landlord->name }}</p>
    </div>

    <div class="section">
        <h2>Dati dell'inquilino</h2>
            @foreach($lease->tenants as $tenant)
            {{ $tenant->first_name }} {{ $tenant->last_name }}<br>
        @endforeach
    </div>

    <div class="section">
        <h2>Immobile</h2>
        <p>{{ $lease->unit->property->name }} — {{ $lease->unit->name }}</p>
    </div>

    <div class="section">
        <h2>Dettagli contratto</h2>
        <p>Inizio: {{ $lease->start_date->format('d/m/Y') }}</p>
        @if($lease->end_date)
            <p>Fine: {{ $lease->end_date->format('d/m/Y') }}</p>
        @endif
        <p>Canone mensile: € {{ number_format($lease->rent_amount, 2, ',', '.') }}</p>
        @if($lease->deposit_amount)
            <p>Deposito cauzionale: € {{ number_format($lease->deposit_amount, 2, ',', '.') }}</p>
        @endif
    </div>

    @if($lease->notes)
        <div class="section">
            <h2>Note</h2>
            <p>{{ $lease->notes }}</p>
        </div>
    @endif

    <div class="section" style="margin-top: 40px;">
        <p>Luogo e data: ____________________________</p>
        <p>Firma locatore: __________________________</p>
        <p>Firma conduttore: ________________________</p>
    </div>
</body>
</html>
