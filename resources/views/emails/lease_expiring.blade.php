<h2>Contratto in scadenza</h2>

<p>Ciao {{ $lease->tenants->pluck('name')->join(', ') }},</p>

<p>
    Il tuo contratto per <strong>{{ $lease->property->name }}</strong> scade il
    <strong>{{ $lease->end_date }}</strong>.
</p>

<p>
    Puoi visualizzare i dettagli qui:<br>
    <a href="{{ route('tenant.leases.show', $lease->id) }}">
        Vai al contratto
    </a>
</p>

<p>Grazie,<br>Il team KeyMaster</p>
