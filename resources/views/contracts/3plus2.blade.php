<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Contratto di locazione 3+2</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.4; }
        h1, h2, h3 { text-align: center; }
        .section-title { font-weight: bold; margin-top: 15px; text-decoration: underline; }
        .mt-10 { margin-top: 10px; }
    </style>
</head>
<body>

    <h2>CONTRATTO DI LOCAZIONE AD USO ABITATIVO (3+2)</h2>

    <p>
        Tra i sottoscritti:
    </p>

    <p><strong>Locatore:</strong></p>
    <p>
        {{ $landlord->first_name }} {{ $landlord->last_name }},
        nat{{ $landlord->birth_place ? 'o a '.$landlord->birth_place : '' }}
        il {{ $landlord->birth_date ? \Carbon\Carbon::parse($landlord->birth_date)->format('d/m/Y') : '___/___/____' }},
        CF {{ $landlord->fiscal_code ?? '________________' }},
        Documento: {{ $landlord->document_type ?? '________________' }} n.
        {{ $landlord->document_number ?? '________________' }},
        rilasciato da {{ $landlord->document_issuer ?? '________________' }}
        il {{ $landlord->document_issue_date ? \Carbon\Carbon::parse($landlord->document_issue_date)->format('d/m/Y') : '___/___/____' }},
        residente in {{ $landlord->address ?? '________________' }},
        {{ $landlord->zip }} {{ $landlord->city }} ({{ $landlord->province }}),
        di seguito denominato "Locatore".
    </p>

    <p><strong>Conduttore:</strong></p>

    @foreach($lease->tenants as $tenant)
        <p>
            {{ $tenant->first_name }} {{ $tenant->last_name }},
            nat{{ $tenant->birth_place ? 'o a '.$tenant->birth_place : '' }}
            il {{ $tenant->birth_date ? \Carbon\Carbon::parse($tenant->birth_date)->format('d/m/Y') : '___/___/____' }},
            CF {{ $tenant->fiscal_code ?? '________________' }},
            Documento: {{ $tenant->identity_document_type ?? '________________' }} n.
            {{ $tenant->identity_document_number ?? '________________' }},
            rilasciato da {{ $tenant->identity_document_issued_by ?? '________________' }}
            il {{ $tenant->identity_document_issued_date ? \Carbon\Carbon::parse($tenant->identity_document_issued_date)->format('d/m/Y') : '___/___/____' }},
            residente in {{ $tenant->address ?? '________________' }},
            {{ $tenant->zip }} {{ $tenant->city }} ({{ $tenant->province }}).
        </p>
    @endforeach


    <p class="section-title">Art. 1 - (Oggetto della locazione)</p>
    <p>
        Il Locatore concede in locazione al Conduttore l’unità immobiliare di proprietà del Locatore.sita in
        {{ $property->address ?? '________________' }},
        identificata come {{ $unit->name ?? 'unità immobiliare' }}, al piano
        {{ $unit->floor ?? '__________' }},
         int. {{ $unit->interior ?? '__________' }},
        composta di n. {{ $unit->rooms ?? '____' }} vani, oltre cucina/soggiorno e servizi, e dotata altresì dei seguenti elementi accessori:
        {{ $unit->accessory ?? '________________' }}.
        estremi catastali identificativi dell'unità immobiliare :
        foglio {{ $property->cadastral_sheet ?? '__________' }},
        particella {{ $property->cadastral_particle ?? '__________' }},
        subalterno {{ $property->cadastral_sub ?? '__________' }},
        categoria {{ $property->cadastral_category ?? '__________' }},
        classe {{ $property->cadastral_class ?? '__________' }},
        rendita catastale Euro {{ $property->cadastral_rent ? number_format($property->cadastral_rent, 2, ',', '.') : '__________' }}.

        L’immobile è ammobiliato come da verbale di consegna, sottoscritto a parte dalle parti,

    </p>

    <p class="section-title">Art. 2 - (Durata)</p>
    <p>
        Come previsto ex art. 2 , co. 5, legge 431/98 il contratto è stipulato per la durata minima di anni tre (3), dal
        {{ \Carbon\Carbon::parse($lease->start_date)->format('d/m/Y') }}
        al
        {{ $lease->end_date ? \Carbon\Carbon::parse($lease->end_date)->format('d/m/Y') : '___/___/____' }},
        , e alla prima scadenza, ove le parti non concordino sul rinnovo del medesimo, il contratto è prorogato di
        diritto di due (2) anni, fatta salva la facoltà di disdetta da parte del Locatore che intenda adibire
        l'immobile agli usi o effettuare sullo stesso le opere di cui all'articolo 3 della legge n. 431/98,
        ovvero vendere l'immobile alle condizioni e con le modalità di cui al citato articolo 3.
        Alla scadenza del periodo di proroga biennale ciascuna parte ha diritto di attivare la procedura per il
        rinnovo a nuove condizioni ovvero per la rinuncia al rinnovo del contratto, comunicando la propria intenzione
        con lettera raccomandata da inviare all'altra parte almeno sei mesi prima della scadenza.
        In mancanza della comunicazione, il contratto è rinnovato tacitamente alle stesse condizioni.
        Nel caso in cui il Locatore abbia riacquistato la disponibilità dell'alloggio alla prima scadenza e non lo adibisca,
        nel termine di dodici (12) mesi dalla data in cui ha riacquistato tale disponibilità,
        agli usi per i quali ha esercitato la facoltà di disdetta, il Conduttore ha diritto al ripristino del
        rapporto di locazione alle stesse condizioni di cui al contratto disdettato o, in alternativa,
        ad un risarcimento pari a trentasei mensilità dell'ultimo canone di locazione corrisposto.
    </p>

    <p class="section-title">Art. 3 - (Canone)</p>
    <p>
        Il canone annuo di locazione è convenuto in Euro
        {{ number_format($lease->rent_amount * 12, 2, ',', '.') }} - (
        {{ \App\Models\Lease::convertNumberToWords($lease->rent_amount * 12) }} Euro),
        che il conduttore si obbliga a corrispondere in n. 12 (dodici) rate  eguali  anticipate  di Euro
        {{ number_format($lease->rent_amount, 2, ',', '.') }} - ( {{ \App\Models\Lease::convertNumberToWords($lease->rent_amount) }} Euro)ciascuna,
        entro il giorno {{ $lease->payment_day ?? '1' }} di ogni mese, mediante accredito su conto corrente bancario indicato dal locatore.
        Il canone non viene aggiornato per l’intera durata del contratto, tenuto conto che il locatore opta per la “cedolare secca” come meglio indicato all’art. 6 del presente contratto.
    </p>

    @if($lease->advance_expenses)
        <p>
            A titolo di anticipo spese condominiali, il Conduttore corrisponderà inoltre
            Euro {{ number_format($lease->advance_expenses, 2, ',', '.') }} - ( {{ \App\Models\Lease::convertNumberToWords($lease->advance_expenses) }} Euro) mensili.
        </p>
    @endif

    <p class="section-title">Art. 4 - (Deposito cauzionale)</p>
    <p>A garanzia delle obbligazioni assunte col presente contratto, ivi compresa la restituzione dell’immobile a scadenza,
        il conduttore si impegna a versare al locatore entro e non oltre il giorno 01 agosto 2020 la somma di Euro
        {{ $lease->deposit_amount ? number_format($lease->deposit_amount, 2, ',', '.') : '__________' }} - (
        {{ $lease->deposit_amount ? \App\Models\Lease::convertNumberToWords($lease->deposit_amount) : '________________' }} Euro),
        pari a due mensilità del canone, non imputabile in conto canoni e non produttiva di interessi.
        Il deposito cauzionale così costituito viene reso al termine della locazione, previa verifica sia dello
        stato dell'unità immobiliare sia dell'osservanza di ogni obbligazione contrattuale.
        Il locatore viene autorizzato ad estinguere qualsiasi debito risultante a carico del conduttore,
        e particolarmente l’ammontare dei danni riscontrati nell’immobile, nonché l’eventuale pulizia di cui necessiteranno
        a suo parere i locali, mediante compensazione sul deposito cauzionale.
        Il conduttore dovrà avvisare il proprietario degli eventuali difetti dell’immobile.
    </p>

    <p class="section-title">Art. 5 - (Oneri accessori)</p>
    <p>
        Tutte le spese di ordinaria manutenzione, relative ai consumi ed ogni altro oneri di gestione dei locali sono a carico del conduttore.
        In particolar modo si prevede che:
<ul>
<li> la tassa comunale di smaltimento dei rifiuti solidi urbani e le utenze di energia elettrica e gas
dovranno essere corrisposte direttamente dal conduttore per tutto il periodo della locazione.
A tal fine il locatore si impegna a provvedere, entro 30 giorni dalla data del contratto, all’intestazione delle relative utenze dandone comunicazione al locatario;</li>
<li> le utenze di acqua, riscaldamento, pulizie condominiali ed eventuali altre spese relative ai consumi saranno corrisposte direttamente dal locatario al Condominio.</li>
</ul>
In base all’andamento delle spese condominiali degli ultimi anni le parti concordano che il conduttore versi mensilmente,
unitamente al pagamento della rata mensile del canone annuale, al locatore  una quota di acconto pari ad € {{ number_format($lease->advance_expenses, 2, ',', '.') }} - ( {{ \App\Models\Lease::convertNumberToWords($lease->advance_expenses) }} Euro) - salvo conguaglio.
In sede di consuntivo, il pagamento degli oneri anzidetti,
per la quota parte di quelli condominiali/comuni a carico del conduttore, deve avvenire entro trenta giorni dalla richiesta.
Entro il medesimo termine il locatore provvederà all’eventuale rimborso in caso di versamenti eccedenti,
salvo le parti concordino di trattenere i maggiori versamenti quale acconto per l’anno successivo.
Prima di effettuare il pagamento, il conduttore ha diritto di ottenere l'indicazione specifica delle spese anzidette
e dei criteri di ripartizione. Ha inoltre diritto di prendere visione - anche tramite organizzazioni sindacali -
presso il locatore o  l'amministratore condominiale, dei documenti giustificativi delle spese effettuate.
Restano a carico del locatore le spese straordinarie e le spese generali/amministrative del condominio.
    </p>

    <p class="section-title">Art. 6 - (Cedolare secca)</p>

    <p>
        Il locatore opta per il regime della "cedolare secca" di cui agli artt. 3 e 3-bis del D.Lgs. n. 23/2011,
        rinunciando espressamente alla facoltà di chiedere l'aggiornamento del canone di locazione,
        compreso quello derivante da clausole contrattuali di indicizzazione.
        Pertanto, il locatore non potrà richiedere al conduttore, a qualsiasi titolo, somme aggiuntive rispetto al canone pattuito.
    </p>

    <p class="section-title">Art. 7 - (Pagamento)</p>
    <p>
Il pagamento del canone o di quant'altro dovuto anche per oneri accessori non può venire sospeso o ritardato
 da pretese o eccezioni del conduttore, quale ne sia il titolo.
 Il mancato puntuale pagamento, per qualsiasi causa, anche di una sola rata del canone, nonché di quant'altro dovuto,
  ove di importo pari almeno ad una mensilità del canone, costituisce in mora il conduttore,
  fatto salvo quanto previsto dall'articolo 55 della legge 27 luglio 1978, n. 392.
    </p>

    <p class="section-title">Art. 8 - (Uso)</p>
    <p>
        L'immobile deve essere destinato esclusivamente a civile abitazione del conduttore e dei propri familiari/conviventi.
        Salvo espresso patto scritto contrario, è fatto divieto di sublocazione e di comodato sia totale sia parziale.
        Per la successione nel contratto si applica l'articolo 6 della legge n. 392/78, nel testo vigente a
        seguito della sentenza della Corte costituzionale n. 404/1988.
    </p>

    <p class="section-title">Art. 9 - (Recesso del conduttore)</p>
    <p>
        E' facoltà del conduttore recedere dal contratto per gravi motivi, previo avviso da recapitarsi tramite lettera raccomandata almeno sei mesi prima.
    </p>

    <p class="section-title">Art. 10 - (Consegna)</p>
    <p>
        Il conduttore dichiara di aver visitato l'unità immobiliare locatagli, di averla trovata adatta all'uso convenuto, tinteggiata a nuovo e pulita, e, pertanto, di prenderla in consegna ad ogni effetto col ritiro delle chiavi, costituendosi da quel momento custode della stessa. Il conduttore si impegna a riconsegnare l'unità immobiliare nello stato in cui l'ha ricevuta, tinteggiata a nuovo e pulita, salvo il deperimento d'uso, pena il risarcimento del danno. Si impegna, altresì, a rispettare le norme del regolamento di condominio, consegnato in sede di sottoscrizione del contratto e di cui accusa in tal caso ricevuta dello stesso con la firma del presente contratto, così come si impegna ad osservare le deliberazioni dell'assemblea dei condomini. È in ogni caso vietato al conduttore compiere atti e tenere comportamenti che possano recare molestia agli altri abitanti dello stabile. Le parti danno atto, in relazione allo stato dell'unità immobiliare, di quanto risulta dal verbale di consegna, sottoscritto dalle parte contestualmente al presente contratto.
    </p>

   <p class="section-title">Art. 11 (Modifiche e danni)</p>
    <p>
Il conduttore non può apportare alcuna modifica, innovazione, miglioria o addizione ai locali locati ed alla loro destinazione, o agli impianti esistenti, senza il preventivo consenso scritto del locatore. Il conduttore esonera espressamente il locatore da ogni responsabilità per danni diretti o indiretti che possano derivargli da fatti dei dipendenti del locatore medesimo nonché per interruzioni incolpevoli dei servizi.
    </p>

    <p class="section-title">Art. 12 (Assemblee)</p>
    <p>
Il conduttore ha diritto di voto, in luogo del proprietario dell'unità immobiliare locatagli, nelle deliberazioni dell'assemblea condominiale relative alle spese ed alle modalità di gestione dei servizi di riscaldamento. Ha inoltre diritto di intervenire, senza voto, sulle deliberazioni relative alla modificazione degli altri servizi comuni.
    </p>

    <p class="section-title">Art. 13 (Impianti)</p>
    <p>
Il locatore dichiara che gli impianti tecnologici presenti nell’immobile sono conformi alle normative tecniche e amministrative vigenti alla data della loro installazione o dal loro ultimo adeguamento obbligatorio. I conduttori dichiarano di essere a conoscenza di tale situazione, accettando il bene nello stato dichiarato dal locatore. Le parti concordano di non allegare le certificazioni d’impianti al presente contratto.
Art. 14 (Accesso)
Il conduttore deve consentire l'accesso all'unità immobiliare al locatore, al suo amministratore nonché ai loro incaricati ove gli stessi ne abbiano - motivandola - ragione.
Nel caso in cui il locatore intenda vendere o, in caso di recesso anticipato del conduttore, locare l'unità immobiliare, questi deve consentirne la visita una volta la settimana, per almeno due ore, con esclusione dei giorni festivi, con modalità che verranno in seguito concordate tra le parti.
        </p>

        <p class="section-title">Art. 15 (Commissione di negoziazione paritetica e conciliazione stragiudiziale)</p>
        <p>
La Commissione di cui all’Art. 6 del decreto del Ministro delle infrastrutture e dei trasporti di concerto con il Ministro dell’economia e delle finanze, emanato ai sensi dell’Art. 4, comma 2, della legge 431 del 1998, è composta da due membri scelti fra appartenenti alle rispettive organizzazioni firmatarie dell'Accordo territoriale sulla base delle designazioni, rispettivamente, del locatore e del conduttore. L’operato  della  Commissione  è  disciplinato  dal  documento  “Procedure  di  negoziazione  e conciliazione stragiudiziale nonché modalità di funzionamento della Commissione”, Allegato E al citato decreto. La richiesta di intervento della Commissione non determina la sospensione delle obbligazioni contrattuali. La richiesta di attivazione della Commissione non comporta oneri.
        </p>

        <p class="section-title">Art. 16 (Varie)</p>
        <p>
A tutti gli effetti del presente contratto, compresa la notifica degli atti esecutivi, e ai fini della competenza a giudicare, i conduttori eleggono domicilio nei locali a loro locati e, ove più non li occupino o comunque detengano, presso l'ufficio di segreteria del Comune ove è situato l'immobile locato. Qualunque modifica al presente contratto non può aver luogo, e non può essere provata, se non con atto scritto.
Il locatore ed il conduttore si autorizzano reciprocamente a comunicare a terzi i propri dati personali in relazione ad adempimenti connessi col rapporto di locazione (GDPR - Regolamento Ue 2016/679).
Per quanto non previsto dal presente contratto le parti rinviano a quanto in materia disposto dal Codice civile, dalle leggi n. 392/1978 e n. 431 del 1998 o comunque dalle norme vigenti e dagli usi locali nonché alla normativa ministeriale emanata in applicazione della legge n. 431 del 1998 ed all'Accordo definito in sede locale.
        </p>
    <p class="mt-10">
        Letto, confermato e sottoscritto.
    </p>

    <p class="mt-10">
        Luogo e data: ______________________________
    </p>

    <p class="mt-10">
        Il Locatore: ______________________________
    </p>

    <p class="mt-10">
        Il Conduttore: ____________________________
    </p>

</body>
</html>
