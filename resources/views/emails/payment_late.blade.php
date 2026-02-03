<h2>Pagamento in ritardo</h2>

<p>Ciao {{ $payment->tenant->name }},</p>

<p>
    Il pagamento di <strong>{{ number_format($payment->amount_total, 2, ',', '.') }} €</strong> con scadenza
    <strong>{{ $payment->due_date }}</strong> risulta in ritardo.
</p>

<p>
    Puoi visualizzarlo qui:<br>
    <a href="{{ route('tenant.payments.show', $payment->id) }}">
        Vai al pagamento
    </a>
</p>

<p>Ti invitiamo a regolarizzare il prima possibile.</p>

<p>Grazie,<br>Il team KeyMaster</p>
