# Database Setup

## Create the Database

### phpMyAdmin

1. Sign in to phpMyAdmin.
2. Create a database named `coresuite_lite`.
3. Open the new database.
4. Import `schema.sql`.

### Command Line

```bash
mysql -u root -p
CREATE DATABASE coresuite_lite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE coresuite_lite;
SOURCE schema.sql;
```

## Demo Data

To load sample users and project data for local evaluation:

```bash
php seed.php
```

Sample accounts created by the demo seed:

- Admin: `admin@example.com` / `admin123`
- Operator: `operator@example.com` / `operator123`
- Customer: `customer@example.com` / `customer123`

These credentials are intended for demo and local review only. Change or remove them in any real deployment.

## Core Tables

The base schema includes the following core tables:

- `users`
- `password_resets`
- `remember_tokens`
- `tickets`
- `ticket_comments`
- `documents`
- `audit_logs`
- `projects`
- `project_milestones`
- `project_tasks`
- `crm_*` sales tables
- `document_metadata`
- `ticket_attachments`

## Indexing

The schema already includes indexes for common operational queries such as:

- user lookup by email, role, and status
- ticket lookup by customer, assignee, status, and creation date
- document lookup by customer and uploader
- audit log lookup by actor, entity, and date

## Backup Commands

### Export

```bash
mysqldump -u user -p coresuite_lite > backup.sql
```

### Import

```bash
mysql -u user -p coresuite_lite < backup.sql
```

## Maintenance Suggestions

### Optimize Tables

```sql
OPTIMIZE TABLE users, tickets, documents;
```

### Check Integrity

```sql
CHECK TABLE users, tickets, documents;
```

### Analyze Statistics

```sql
ANALYZE TABLE users;
SHOW TABLE STATUS;
```
