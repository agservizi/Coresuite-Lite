# Configuration Guide

## `.env` File

Create your local environment file from the example template:

```bash
cp .env.example .env
```

## Database Settings

```ini
DB_HOST=localhost
DB_NAME=coresuite_lite
DB_USER=root
DB_PASS=password
```

## Application Settings

```ini
APP_URL=https://suite.example.com
INSTALL_ENABLED=0
```

`APP_URL` is used in generated links such as password reset emails.  
`INSTALL_ENABLED` should be set to `1` only during first-time setup.

## Mail Settings

```ini
MAIL_DRIVER=disabled
MAIL_FROM_NAME="CoreSuite Lite"
MAIL_FROM_EMAIL=no-reply@example.com
MAIL_REPLY_TO=support@example.com
```

Supported mail drivers:

- `disabled`
- `log`
- `smtp`
- `resend`

## SMTP Settings

```ini
SMTP_HOST=smtp.example.com
SMTP_PORT=587
SMTP_USERNAME=mailer@example.com
SMTP_PASSWORD=app_password
SMTP_ENCRYPTION=tls
SMTP_TIMEOUT=15
SMTP_AUTH_ENABLED=1
```

## Resend Settings

```ini
RESEND_API_KEY=re_xxxxx
```

## Recommended Delivery Strategy

- Use `smtp` as the default option for shared hosting and standard business hosting.
- Use `resend` when the buyer prefers API-based email delivery.
- Use `log` for staging or demo environments.
- Avoid leaving the system in `disabled` mode after production setup if password reset is required.

## Admin Configuration Panel

After installation, email delivery can be updated from Workspace Settings:

- application URL
- sender name and sender email
- reply-to address
- SMTP credentials
- Resend API key
- test email sending

## PHP Configuration

```ini
memory_limit = 128M
upload_max_filesize = 10M
post_max_size = 12M
max_execution_time = 30
session.cookie_secure = 1
session.cookie_httponly = 1
session.gc_maxlifetime = 3600
```

## Web Server Configuration

### Apache

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
}
```

## File Permissions

```bash
chmod 644 .env
chmod 644 public/index.php
chmod 755 storage/
chmod 755 storage/uploads/
chmod 755 storage/logs/
```

Grant write access to the upload and log directories for the web server user.

## Performance Suggestions

### OPcache

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### Suggested Monitoring

- PHP errors
- application log volume
- database connections
- response time
- disk usage for uploaded files and generated logs
