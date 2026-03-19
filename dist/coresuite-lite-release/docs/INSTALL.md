# Installation Guide

## Server Requirements

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Apache or Nginx with URL rewriting enabled
- Required PHP extensions:
  - `pdo`
  - `pdo_mysql`
  - `mbstring`
  - `fileinfo`
  - `session`

## Installation Steps

1. Upload the application files to your hosting account.
2. Create a new MySQL database.
3. Import `schema.sql` into the database.
4. Make the following directories writable by the web server:
   - `storage/uploads/`
   - `storage/logs/`
5. Open `https://your-domain.com/install`.
6. Complete the installer form with database, administrator, app URL and optional mail settings.
7. Finish the setup. The installer creates the `.env` file automatically if it does not already exist.
8. The installer disables itself automatically by setting `INSTALL_ENABLED=0` after setup is complete.

## Required Environment Values

```ini
DB_HOST=localhost
DB_NAME=coresuite_lite
DB_USER=your_db_user
DB_PASS=your_db_password
APP_URL=https://your-domain.com
INSTALL_ENABLED=1
```

If `.env` is missing, the installer can still be opened and will generate it during setup.

## Shared Hosting Notes

- Point the domain or subdomain to the `public/` directory when possible.
- If your hosting account does not allow that structure, make sure requests are still routed through `public/index.php`.
- Enable `.htaccess` support on Apache hosting.

## Local Run

```bash
php -S localhost:8000 -t public/
```

## After Installation

- Disable the installer by setting `INSTALL_ENABLED=0`
- Review workspace settings
- Configure email delivery
- Change demo credentials if sample data is imported
- Remove any local logs before creating a distribution package
