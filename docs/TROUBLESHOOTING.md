# Troubleshooting

## Problemi Comuni

### Errore Database Connection
**Sintomi**: Pagina bianca o errore "Database connection failed"
**Soluzioni**:
1. Verifica credenziali in `.env`
2. Controlla che MySQL sia attivo
3. Verifica permessi utente database
4. Controlla firewall/network

### Pagina 404
**Sintomi**: "Page not found" su tutte le route
**Soluzioni**:
1. Verifica che `mod_rewrite` sia abilitato su Apache
2. Controlla che `.htaccess` sia presente in `public/`
3. Su Nginx, configura rewrite rules

### Upload File Fallisce
**Sintomi**: File non caricati, errori permessi
**Soluzioni**:
1. Verifica permessi `storage/uploads/` (755)
2. Controlla `upload_max_filesize` in php.ini
3. Verifica spazio disco disponibile

### Sessioni Non Funzionano
**Sintomi**: Logout automatico, dati non salvati
**Soluzioni**:
1. Verifica che `session.save_path` sia scrivibile
2. Controlla cookie settings
3. Su HTTPS, assicurati `session.cookie_secure = 1`

### Email Non Inviate
**Sintomi**: Reset password non funziona
**Soluzioni**:
1. Configura Resend API key in `.env`
2. Verifica connessione internet
3. Controlla logs per errori API

## Debug Mode

Abilita debug aggiungendo in `public/index.php`:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

## Logs

I log sono salvati in `storage/logs/`:
- `auth.log` - Login/logout
- `error.log` - Errori PHP
- `audit.log` - Azioni utenti

## Performance Issues

### Query Lente
1. Aggiungi indici mancanti
2. Usa EXPLAIN per analizzare query
3. Considera caching per dati statici

### Memoria Alta
1. Verifica `memory_limit` in php.ini
2. Ottimizza query per ridurre dataset
3. Usa pagination per liste grandi

### CPU Alta
1. Disabilita debug in produzione
2. Usa opcode cache (OPcache)
3. Ottimizza loop e algoritmi

## Sicurezza

### Controlli Post-Install
- Rimuovi `install.php` dopo setup
- Cambia password admin default
- Verifica permessi file (600 per .env)
- Abilita HTTPS
- Configura backup automatici

### Audit
Controlla `audit_logs` table per attività sospette:
```sql
SELECT * FROM audit_logs WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY);
```

## Hosting Specifici

### cPanel
- Usa File Manager per upload
- Configura cron jobs per backup
- Verifica PHP version in MultiPHP Manager

### Plesk
- Usa File Manager per permessi
- Configura backup in Backup Manager
- Verifica PHP settings in PHP Settings

### VPS
- Installa fail2ban per protezione brute force
- Configura firewall (ufw/iptables)
- Setup monitoring (Nagios/Zabbix)