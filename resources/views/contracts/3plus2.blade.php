<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Contratto di locazione 3+2</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.4; }
        h1, h2, h3 { text-align: center; }
        .section-title { font-weight: bold; margin-top: 15px; text-decoration: underline; }
        .mt-10 { margin-top: 10px; }
    </style>
</head>
<body>

    <h2>CONTRATTO DI LOCAZIONE AD USO ABITATIVO (3+2)</h2>

    <p>
        Tra i sottoscritti:
    </p>

    <p>
        <strong>Locatore:</strong>
        {{ $landlord->first_name }} {{ $landlord->last_name }},
        nat{{ $landlord->birth_place ? 'o a '.$landlord->birth_place : '' }}
        il {{ $landlord->birth_date ? \Carbon\Carbon::parse($landlord->birth_date)->format('d/m/Y') : '___/___/____' }},
        CF {{ $landlord->fiscal_code ?? '________________' }},
        residente in {{ $landlord->address ?? '________________' }},
        {{ $landlord->zip }} {{ $landlord->city }} ({{ $landlord->province }}),
        di seguito denominato "Locatore".
    </p>

    <p><strong>Conduttori:</strong></p>

    @foreach($lease->tenants as $tenant)
        <p>
            {{ $tenant->first_name }} {{ $tenant->last_name }},
            nat{{ $tenant->birth_place ? 'o a '.$tenant->birth_place : '' }}
            il {{ $tenant->birth_date ? \Carbon\Carbon::parse($tenant->birth_date)->format('d/m/Y') : '___/___/____' }},
            CF {{ $tenant->fiscal_code ?? '________________' }},
            residente in {{ $tenant->address ?? '________________' }},
            {{ $tenant->zip }} {{ $tenant->city }} ({{ $tenant->province }}).
        </p>
    @endforeach


    <p class="section-title">Art. 1 - Oggetto della locazione</p>
    <p>
        Il Locatore concede in locazione al Conduttore l'unità immobiliare sita in
        {{ $property->address ?? '________________' }},
        identificata come {{ $unit->name ?? 'unità immobiliare' }},
        di proprietà del Locatore.
    </p>

    <p class="section-title">Art. 2 - Durata</p>
    <p>
        La durata della locazione è di anni 3 (tre) con decorrenza dal
        {{ \Carbon\Carbon::parse($lease->start_date)->format('d/m/Y') }}
        e scadenza il
        {{ $lease->end_date ? \Carbon\Carbon::parse($lease->end_date)->format('d/m/Y') : '___/___/____' }},
        rinnovabile per ulteriori 2 (due) anni salvo disdetta nei termini di legge.
    </p>

    <p class="section-title">Art. 3 - Canone</p>
    <p>
        Il canone annuo di locazione è convenuto in Euro
        {{ number_format($lease->rent_amount * 12, 2, ',', '.') }},
        da corrispondersi in rate mensili di Euro
        {{ number_format($lease->rent_amount, 2, ',', '.') }}
        entro il giorno {{ $lease->payment_day ?? '___' }} di ogni mese.
    </p>

    @if($lease->advance_expenses)
        <p>
            A titolo di anticipo spese condominiali, il Conduttore corrisponderà inoltre
            Euro {{ number_format($lease->advance_expenses, 2, ',', '.') }} mensili.
        </p>
    @endif

    <p class="section-title">Art. 4 - Deposito cauzionale</p>
    <p>
        A garanzia delle obbligazioni assunte, il Conduttore versa un deposito cauzionale di Euro
        {{ $lease->deposit_amount ? number_format($lease->deposit_amount, 2, ',', '.') : '__________' }},
        che sarà restituito al termine della locazione salvo conguagli.
    </p>

    <p class="section-title">Art. 5 - Altre clausole</p>
    <p>
        (Qui puoi inserire tutte le clausole standard del tuo contratto tipo: uso dell'immobile,
        manutenzioni, recesso, registrazione, ecc.)
    </p>

    <p class="mt-10">
        Letto, confermato e sottoscritto.
    </p>

    <p class="mt-10">
        Luogo e data: ______________________________
    </p>

    <p class="mt-10">
        Il Locatore: ______________________________
    </p>

    <p class="mt-10">
        Il Conduttore: ____________________________
    </p>

</body>
</html>
