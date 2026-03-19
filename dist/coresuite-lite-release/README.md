# CoreSuite Lite

CoreSuite Lite is a self-hosted PHP support and operations suite designed for teams that need a clean admin dashboard, customer portal, ticket handling, document delivery, and a lightweight sales workspace in a single product.

## Highlights

- Pure PHP 8.2+ application
- MySQL 8+ database
- Bootstrap 5 UI with custom responsive admin theme
- Role-based access for admin, operator, and customer users
- Ticketing, documents, customer area, reports, audit logs, and sales workspace
- Quote and invoice PDF generation
- Built-in installer and multi-language interface

## Quick Start

1. Upload the project files to your hosting account.
2. Create a MySQL database and import `schema.sql`.
3. Copy `.env.example` to `.env` and fill in your database settings.
4. Make `storage/uploads/` and `storage/logs/` writable.
5. Temporarily set `INSTALL_ENABLED=1` in `.env`.
6. Open `/install` in the browser and complete the setup.
7. Set `INSTALL_ENABLED=0` after installation.

## Documentation

- [Installation Guide](docs/INSTALL.md)
- [System Requirements](docs/REQUIREMENTS.md)
- [Configuration Guide](docs/CONFIG.md)
- [Database Setup](docs/SETUP.md)
- [Troubleshooting](docs/TROUBLESHOOTING.md)
- [UI Guide](docs/UI_GUIDE.md)
- [Credits and Licenses](docs/CREDITS.md)
- [Release Package Guide](docs/RELEASE_PACKAGE.md)

## Local Development

```bash
php -S localhost:8000 -t public/
```

Then open `http://localhost:8000`.

## Demo Seed

If you want demo data for local testing, run:

```bash
php seed.php
```

Demo credentials and sample data notes are documented in [docs/SETUP.md](docs/SETUP.md).

## Security Notes

- CSRF protection is enabled on form submissions.
- Authentication uses hashed passwords.
- Database access uses prepared statements in core application flows.
- The web installer should remain disabled outside first-time setup.

## Release Notes

Before creating the marketplace ZIP, review [docs/RELEASE_PACKAGE.md](docs/RELEASE_PACKAGE.md) and exclude local-only files such as logs, previews, development artifacts, and private environment files.
