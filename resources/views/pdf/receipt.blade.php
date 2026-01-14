<h1>Ricevuta di pagamento</h1>

<p>Inquilino: {{ $payment->lease->tenant->name }}</p>
<p>Proprietà: {{ $payment->lease->unit->property->name }}</p>
<p>Unità: {{ $payment->lease->unit->name }}</p>
<p>Importo: € {{ number_format($payment->amount, 2) }}</p>
<p>Data pagamento: {{ $payment->paid_date }}</p>
<p>Riferimento: {{ $payment->reference }}</p>
