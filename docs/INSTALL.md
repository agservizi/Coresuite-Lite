# Installazione CoreSuite Lite

## Requisiti di Sistema

- PHP 8.2 o superiore
- MySQL 8.0 o superiore
- Server web (Apache/Nginx) con supporto mod_rewrite
- Estensioni PHP: PDO, mbstring, fileinfo

## Installazione

1. **Scarica i file** nel tuo web server.

2. **Configura il database**:
   - Crea un nuovo database MySQL.
   - Importa lo schema da `schema.sql`.

3. **Configura l'applicazione**:
   - Copia `.env.example` in `.env`.
   - Modifica `.env` con i tuoi dati:
     ```
     DB_HOST=localhost
     DB_NAME=coresuite_lite
     DB_USER=tuo_utente
     DB_PASS=tua_password
     ```

4. **Imposta permessi**:
   - `storage/uploads/` e `storage/logs/` devono essere scrivibili dal web server.

5. **Installazione guidata**:
   - Vai su `http://tuosito.com/install` per completare la configurazione.

## Lancio in Locale

Usa il server built-in di PHP:

```bash
cd /path/to/coresuite
php -S localhost:8000 -t public/
```

Poi apri `http://localhost:8000` nel browser.

## Hosting Shared

- Carica tutti i file nella cartella `public_html/` o equivalente.
- Assicurati che `.htaccess` sia abilitato.
- Se il dominio punta a una sottocartella, modifica `$basePath` in `public/index.php`.