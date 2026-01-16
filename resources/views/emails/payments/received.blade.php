{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
 --}}
@component('mail::message')
# Pagamento ricevuto

Ciao {{ $payment->tenant->name }},

Abbiamo registrato il tuo pagamento di **€ {{ number_format($payment->amount, 2, ',', '.') }}**.

@component('mail::panel')
Unità: {{ $payment->unit->name }}
Data: {{ $payment->created_at->format('d/m/Y') }}
@endcomponent

Grazie,
{{ config('app.name') }}
@endcomponent
