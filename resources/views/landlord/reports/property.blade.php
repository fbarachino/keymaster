<h2>Report Proprietà: {{ $property->name }}</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>Inquilino</th>
            <th>Data</th>
            <th>Importo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $p)
            <tr>
                <td>{{ $p->tenant->name }}</td>
                <td>{{ $p->due_date }}</td>
                <td>{{ number_format($p->amount_total, 2, ',', '.') }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>
