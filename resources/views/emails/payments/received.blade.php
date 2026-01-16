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
@php
    $tenant = $payment->lease->tenant ?? null;
@endphp

@if($tenant)
    Ciao {{ $tenant->name }},
@else
    Ciao,
@endif


Abbiamo registrato il tuo pagamento di **€ {{ number_format($payment->amount, 2, ',', '.') }}**.

@component('mail::panel')
Unità: {{ $payment->lease->unit->name }}
Data: {{ $payment->created_at->format('d/m/Y') }}
@endcomponent

Grazie,
{{ config('app.name') }}
@endcomponent
