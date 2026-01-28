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
    <h2>CONTRATTO DI LOCAZIONE AD USO ABITATIVO A CANONE CONCORDATO</h2>

    <p>(Legge 9 dicembre 1998, n. 431, articolo 2, comma 3)</p>
    <p>Tra le sottoscritte parti:</p>
   <p>
        <strong>Locatore:</strong>
        {{ $landlord->first_name }} {{ $landlord->last_name }},
        nat{{ $landlord->birth_place ? 'o a '.$landlord->birth_place : '' }}
        il {{ $landlord->birth_date ? \Carbon\Carbon::parse($landlord->birth_date)->format('d/m/Y') : '___/___/____' }},
        CF {{ $landlord->fiscal_code ?? '________________' }},
        residente in {{ $landlord->address ?? '________________' }},
        {{ $landlord->zip }} {{ $landlord->city }} ({{ $landlord->province }}),
        di seguito denominato "Locatore".
    </p>

    <p><strong>Conduttori:</strong></p>

    @foreach($lease->tenants as $tenant)
        <p>
            {{ $tenant->first_name }} {{ $tenant->last_name }},
            nat{{ $tenant->birth_place ? 'o a '.$tenant->birth_place : '' }}
            il {{ $tenant->birth_date ? \Carbon\Carbon::parse($tenant->birth_date)->format('d/m/Y') : '___/___/____' }},
            CF {{ $tenant->fiscal_code ?? '________________' }},
            residente in {{ $tenant->address ?? '________________' }},
            {{ $tenant->zip }} {{ $tenant->city }} ({{ $tenant->province }}).
        </p>
    @endforeach
    <p>
        Il Locatore concede in locazione ai Conduttori l’unità immobiliare di proprietà del Locatore.sita in
        {{ $property->address ?? '________________' }},
        identificata come {{ $unit->name ?? 'unità immobiliare' }}, al piano
        {{ $unit->floor ?? '__________' }},
         int. {{ $unit->interior ?? '__________' }},
        composta di n. {{ $unit->rooms ?? '____' }} vani, oltre cucina/soggiorno e servizi, e dotata altresì dei seguenti elementi accessori:
        {{ $unit->accessory ?? '________________' }}. L’immobile è ammobiliato come da verbale di consegna, sottoscritto a parte dalle parti,

    </p>

alla sig.ra CASTINI ALICE nata a TRENTO il 22/06/1992, C.F. CSTLCA92H62L378S e residente a TRENTO via CORSO DEGLI ALPINI 15/H, identificata mediante C.I. n. AT7421543 rilasciata dal Comune di TRENTO in data 02/08/2012, di seguito denominata conduttore, che accetta:
l’unità immobiliare posta in Trento – frazione Cadine via Giuseppe Antonio Slop n. 19 piano PRIMO  int. 6 composta di n. 2 vani, oltre cucina/soggiorno e servizi, e dotata altresì dei seguenti elementi accessori: garage di proprietà e posti macchina condominiali in comproprietà. L’immobile è ammobiliato come da verbale di consegna, sottoscritto a parte dalle parti.
    a) estremi catastali identificativi dell'unità immobiliare : C.C. 50 (Trento), P.T. 809, p.ed. 371 sub 80 cat. A/2 classe 6 ; garage C.C. 50 p.ed. 371 sub 122 cat. C/6 classe 2.
    b) prestazione energetica: certificato codice AA00303375 dd. 29/07/2020 consegnato in sede di sottoscrizione del contratto e di cui accusa in tal caso ricevuta con la firma del presente contratto.
La locazione è regolata dalle pattuizioni seguenti.

Articolo 1 (Durata)
Il contratto è stipulato per la durata di TRE anni, dal 01.08.2020 al 31.07.2023  e alla prima scadenza, ove le parti non concordino sul rinnovo del medesimo, il contratto è prorogato di diritto di due anni, fatta salva la facoltà di disdetta da parte del locatore che intenda adibire l'immobile agli usi o effettuare sullo stesso le opere di cui all'articolo 3 della legge n. 431/98, ovvero vendere l'immobile alle condizioni e con le modalità di cui al citato articolo 3. Alla scadenza del periodo di proroga biennale ciascuna parte ha diritto di attivare la procedura per il rinnovo a nuove condizioni ovvero per la rinuncia al rinnovo del contratto, comunicando la propria intenzione con lettera raccomandata da inviare all'altra parte almeno sei mesi prima della scadenza. In mancanza della comunicazione, il contratto è rinnovato tacitamente alle stesse condizioni. Nel caso in cui il locatore abbia riacquistato la disponibilità dell'alloggio alla prima scadenza e non lo adibisca, nel termine di dodici mesi dalla data in cui ha riacquistato tale disponibilità, agli usi per i quali ha esercitato la facoltà di disdetta, il conduttore ha diritto al ripristino del rapporto di locazione alle stesse condizioni di cui al contratto disdettato o, in alternativa, ad un risarcimento pari a trentasei mensilità dell'ultimo canone di locazione corrisposto.
Articolo 2 (Canone)
Il canone  annuo di locazione, secondo quanto stabilito dall’accordo territoriale in vigore nel comune di Trento, è convenuto in euro 7.200,00.- (settemiladuecento/00), che il conduttore si obbliga a corrispondere in n. 12 (dodici) rate  eguali  anticipate  di  euro  600,00.- (seicento/00)  ciascuna,  entro il giorno 1 di ogni mese, mediante accredito su conto corrente bancario indicato dal locatore.
Il canone non viene aggiornato per l’intera durata del contratto, tenuto conto che il locatore opta per la “cedolare secca” come meglio indicato all’art. 5.

Articolo 3 (Deposito cauzionale e altre forme di garanzia)
A garanzia delle obbligazioni assunte col presente contratto, ivi compresa la restituzione dell’immobile a scadenza, il conduttore si impegna a versare al locatore entro e non oltre il giorno 01 agosto 2020 la somma di euro 1.200,00.- (milleduecento/00) pari a due mensilità del canone, non imputabile in conto canoni e non produttiva di interessi. Il deposito cauzionale così costituito viene reso al termine della locazione, previa verifica sia dello stato dell'unità immobiliare sia dell'osservanza di ogni obbligazione contrattuale. Il locatore viene autorizzato ad estinguere qualsiasi debito risultante a carico del conduttore, e particolarmente l’ammontare dei danni riscontrati nell’immobile, nonché l’eventuale pulizia di cui necessiteranno a suo parere i locali, mediante compensazione sul deposito cauzionale. Il conduttore dovrà avvisare il proprietario degli eventuali difetti dell’immobile.

Articolo 4 (Oneri accessori)
Tutte le spese di ordinaria manutenzione, relative ai consumi ed ogni altro oneri di gestione dei locali sono a carico del conduttore. In particolar modo si prevede che:
- la tassa comunale di smaltimento dei rifiuti solidi urbani e le utenze di energia elettrica e gas dovranno essere corrisposte direttamente dal conduttore per tutto il periodo della locazione. A tal fine il locatore si impegna a provvedere, entro 30 giorni dalla data del contratto, all’intestazione delle relative utenze dandone comunicazione al locatario;
- le utenze di acqua, riscaldamento, pulizie condominiali ed eventuali altre spese relative ai consumi saranno corrisposte direttamente dal locatario al Condominio.
In base all’andamento delle spese condominiali degli ultimi anni le parti concordano che il conduttore versi mensilmente, unitamente al pagamento della rata mensile del canone annuale, al locatore  una quota di acconto pari ad € 60,00.- (euro sessanta/00), salvo conguaglio. In sede di consuntivo, il pagamento degli oneri anzidetti, per la quota parte di quelli condominiali/comuni a carico del conduttore, deve avvenire entro trenta giorni dalla richiesta. Entro il medesimo termine il locatore provvederà all’eventuale rimborso in caso di versamenti eccedenti, salvo le parti concordino di trattenere i maggiori versamenti quale acconto per l’anno successivo. Prima di effettuare il pagamento, il conduttore ha diritto di ottenere l'indicazione specifica delle spese anzidette e dei criteri di ripartizione. Ha inoltre diritto di prendere visione - anche tramite organizzazioni sindacali - presso il locatore o  l'amministratore condominiale, dei documenti giustificativi delle spese effettuate.
Restano a carico del locatore le spese straordinarie e le spese generali/amministrative del condominio.

Articolo 5 (Spese di bollo e di registrazione)
Il locatore intende esercitare l’opzione “cedolare secca” per registrazione e tassazione del presente contratto di locazione, come definito dall’articolo 3 del D.Lgs. 23/2011. Per effetto di tale opzione non si renderà applicabile, per il periodo di validità dell’opzione stessa, il pagamento dell’IRPEF, dell’imposta di registro e di bollo, ivi comprese quelle sulla risoluzione e sulle proroghe del contratto. La presente opzione di assoggettamento fiscale si intende valida fino alla scadenza contrattuale, salvo diversa revoca da parte del locatore, che si impegna fin da ora a comunicarla tempestivamente ai conduttori. Il locatore provvede alla registrazione del contratto, dandone documentata comunicazione ai conduttori e all’Amministratore del condominio ai sensi dell’art. 13 legge 431 del 1998.


Articolo 6 (Pagamento)
Il pagamento del canone o di quant'altro dovuto anche per oneri accessori non può venire sospeso o ritardato da pretese o eccezioni del conduttore, quale ne sia il titolo. Il mancato puntuale pagamento, per qualsiasi causa, anche di una sola rata del canone, nonché di quant'altro dovuto, ove di importo pari almeno ad una mensilità del canone, costituisce in mora il conduttore, fatto salvo quanto previsto dall'articolo 55 della legge 27 luglio 1978, n. 392.

Articolo 7 (Uso)
L'immobile deve essere destinato esclusivamente a civile abitazione del conduttore e dei propri familiari/conviventi. Salvo espresso patto scritto contrario, è fatto divieto di sublocazione e di comodato sia totale sia parziale. Per la successione nel contratto si applica l'articolo 6 della legge n. 392/78, nel testo vigente a seguito della sentenza della Corte costituzionale n. 404/1988.

Articolo 8 (Recesso del conduttore)
E' facoltà del conduttore recedere dal contratto per gravi motivi, previo avviso da recapitarsi tramite lettera raccomandata almeno sei mesi prima.

Articolo 9 (Consegna)
Il conduttore dichiara di aver visitato l'unità immobiliare locatagli, di averla trovata adatta all'uso convenuto, tinteggiata a nuovo e pulita, e, pertanto, di prenderla in consegna ad ogni effetto col ritiro delle chiavi, costituendosi da quel momento custode della stessa. Il conduttore si impegna a riconsegnare l'unità immobiliare nello stato in cui l'ha ricevuta, tinteggiata a nuovo e pulita, salvo il deperimento d'uso, pena il risarcimento del danno. Si impegna, altresì, a rispettare le norme del regolamento di condominio, consegnato in sede di sottoscrizione del contratto e di cui accusa in tal caso ricevuta dello stesso con la firma del presente contratto, così come si impegna ad osservare le deliberazioni dell'assemblea dei condomini. È in ogni caso vietato al conduttore compiere atti e tenere comportamenti che possano recare molestia agli altri abitanti dello stabile. Le parti danno atto, in relazione allo stato dell'unità immobiliare, di quanto risulta dal verbale di consegna, sottoscritto dalle parte contestualmente al presente contratto.

Articolo 10 (Modifiche e danni)
Il conduttore non può apportare alcuna modifica, innovazione, miglioria o addizione ai locali locati ed alla loro destinazione, o agli impianti esistenti, senza il preventivo consenso scritto del locatore. Il conduttore esonera espressamente il locatore da ogni responsabilità per danni diretti o indiretti che possano derivargli da fatti dei dipendenti del locatore medesimo nonché per interruzioni incolpevoli dei servizi.

Articolo 11 (Assemblee)
Il conduttore ha diritto di voto, in luogo del proprietario dell'unità immobiliare locatagli, nelle deliberazioni dell'assemblea condominiale relative alle spese ed alle modalità di gestione dei servizi di riscaldamento. Ha inoltre diritto di intervenire, senza voto, sulle deliberazioni relative alla modificazione degli altri servizi comuni.

Articolo 12 (Impianti)
Il locatore dichiara che gli impianti tecnologici presenti nell’immobile sono conformi alle normative tecniche e amministrative vigenti alla data della loro installazione o dal loro ultimo adeguamento obbligatorio. I conduttori dichiarano di essere a conoscenza di tale situazione, accettando il bene nello stato dichiarato dal locatore. Le parti concordano di non allegare le certificazioni d’impianti al presente contratto.
Articolo 13 (Accesso)
Il conduttore deve consentire l'accesso all'unità immobiliare al locatore, al suo amministratore nonché ai loro incaricati ove gli stessi ne abbiano - motivandola - ragione.
Nel caso in cui il locatore intenda vendere o, in caso di recesso anticipato del conduttore, locare l'unità immobiliare, questi deve consentirne la visita una volta la settimana, per almeno due ore, con esclusione dei giorni	festivi, con modalità che verranno in seguito concordate tra le parti.

Articolo 14 (Commissione di negoziazione paritetica e conciliazione stragiudiziale)
La Commissione di cui all’articolo 6 del decreto del Ministro delle infrastrutture e dei trasporti di concerto con il Ministro dell’economia e delle finanze, emanato ai sensi dell’articolo 4, comma 2, della legge 431 del 1998, è composta da due membri scelti fra appartenenti alle rispettive organizzazioni firmatarie dell'Accordo territoriale sulla base delle designazioni, rispettivamente, del locatore e del conduttore. L’operato  della  Commissione  è  disciplinato  dal  documento  “Procedure  di  negoziazione  e conciliazione stragiudiziale nonché modalità di funzionamento della Commissione”, Allegato E al citato decreto. La richiesta di intervento della Commissione non determina la sospensione delle obbligazioni contrattuali. La richiesta di attivazione della Commissione non comporta oneri.

Articolo 15 (Varie)
A tutti gli effetti del presente contratto, compresa la notifica degli atti esecutivi, e ai fini della competenza a giudicare, i conduttori eleggono domicilio nei locali a loro locati e, ove più non li occupino o comunque detengano, presso l'ufficio di segreteria del Comune ove è situato l'immobile locato. Qualunque modifica al presente contratto non può aver luogo, e non può essere provata, se non con atto scritto.
Il locatore ed il conduttore si autorizzano reciprocamente a comunicare a terzi i propri dati personali in relazione ad adempimenti connessi col rapporto di locazione (GDPR - Regolamento Ue 2016/679).
Per quanto non previsto dal presente contratto le parti rinviano a quanto in materia disposto dal Codice civile, dalle leggi n. 392/1978 e n. 431 del 1998 o comunque dalle norme vigenti e dagli usi locali nonché alla normativa ministeriale emanata in applicazione della legge n. 431 del 1998 ed all'Accordo definito in sede locale.

Letto, approvato e sottoscritto

Trento, li 31 luglio 2020

Il locatore
Il conduttore
……………………………………
……………………………………

A mente degli articoli 1341 e 1342 del codice civile, le parti specificamente approvano i patti di cui agli articoli 3 (Deposito cauzionale e altre forme di garanzia), 4 (Oneri accessori), 6 (Pagamento), 9 (Consegna), 10 (Modifiche e danni), 12 (Impianti), 13 (Accesso), 14 (Commissione di negoziazione paritetica e conciliazione stragiudiziale) e 15 (Varie) del presente contratto.

Il locatore
Il conduttore
……………………………………
……………………………………
