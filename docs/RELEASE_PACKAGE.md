# Release Package Guide

Use this guide before creating the final marketplace ZIP.

## Files That Should Not Be Included

- `.env`
- local logs in `storage/logs/`
- local screenshots, previews, and temporary HTML files
- local development entry points
- backup files such as `*.bak`
- local server logs
- `node_modules/`
- editor-specific local files

## Current Project Files to Exclude

- `server.log`
- `public/preview.html`
- `public/dev_dashboard.php`
- `app/Views/partials/sidebar.php.bak`
- `storage/logs/*`
- `storage/uploads/*` sample files
- `.vscode/`
- `src/`
- `tools/screenshot.js`
- `LITE.session.sql`
- `seed.php`

## Recommended Release Structure

- application source
- public assets
- documentation folder
- SQL schema and migrations
- `.env.example`

## Recommended Final Checks

1. Verify there are no private secrets inside the package
2. Verify demo-only files are intentional
3. Verify `seed.php` and any demo bootstrap scripts are excluded from the marketplace ZIP
4. Verify docs are in English
5. Verify the installer is documented
6. Verify all third-party asset credits are present
7. Verify no local logs or debug traces are included
8. Verify local icon assets are present in `public/assets/vendor/fontawesome/`
9. Verify `storage/uploads/` and `storage/logs/` are empty except placeholder files
