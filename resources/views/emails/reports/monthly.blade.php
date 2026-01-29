@component('mail::message')
# Report Mensile

Ciao {{ $tenant->first_name }} {{ $tenant->last_name }},

Ecco il tuo report mensile relativo alla proprietà:

**{{ $lease->unit->property->name }}**
Indirizzo: {{ $lease->unit->property->address }} int. {{ $lease->unit->interior }}

---

### 💰 Importi dovuti per questo mese:
## 📌 Canone
@if(isset($report['rent_quota']))
Quota personale: **€ {{ number_format($report['rent_quota'], 2) }}**
@else
Canone totale: **€ {{ number_format($report['rent'], 2) }}**
@endif
@if($lease->advance_expenses > 0)
## 📌 Anticipo spese da versare:
Quota personale: **€ {{ number_format($report['advance_expenses_quota'], 2) }}**
@endif


---

Al fine di tenerti al corrente delle spese sostenute relative al mese scorso (che verranno conteggiate nel conguaglio finale),
e per la massima trasparenza, eccoti un riepilogo delle spese del mese e dei documenti ad esse relativi.

## ℹ Spese nel mese:
(⚠ Attenzione: non sono da versare adesso. verranno conteggiate nel conguaglio finale)
@if(isset($report['expense_quota']))
Quota personale: **€ {{ number_format($report['expense_quota'], 2) }}**
@else
Totale spese: **€ {{ number_format($report['expenses']->sum('amount'), 2) }}**
@endif

---

## 📎 Documenti allegati
@if(count($report['documents'] ?? []))
Sono stati allegati i documenti relativi alle spese per garantire la massima trasparenza.
@else
Nessun documento allegato.
@endif

---

Grazie,
**{{ $lease->unit->property->landlord->first_name }} {{ $lease->unit->property->landlord->last_name }}**
@endcomponent
