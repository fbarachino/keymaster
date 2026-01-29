<h2>Contratto firmato dal tenant</h2>

<p>Il contratto relativo all'unità:</p>

<p>
    <strong>{{ $lease->unit->property->name }} — {{ $lease->unit->name }}</strong>
</p>

<p>È stato firmato da:</p>

<p>
    <<strong>{{ auth()->user()->name }}</strong><br>
    {{ auth()->user()->email }}
</p>

<p>Data firma: {{ $lease->signed_by_tenant_at->format('d/m/Y H:i') }}</p>

<p>Accedi al gestionale per visualizzare il contratto.</p>

