<h2>Nuovo pagamento disponibile</h2>

<p>Ciao {{ $payment->tenant->name }},</p>

<p>
    È stato generato un nuovo pagamento di <strong>{{ number_format($payment->amount_total, 2, ',', '.') }} €</strong>.<br>
    Scadenza: <strong>{{ $payment->due_date }}</strong>
</p>

<p>
    Puoi visualizzarlo qui:<br>
    <a href="{{ route('tenant.payments.show', $payment->id) }}">
        Visualizza pagamento
    </a>
</p>

<p>Grazie,<br>Il team KeyMaster</p>
