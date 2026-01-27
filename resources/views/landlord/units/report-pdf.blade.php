<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dossier Unit {{ $unit->name }}</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2 { margin-bottom: 0; }
        .section { margin-bottom: 25px; }
        .title { background: #eee; padding: 8px; font-weight: bold; }
        .item { margin-left: 10px; }
    </style>
</head>
<body>
<div style="width: 100%; display: flex; align-items: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/logo.png') }}" style="height: 60px;">
    <h2 style="margin-left: 15px;">Dossier Unità: {{ $unit->name }}</h2>
</div>
{{-- <h1>Dossier Unità: {{ $unit->name }}</h1> --}}
<p>Generato il {{ now()->format('d/m/Y') }}</p>

<div class="section">
    <div class="title">Informazioni Unità</div>
    <div class="item">Proprietà: {{ $unit->property->name }}</div>
    <div class="item">Indirizzo: {{ $unit->property->address }}</div>
    <div class="item">Piano: {{ $unit->floor }}</div>
    <div class="item">Codice interno: {{ $unit->internal_code }}</div>
</div>

<div class="section">
    <div class="title">Inquilini Attuali</div>
    @foreach($unit->leases as $lease)
        @foreach($lease->tenants as $tenant)
            <div class="item">{{ $tenant->first_name }} {{ $tenant->last_name }} ({{ $tenant->email }})</div>
        @endforeach
    @endforeach
</div>

<div class="section">
    <div class="title">Pagamenti</div>
    @foreach($unit->leases as $lease)
        @foreach($lease->payments as $payment)
            <div class="item">
                {{ $payment->date }} — €{{ number_format($payment->amount, 2) }} ({{ $payment->status }})
            </div>
        @endforeach
    @endforeach
</div>

<div class="section">
    <div class="title">Spese</div>
    @foreach($unit->expenses as $expense)
        <div class="item">
            {{ $expense->date }} — €{{ number_format($expense->amount, 2) }} — {{ $expense->description }}
        </div>
    @endforeach
</div>
@if(isset($chartImage))
    <img src="data:image/png;base64,{{ $chartImage }}" style="width: 100%; margin-bottom: 20px;">
@endif

<div class="section">
    <div class="title">Inventario</div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border-bottom: 1px solid #ccc;">Oggetto</th>
                <th style="border-bottom: 1px solid #ccc;">Condizione</th>
                <th style="border-bottom: 1px solid #ccc;">Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unit->inventory as $item)
                <tr>
                    <td>{{ $item->item }}</td>
                    <td>{{ $item->condition }}</td>
                    <td>{{ $item->notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nessun oggetto in inventario</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="section">
    <div class="title">Foto</div>

    @foreach($unit->photos as $photo)
        <img src="{{ public_path('storage/'.$photo->path) }}"
             style="width: 45%; margin: 5px; border-radius: 5px;">
    @endforeach
</div>



</body>
</html>
<script type="text/php">
if (isset($pdf)) {
    $text = "Pagina {PAGE_NUM} di {PAGE_COUNT}";
    $font = $fontMetrics->get_font("DejaVu Sans", "normal");
    $pdf->page_text(500, 820, $text, $font, 10);
}
</script>
