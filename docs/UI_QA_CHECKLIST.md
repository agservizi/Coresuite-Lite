# UI QA Checklist - CoreSuite Lite

## 1) Navigazione e layout
- [ ] Topbar visibile e stabile in scroll
- [ ] Sidebar desktop visibile e collassabile
- [ ] Sidebar mobile apribile/chiudibile con overlay
- [ ] Link sidebar con stato attivo corretto
- [ ] Nessun overflow orizzontale su viewport piccoli

## 2) Pagine principali
- [ ] Dashboard: KPI, grafico, liste recenti render corretto
- [ ] Tickets: badge stato/priorita coerenti, tabella allineata
- [ ] Ticket dettaglio: stato/assegnazione/commento funzionanti
- [ ] Documenti: upload/download/delete UI coerente
- [ ] Admin utenti: ricerca/paginazione/form CRUD usabili
- [ ] Profilo: aggiornamento dati e password con feedback

## 3) Flussi auth
- [ ] Login leggibile e centrato
- [ ] Reset password (richiesta link) ok
- [ ] Nuova password (token) ok
- [ ] Installazione: form completo e validazione base

## 4) Tema e resa visiva
- [ ] Light mode coerente su tutte le pagine
- [ ] Dark mode coerente su tutte le pagine
- [ ] Contrasto testo/sfondo adeguato su card, table, form
- [ ] CTA primarie/secondarie consistenti

## 5) Accessibilita minima
- [ ] Focus visibile su link, input, bottoni
- [ ] Label presenti su tutti i campi form
- [ ] Pulsanti con testo/aria-label chiari
- [ ] Azioni critiche con conferma (es. elimina)

## 6) Regressioni tecniche
- [ ] Nessun errore JS in console
- [ ] Nessun warning PHP nelle view
- [ ] Rotte principali raggiungibili da menu
- [ ] Paginazioni e filtri non rompono il layout

## 7) Smoke test rapido (5 minuti)
- [ ] Login -> Dashboard
- [ ] Crea ticket -> Apri dettaglio -> Commenta
- [ ] Carica documento -> Scarica documento
- [ ] Admin: crea utente -> modifica -> elimina
- [ ] Logout -> Login
