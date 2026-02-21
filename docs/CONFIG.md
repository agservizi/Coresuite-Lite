# Configurazione

## File .env

Crea `.env` dalla copia di `.env.example`:

```bash
cp .env.example .env
```

### Variabili Database
```bash
DB_HOST=localhost          # Host MySQL
DB_NAME=coresuite_lite     # Nome database
DB_USER=root              # Utente database
DB_PASS=password          # Password database
```

### Variabili Email (Opzionale)
```bash
RESEND_API_KEY=your_api_key_here
```

## Configurazione PHP

### php.ini
```ini
; Memoria
memory_limit = 128M

; Upload
upload_max_filesize = 10M
post_max_size = 12M

; Timeout
max_execution_time = 30

; Sessioni
session.cookie_secure = 1    ; Per HTTPS
session.cookie_httponly = 1
session.gc_maxlifetime = 3600
```

## Configurazione Web Server

### Apache (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## Sicurezza

### Permessi File
```bash
# File
chmod 644 .env
chmod 644 public/index.php

# Directory
chmod 755 storage/
chmod 755 storage/uploads/
chmod 755 storage/logs/

# Web server writable
chown www-data:www-data storage/uploads/
chown www-data:www-data storage/logs/
```

### HTTPS
Configura SSL certificate:
- Let's Encrypt (gratuito)
- Certificato commerciale
- Self-signed (solo sviluppo)

### Firewall
```bash
# UFW (Ubuntu)
ufw allow 80
ufw allow 443
ufw enable

# IPTables
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 443 -j ACCEPT
```

## Ottimizzazione Performance

### OPcache
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

-### CDN
Servi assets statici da CDN:
- FontAwesome via CDN (usato per le icone)
- CloudFlare per assets personalizzati

### Caching
Implementa caching per:
- Query frequenti
- Configurazioni
- Sessioni

## Ambiente di Sviluppo

### Docker
```dockerfile
FROM php:8.2-apache
COPY . /var/www/html
RUN docker-php-ext-install pdo pdo_mysql
EXPOSE 80
```

### Vagrant
```ruby
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/focal64"
  config.vm.network "forwarded_port", guest: 80, host: 8080
end
```

## Monitoraggio

### Logs
- PHP errors: `storage/logs/error.log`
- Access logs: configura web server
- Audit logs: tabella `audit_logs`

### Metriche
Monitora:
- CPU/Memoria usage
- Database connections
- Response times
- Error rates

### Alerting
Configura alert per:
- Error rate > 5%
- Response time > 2s
- Disk space < 10%