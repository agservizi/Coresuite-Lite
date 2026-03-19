# Envato Approval Checklist

Checklist pratica per la submission su CodeCanyon come `PHP Script`.

## 1. Pacchetto consegna

- [ ] Lo ZIP finale contiene solo i file necessari al funzionamento del prodotto.
- [ ] Non sono presenti file temporanei, backup, log locali, screenshot di debug o dump inutili.
- [ ] La root del pacchetto e le cartelle hanno nomi chiari e coerenti.
- [ ] Esiste una cartella/documento dedicata alla documentazione utente.
- [ ] Esiste una cartella separata per asset opzionali, sample data o extras, se inclusi.

## 2. Installazione

- [ ] L’installazione parte da zero senza passaggi manuali nascosti.
- [ ] Le istruzioni coprono requisiti server, database, permessi cartelle e configurazione iniziale.
- [ ] È documentata la procedura di primo accesso.
- [ ] È documentata la procedura di aggiornamento versione.
- [ ] È documentata la procedura di import seed/demo, se prevista.

## 3. Requisiti tecnici

- [ ] Il prodotto funziona come descritto nella demo e nella descrizione.
- [ ] Non ci sono errori PHP, notice, warning o output indesiderato.
- [ ] Non vengono usati short tags PHP.
- [ ] Non ci sono codice obfuscato, base64 sospetti o porzioni nascoste.
- [ ] Il codice commentato morto, TODO lasciati in produzione e frammenti inutilizzati sono stati rimossi.
- [ ] Le dipendenze di terze parti sono realmente necessarie e aggiornate.
- [ ] Le versioni minime richieste di PHP, database e web server sono esplicitate.

## 4. Qualità del codice

- [ ] Struttura file/cartelle ordinata e comprensibile.
- [ ] Naming coerente per controller, view, helper, migration e asset.
- [ ] Validazioni server-side presenti sui form critici.
- [ ] Error handling presente e leggibile per utente e reviewer.
- [ ] Nessuna credenziale reale nel repository o nel pacchetto.
- [ ] File `.env`, chiavi API e segreti non sono inclusi con valori sensibili.
- [ ] I messaggi di errore non espongono stack trace o dettagli sensibili in produzione.

## 5. Sicurezza

- [ ] Query SQL parametrizzate o comunque protette da injection.
- [ ] Output HTML escapato dove serve per prevenire XSS.
- [ ] Upload file validati per tipo, dimensione e percorso.
- [ ] Protezione CSRF presente nei form sensibili.
- [ ] Autenticazione e autorizzazioni coerenti con ruoli e permessi.
- [ ] Le rotte amministrative non sono accessibili senza login.
- [ ] Directory scrivibili limitate al minimo indispensabile.

## 6. UX e UI

- [ ] Layout coerente in dashboard, sidebar, topbar, modali, tabelle e form.
- [ ] Responsive verificato su desktop, tablet e mobile.
- [ ] Nessun overflow orizzontale nelle pagine principali.
- [ ] I campi form mostrano testo, placeholder, focus e validation state correttamente.
- [ ] Le tabelle degradano bene su schermi piccoli.
- [ ] Stati vuoti, loader, errori e conferme sono curati.
- [ ] Contrasti e focus states sono sufficienti per un uso reale.

## 7. Funzionalità core

- [ ] Tutti i moduli promessi nella descrizione sono realmente completi.
- [ ] I flussi `create / read / update / delete` sono presenti dove attesi.
- [ ] Export, PDF, email, calendario, reminder e dashboard funzionano davvero se dichiarati.
- [ ] I dati demo non rompono il prodotto.
- [ ] Le azioni principali sono verificabili in pochi minuti da un reviewer.

## 8. Database e migrazioni

- [ ] `schema.sql` o migrazioni incluse e coerenti con il codice attuale.
- [ ] I seed non dipendono da dati locali dell’autore.
- [ ] Il database si importa senza correzioni manuali.
- [ ] Indici e chiavi essenziali presenti.
- [ ] I valori di default non generano errori o record inconsistenti.

## 9. Traduzioni

- [ ] Interfaccia principale tradotta in tutte le lingue dichiarate.
- [ ] Non restano stringhe hardcoded sparse nelle view.
- [ ] Date, numeri, valuta ed etichette sono coerenti con la lingua scelta.
- [ ] Messaggi flash, errori e footer sono tradotti.

## 10. Documentazione

- [ ] La documentazione è in inglese.
- [ ] Include installazione passo-passo.
- [ ] Include configurazione iniziale.
- [ ] Include gestione utenti/ruoli, se presente.
- [ ] Include crediti e licenze per font, librerie, icone, immagini e plugin di terze parti.
- [ ] Include changelog con versione, data e modifiche.
- [ ] Include troubleshooting per errori comuni.
- [ ] Include screenshot o sezioni visuali per le aree più complesse.

## 11. Item description e demo

- [ ] La descrizione dell’item riflette solo funzionalità realmente presenti.
- [ ] I punti vendita sono chiari, specifici e non generici.
- [ ] La demo pubblica è online e accessibile.
- [ ] Esistono credenziali demo pulite per reviewer o buyer.
- [ ] L’URL demo non mostra errori, dati rotti o pagine incomplete.
- [ ] Le feature premium sono mostrate con esempi realistici.

## 12. Asset e licenze

- [ ] Tutti gli asset di terze parti inclusi sono riutilizzabili legalmente.
- [ ] Font, librerie JS/CSS, icone e immagini sono creditati correttamente.
- [ ] Se una risorsa non può essere redistribuita, è rimossa dal pacchetto e citata in documentazione.
- [ ] Licenze compatibili con la vendita su Envato verificate.

## 13. Supporto e mantenimento

- [ ] Canale supporto definito chiaramente.
- [ ] Tempo medio di risposta ragionevole dichiarato.
- [ ] FAQ iniziale pronta.
- [ ] Changelog pronto per i futuri update.

## 14. QA finale prima dell’upload

- [ ] Test installazione pulita su ambiente vuoto.
- [ ] Test login/logout/reset password.
- [ ] Test CRUD moduli principali.
- [ ] Test responsive su pagine principali.
- [ ] Test console browser senza errori bloccanti.
- [ ] Test PDF/export/upload/email dove presenti.
- [ ] Test con `display_errors=Off` e comportamento produzione.
- [ ] Verifica finale dello ZIP che verrà realmente caricato.

## 15. Priorità reviewer Envato

- [ ] Il prodotto è facile da capire entro 2-3 minuti.
- [ ] Il valore percepito è immediato già dalla dashboard/demo.
- [ ] La qualità grafica è coerente, non “template incompleto”.
- [ ] La documentazione riduce al minimo le domande del reviewer.
- [ ] Non esistono sezioni visibilmente unfinished.

## Fonti ufficiali utili

- Envato Author Help: documentazione requisiti e preparazione item  
  https://help.author.envato.com/
- Item Support Best Practices  
  https://help.author.envato.com/hc/en-us/articles/360000471703-Item-Support-Best-Practices
- Esempio requisiti tecnici con documentazione/crediti/preview Envato  
  https://help.author.envato.com/hc/en-us/articles/7583521740569-Jamstack-Requirements-Next-js
- Esempio requisiti con indicazioni su errori PHP/notices/warnings  
  https://help.author.envato.com/hc/en-us/articles/360000555166-VirtueMart-Template-Submission-Requirements

## Nota

Questa checklist e stata adattata in chiave pratica per uno script PHP su CodeCanyon.
Alcuni punti sono dedotti per analogia dai requisiti ufficiali Envato pubblici per categorie tecniche e dalle best practice di review; quando la pagina specifica della sottocategoria non e disponibile pubblicamente, il criterio e stato inferito dai documenti ufficiali correlati.
