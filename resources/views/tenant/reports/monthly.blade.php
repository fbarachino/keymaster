<h2>Report Mensile - {{ $month }}</h2>

<p>Inquilino: {{ $tenant->name }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>Data</th>
            <th>Descrizione</th>
            <th>Importo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $p)
            <tr>
                <td>{{ $p->due_date }}</td>
                <td>{{ $p->description }}</td>
                <td>{{ number_format($p->amount_total, 2, ',', '.') }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>
