<h1>Contratto di locazione</h1>

<p>Proprietà: {{ $lease->unit->property->name }}</p>
<p>Unità: {{ $lease->unit->name }}</p>
<p>Inquilino: {{ $lease->tenant->name }}</p>
<p>Affitto: € {{ $lease->rent_amount }}</p>

@if($lease->signature_path)
    <p>Firma inquilino:</p>
    <img src="{{ public_path('storage/' . $lease->signature_path) }}" width="200">
@endif

