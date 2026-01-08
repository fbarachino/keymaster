<h2>Contratto firmato dal tenant</h2>

<p>Il contratto relativo all'unità:</p>

<p>
    <strong>{{ $lease->unit->property->name }} — {{ $lease->unit->name }}</strong>
</p>

<p>È stato firmato da:</p>

<p>
    <strong>{{ $lease->tenant->name }}</strong><br>
    {{ $lease->tenant->email }}
</p>

<p>Data firma: {{ $lease->signed_by_tenant_at->format('d/m/Y H:i') }}</p>

<p>Accedi al gestionale per visualizzare il contratto.</p>
<p>
    <a href="{{ route('landlord.leases.show', $lease) }}">
        Visualizza contratto
    </a>
</p>
