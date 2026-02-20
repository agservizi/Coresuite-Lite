# Setup Database

## Creazione Database

### Via phpMyAdmin
1. Accedi a phpMyAdmin
2. Crea nuovo database `coresuite_lite`
3. Seleziona database
4. Importa `schema.sql`

### Via Command Line
```bash
mysql -u root -p
CREATE DATABASE coresuite_lite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE coresuite_lite;
SOURCE schema.sql;
```

### Via Script PHP
Esegui `seed.php` dopo configurazione:
```bash
php seed.php
```

## Struttura Tabelle

### users
- id (PK)
- name, email (unique)
- password_hash
- role (admin/operator/customer)
- status (active/suspended)
- phone (optional)
- created_at, updated_at

### password_resets
- id (PK)
- user_id (FK users)
- token_hash (unique)
- expires_at
- used_at

### remember_tokens
- id (PK)
- user_id (FK users)
- token_hash (unique)
- expires_at
- created_at, last_used_at

### tickets
- id (PK)
- customer_id (FK users)
- assigned_to (FK users, nullable)
- category, subject
- status (open/in_progress/resolved/closed)
- priority (low/medium/high)
- created_at, updated_at

### ticket_comments
- id (PK)
- ticket_id (FK tickets)
- author_id (FK users)
- body (text)
- visibility (public/internal)
- created_at

### documents
- id (PK)
- customer_id (FK users)
- filename_original, filename_storage
- mime, size
- uploaded_by (FK users)
- created_at

### audit_logs
- id (PK)
- actor_id (FK users, nullable)
- action, entity, entity_id
- ip, user_agent
- created_at

## Indici Ottimizzati

- users: email, role, status
- password_resets: token_hash, expires_at
- remember_tokens: token_hash, expires_at
- tickets: customer_id, assigned_to, status, created_at
- ticket_comments: ticket_id, author_id, visibility
- documents: customer_id, uploaded_by, created_at
- audit_logs: actor_id, entity+entity_id, created_at

## Dati Demo

Esegui `seed.php` per creare:
- Admin: admin@example.com / admin123
- Operator: operator@example.com / operator123
- Customer: customer@example.com / customer123

## Backup

### Esportazione
```bash
mysqldump -u user -p coresuite_lite > backup.sql
```

### Ripristino
```bash
mysql -u user -p coresuite_lite < backup.sql
```

### Automatizzato
Configura cron job:
```bash
0 2 * * * mysqldump -u user -p coresuite_lite > /path/to/backup/$(date +\%Y\%m\%d).sql
```

## Manutenzione

### Ottimizzazione Tabelle
```sql
OPTIMIZE TABLE users, tickets, documents;
```

### Controllo Integrità
```sql
CHECK TABLE users, tickets, documents;
```

### Statistiche
```sql
SHOW TABLE STATUS;
ANALYZE TABLE users;
```