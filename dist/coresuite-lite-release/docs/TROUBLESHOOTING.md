# Troubleshooting

## Common Issues

### Database Connection Failed

Symptoms:

- blank page
- database connection exception
- installer cannot continue

Checks:

1. Verify database values in `.env`
2. Confirm MySQL is running
3. Confirm the database user has the required permissions
4. Verify firewall or hosting restrictions

### 404 on All Routes

Checks:

1. Confirm Apache `mod_rewrite` is enabled
2. Confirm `public/.htaccess` is present
3. Confirm Nginx routes are forwarded to `index.php`
4. Confirm the domain points to the correct public directory

### File Upload Fails

Checks:

1. Make sure `storage/uploads/` is writable
2. Check `upload_max_filesize`
3. Check `post_max_size`
4. Confirm enough disk space is available

### Sessions Do Not Persist

Checks:

1. Confirm the session save path is writable
2. Review cookie settings
3. Under HTTPS, enable `session.cookie_secure = 1`

### Password Reset Email Is Not Sent

Checks:

1. Confirm `MAIL_DRIVER` is not `disabled`
2. Confirm `APP_URL` is correct
3. If using SMTP, verify host, port, username, password, and encryption
4. If using Resend, verify the API key
5. Send a test email from Workspace Settings
6. Review application logs for mail-related failures

### Password Reset Link Uses the Wrong Domain

Checks:

1. Set `APP_URL` to the public production URL
2. Review reverse proxy or HTTPS forwarding settings
3. Review saved workspace settings if the application URL was already stored there

### SMTP Authentication Failed

Checks:

1. Verify SMTP username and password
2. Confirm whether the provider requires an app password
3. Try `tls` on port `587`
4. Try `ssl` on port `465`
5. Disable `SMTP_AUTH_ENABLED` only if your server supports trusted local relay

### Log Driver Is Active but No Real Email Arrives

Checks:

1. Confirm `MAIL_DRIVER` is not set to `log`
2. Review application logs
3. Switch to `smtp` or `resend` for real delivery

## Temporary Debug Mode

For local debugging only, you can enable error output in `public/index.php`:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

Do not leave this enabled in production.

## Log Locations

- application logs: `storage/logs/`
- audit activity: `audit_logs` table
- upload-related issues: check both PHP settings and application logs

## Post-Installation Security Review

- disable the installer
- change demo credentials if sample data was imported
- confirm file permissions
- enable HTTPS
- set a real sender email for password reset
- verify writable directories are limited to storage paths only
