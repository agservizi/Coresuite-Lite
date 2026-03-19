# Envato Approval Audit

Audit rapido del progetto rispetto alla checklist di approvazione Envato per `PHP Script`.

## Esito sintetico

- Stato attuale: `quasi pronto per submission`
- Livello rischio reviewer: `medio`
- Motivo: la base prodotto e ora molto piu credibile lato documentazione, packaging e asset locali; restano soprattutto rifiniture finali di release e un ultimo controllo curatoriale del contenuto distribuito.

## 1. Blocchi critici da chiudere prima dell'upload

### 1.1 Documentazione non ancora pronta per Envato

- Stato: `chiuso`
- Problema:
  - README e documentazione principale sono in italiano, mentre per Envato la documentazione deve essere pronta per un reviewer e buyer internazionale.
  - Il README espone anche una lunga lista `TODO`, che comunica immediatamente prodotto non finito.
- Evidenze:
  - [README.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/README.md#L1)
  - [README.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/README.md#L29)
  - [docs/INSTALL.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/docs/INSTALL.md#L1)
  - [docs/SETUP.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/docs/SETUP.md#L1)
- Azione:
  - tradurre tutta la documentazione in inglese
  - rimuovere il blocco `TODO - Features Premium`
  - convertire README in documento marketing + installazione breve

### 1.2 Pacchetto non pulito per distribuzione

- Stato: `parzialmente chiuso`
- Problema:
  - nel workspace sorgente sono ancora presenti file di sviluppo e log, ma la release e ora gestita con staging e ZIP pulito.
- Evidenze:
  - [public/preview.html](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/public/preview.html)
  - [public/dev_dashboard.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/public/dev_dashboard.php)
  - [server.log](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/server.log)
  - [app/Views/partials/sidebar.php.bak](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/app/Views/partials/sidebar.php.bak)
  - [storage/logs](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/storage/logs)
  - release staging in [dist/coresuite-lite-release](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/dist/coresuite-lite-release)
  - release zip in [coresuite-lite-release.zip](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/dist/coresuite-lite-release.zip)
- Azione:
  - preparare uno ZIP release pulito
  - escludere log, preview, file backup, file temporanei e asset non necessari

### 1.3 Dipendenza CDN non coerente con una distribuzione solida

- Stato: `chiuso`
- Problema:
  - era presente un riferimento CDN diretto nelle view core.
- Evidenze:
  - local loader in [fontawesome.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/app/Views/partials/fontawesome.php)
  - local assets in [public/assets/vendor/fontawesome](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/public/assets/vendor/fontawesome)
- Azione:
  - portare Font Awesome in locale oppure eliminare la dipendenza
  - aggiungere sezione `Third-party assets and licenses` nella documentazione

### 1.4 Seed demo con credenziali hardcoded troppo evidenti

- Stato: `critico`
- Problema:
  - il seed crea utenze demo con password note e le stampa esplicitamente.
  - per demo va bene, ma per submission bisogna presentarlo in modo piu controllato e documentato.
- Evidenze:
  - [seed.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/seed.php#L15)
  - [seed.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/seed.php#L182)
  - [docs/SETUP.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/docs/SETUP.md#L92)
- Azione:
  - spostare le credenziali demo in documentazione reviewer/demo
  - valutare password generate o reset obbligatorio al primo login per ambienti reali

## 2. Aree importanti ma non bloccanti immediate

### 2.1 Nessuna suite test applicativa reale

- Stato: `alto`
- Problema:
  - non emergono test applicativi del prodotto; risultano solo test dentro `node_modules`.
- Evidenze:
  - assenza di cartelle `tests` del progetto
  - presenza solo di test di dipendenze terze
- Azione:
  - aggiungere almeno smoke test manuali documentati o una checklist QA eseguibile

### 2.2 Schema e seed non completamente allineati come storia di installazione

- Stato: `parzialmente chiuso`
- Problema:
  - era presente una separazione poco pulita tra schema e seed.
- Evidenze:
  - [schema.sql](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/schema.sql#L1)
  - [seed.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/seed.php#L33)
- Azione:
  - `schema.sql` ora include anche projects, sales e metadata
  - `seed.php` ora controlla che le tabelle esistano prima di inserire demo data

### 2.3 Crediti/licenze non ancora chiusi come sezione prodotto

- Stato: `alto`
- Problema:
  - ci sono riferimenti sparsi a CDN e librerie, ma non una sezione finale chiara e pronta per buyer.
- Evidenze:
  - [docs/CONFIG.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/docs/CONFIG.md#L169)
  - [public/assets/js/highcharts.js](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/public/assets/js/highcharts.js#L7)
- Azione:
  - creare pagina documentazione `Credits & Licenses`
  - elencare Bootstrap, Chart.js, Highcharts, Font Awesome e relative condizioni d'uso

### 2.4 README posiziona il prodotto come “in sviluppo”

- Stato: `alto`
- Problema:
  - testo come `Installer in sviluppo` e le feature mancanti trasmettono prodotto incompleto.
- Evidenze:
  - [README.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/README.md#L17)
- Azione:
  - sostituire il copy con messaging da release

## 3. Aree gia solide o ben avviate

### 3.1 CSRF presente e verificato

- Stato: `ok`
- Evidenze:
  - helper CSRF in [app/Helpers/csrf.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/app/Helpers/csrf.php#L1)
  - verifica in login e altri controller, ad esempio [app/Controllers/AuthController.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/app/Controllers/AuthController.php#L28)

### 3.2 Prepared statements e struttura MVC presenti

- Stato: `ok`
- Evidenze:
  - accesso DB via PDO in [app/Core/DB.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/app/Core/DB.php#L1)
  - struttura ordinata in `app/Controllers`, `app/Views`, `app/Core`, `app/Middleware`

### 3.3 Installazione guidata esiste

- Stato: `ok ma da rifinire`
- Evidenze:
  - form installer in [app/Views/install.php](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/app/Views/install.php#L1)
- Nota:
  - ottimo per Envato, ma va accompagnato da documentazione inglese coerente e asset locali

### 3.4 Requisiti ambiente e troubleshooting gia presenti

- Stato: `ok ma da tradurre/rifinire`
- Evidenze:
  - [docs/REQUIREMENTS.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/docs/REQUIREMENTS.md#L1)
  - [docs/TROUBLESHOOTING.md](/Users/carminecavaliere/Desktop/AG%20SERVIZI/SITI%20PHP/ENVATO/PHP%20SCRIPT/Coresuite%20Lite/docs/TROUBLESHOOTING.md#L1)

## 4. Valutazione per macro-area

- Pacchetto ZIP: `warning`
- Installazione: `warning`
- Documentazione: `pass`
- Sicurezza base: `pass`
- Qualita codice: `warning`
- UX/UI: `warning`
- Responsive: `warning`
- Demo data: `warning`
- Licenze/crediti: `warning`
- QA finale: `warning`

## 5. Priorita operative consigliate

1. Fare uno smoke test finale installazione + login + CRUD + mobile + PDF
2. Rifinire il contenuto della release rimuovendo dallo stage eventuali sample file non desiderati
3. Valutare se escludere file come `LITE.session.sql`, `tools/screenshot.js` e sample uploads dal pacchetto finale
4. Preparare la pagina item Envato e le credenziali demo reviewer

## 6. Giudizio finale

Il progetto adesso e molto piu vicino a una submission seria: documentazione in inglese, release stage, ZIP, asset locali e una storia di installazione piu coerente.
Prima dell upload farei ancora un ultimo controllo sul contenuto effettivo dello ZIP e una QA manuale finale sui flussi principali.
