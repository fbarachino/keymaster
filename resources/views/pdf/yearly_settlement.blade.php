<h2>Conguaglio Spese - Anno {{ $year }}</h2>

<p><strong>Inquilino:</strong> {{ $lease->tenant->name }}</p>
<p><strong>Proprietà:</strong> {{ $lease->unit->property->name }}</p>
<p><strong>Unità:</strong> {{ $lease->unit->name }}</p>

<h3>Spese dell'anno</h3>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
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
            <td>{{ $expense->date }}</td>
            <td>{{ $expense->type }}</td>
            <td>€ {{ number_format($expense->amount, 2) }}</td>
            <td>€ {{ number_format($expense->tenant_share, 2) }}</td>
            <td>€ {{ number_format($expense->landlord_share, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Totale spese imputate all'inquilino: € {{ number_format($totalTenantExpenses, 2) }}</h3>
<h3>Pagamenti effettuati dall'inquilino: € {{ number_format($payments, 2) }}</h3>

@if($balance > 0)
    <h2 style="color:red">Saldo a debito dell'inquilino: € {{ number_format($balance, 2) }}</h2>
@elseif($balance < 0)
    <h2 style="color:green">Credito a favore dell'inquilino: € {{ number_format(abs($balance), 2) }}</h2>
@else
    <h2>Saldo perfettamente pareggiato</h2>
@endif
