<h2>Report Spese - {{ $month }}</h2>

<p><strong>Inquilino:</strong> {{ $lease->tenant->name }}</p>
<p><strong>Proprietà:</strong> {{ $lease->unit->property->name }}</p>
<p><strong>Unità:</strong> {{ $lease->unit->name }}</p>

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

<h3>Totale imputato all'inquilino: € {{ number_format($totalTenant, 2) }}</h3>
<h3>Totale imputato al proprietario: € {{ number_format($totalLandlord, 2) }}</h3>
