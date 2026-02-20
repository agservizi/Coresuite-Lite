# CoreSuite Lite

Client Portal + Admin Dashboard - Vendibile su Envato

## Caratteristiche

- **Backend**: PHP 8.2+ puro
- **Database**: MySQL 8+
- **Frontend**: HTML5 + CSS3 + Vanilla JS
- **UI**: Bulma Admin con tema scuro
- **Sicurezza**: CSRF, prepared statements, session hardening

## Installazione

Vedi [docs/INSTALL.md](docs/INSTALL.md)

### Installer in sviluppo

- Per default l'installer web è disabilitato (`INSTALL_ENABLED=0`).
- Se ti serve temporaneamente, imposta `INSTALL_ENABLED=1` nel file `.env`.
- Dopo il setup, reimposta `INSTALL_ENABLED=0`.

## Lancio Locale

```bash
php -S localhost:8000 -t public/
```

## TODO - Features Premium

### Fatturazione
- [ ] Modulo fatture con generazione PDF
- [ ] Integrazione pagamenti (Stripe/PayPal)
- [ ] Gestione IVA e tasse
- [ ] Report finanziari

### Notifiche Email Avanzate
- [ ] Template email personalizzabili
- [ ] Notifiche automatiche per ticket
- [ ] Reminder per scadenze
- [ ] Integrazione SMTP multi-provider

### Workflow Approvazioni
- [ ] Flussi di approvazione multi-step
- [ ] Notifiche per approvazioni
- [ ] Audit trail completo
- [ ] Escalation automatica

### Moduli Premium
- [ ] Modulo progetti con milestone
- [ ] Time tracking
- [ ] Integrazione calendario
- [ ] Reportistica avanzata

### Multi-Tenant
- [ ] Isolamento dati per tenant
- [ ] Branding personalizzato
- [ ] Configurazioni per tenant
- [ ] Billing per tenant

### Sicurezza Avanzata
- [ ] 2FA
- [ ] Audit logging dettagliato
- [ ] Encryption dati sensibili
- [ ] Compliance GDPR

### Performance
- [ ] Caching (Redis/Memcached)
- [ ] Ottimizzazione query
- [ ] CDN per assets
- [ ] Load balancing

### Integrazioni
- [ ] API REST completa
- [ ] Webhooks
- [ ] Integrazione Slack/Teams
- [ ] SSO (Google/Microsoft)