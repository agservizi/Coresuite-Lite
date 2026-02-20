# Requisiti di Sistema

## Server

- **PHP**: 8.2 o superiore
- **MySQL**: 8.0 o superiore
- **Web Server**: Apache 2.4+ o Nginx 1.18+
- **SSL**: Certificato SSL valido (raccomandato)

## Estensioni PHP Richieste

- `pdo` e `pdo_mysql` - Per connessione database
- `mbstring` - Per supporto Unicode
- `fileinfo` - Per validazione file upload
- `session` - Per gestione sessioni
- `filter` - Per validazione input
- `hash` - Per hashing password

## Configurazione PHP

```ini
memory_limit = 128M
upload_max_filesize = 10M
post_max_size = 12M
max_execution_time = 30
session.cookie_secure = 1 (se HTTPS)
session.cookie_httponly = 1
```

## Permessi File System

- `storage/uploads/` - 755 (writable dal web server)
- `storage/logs/` - 755 (writable dal web server)
- `.env` - 600 (leggibile solo owner)

## Browser Supportati

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Hosting Raccomandato

- **Shared Hosting**: Con PHP 8.2+ e MySQL 8+
- **VPS/Cloud**: DigitalOcean, AWS, Google Cloud
- **Minimo**: 1GB RAM, 10GB storage