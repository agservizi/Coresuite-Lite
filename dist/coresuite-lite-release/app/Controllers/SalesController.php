<?php
use Core\Auth;
use Core\DB;
use Core\Locale;
use Core\RolePermissions;
use Core\SimplePdf;
use Core\WorkspaceSettings;

class SalesController {
    private function ensureSchema(): void {
        static $booted = false;
        if ($booted) {
            return;
        }

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_companies (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(180) NOT NULL,
                status VARCHAR(32) NOT NULL DEFAULT 'prospect',
                industry VARCHAR(120) NULL DEFAULT NULL,
                website VARCHAR(190) NULL DEFAULT NULL,
                email VARCHAR(190) NULL DEFAULT NULL,
                phone VARCHAR(60) NULL DEFAULT NULL,
                address TEXT NULL,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_crm_companies_status (status),
                KEY idx_crm_companies_name (name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_contacts (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                customer_user_id INT UNSIGNED NULL DEFAULT NULL,
                name VARCHAR(180) NOT NULL,
                role_title VARCHAR(120) NULL DEFAULT NULL,
                email VARCHAR(190) NULL DEFAULT NULL,
                phone VARCHAR(60) NULL DEFAULT NULL,
                is_primary TINYINT(1) NOT NULL DEFAULT 0,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_crm_contacts_company (company_id),
                KEY idx_crm_contacts_user (customer_user_id),
                KEY idx_crm_contacts_email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_leads (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                contact_id INT UNSIGNED NULL DEFAULT NULL,
                owner_id INT UNSIGNED NULL DEFAULT NULL,
                title VARCHAR(180) NOT NULL,
                source VARCHAR(80) NULL DEFAULT NULL,
                status VARCHAR(32) NOT NULL DEFAULT 'new',
                score TINYINT UNSIGNED NOT NULL DEFAULT 0,
                estimated_value DECIMAL(12,2) NULL DEFAULT NULL,
                currency CHAR(3) NOT NULL DEFAULT 'EUR',
                next_step VARCHAR(180) NULL DEFAULT NULL,
                next_contact_at DATETIME NULL DEFAULT NULL,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_crm_leads_company (company_id),
                KEY idx_crm_leads_contact (contact_id),
                KEY idx_crm_leads_owner (owner_id),
                KEY idx_crm_leads_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_deals (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                contact_id INT UNSIGNED NULL DEFAULT NULL,
                lead_id INT UNSIGNED NULL DEFAULT NULL,
                owner_id INT UNSIGNED NULL DEFAULT NULL,
                title VARCHAR(180) NOT NULL,
                stage VARCHAR(32) NOT NULL DEFAULT 'lead_in',
                status VARCHAR(24) NOT NULL DEFAULT 'open',
                amount DECIMAL(12,2) NULL DEFAULT NULL,
                currency CHAR(3) NOT NULL DEFAULT 'EUR',
                probability TINYINT UNSIGNED NOT NULL DEFAULT 0,
                expected_close_date DATE NULL DEFAULT NULL,
                next_action VARCHAR(180) NULL DEFAULT NULL,
                next_action_at DATETIME NULL DEFAULT NULL,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_crm_deals_company (company_id),
                KEY idx_crm_deals_contact (contact_id),
                KEY idx_crm_deals_lead (lead_id),
                KEY idx_crm_deals_owner (owner_id),
                KEY idx_crm_deals_stage (stage),
                KEY idx_crm_deals_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_activities (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                contact_id INT UNSIGNED NULL DEFAULT NULL,
                lead_id INT UNSIGNED NULL DEFAULT NULL,
                deal_id INT UNSIGNED NULL DEFAULT NULL,
                user_id INT UNSIGNED NULL DEFAULT NULL,
                type VARCHAR(32) NOT NULL DEFAULT 'note',
                subject VARCHAR(180) NOT NULL,
                notes TEXT NULL,
                scheduled_at DATETIME NULL DEFAULT NULL,
                completed_at DATETIME NULL DEFAULT NULL,
                outcome VARCHAR(180) NULL DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                KEY idx_crm_activities_company (company_id),
                KEY idx_crm_activities_contact (contact_id),
                KEY idx_crm_activities_lead (lead_id),
                KEY idx_crm_activities_deal (deal_id),
                KEY idx_crm_activities_user (user_id),
                KEY idx_crm_activities_type (type),
                KEY idx_crm_activities_scheduled (scheduled_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_reminders (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                contact_id INT UNSIGNED NULL DEFAULT NULL,
                lead_id INT UNSIGNED NULL DEFAULT NULL,
                deal_id INT UNSIGNED NULL DEFAULT NULL,
                activity_id INT UNSIGNED NULL DEFAULT NULL,
                user_id INT UNSIGNED NULL DEFAULT NULL,
                title VARCHAR(180) NOT NULL,
                remind_at DATETIME NOT NULL,
                status VARCHAR(24) NOT NULL DEFAULT 'pending',
                channel VARCHAR(24) NOT NULL DEFAULT 'in_app',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_crm_reminders_when (remind_at),
                KEY idx_crm_reminders_status (status),
                KEY idx_crm_reminders_deal (deal_id),
                KEY idx_crm_reminders_lead (lead_id),
                KEY idx_crm_reminders_activity (activity_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_quotes (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                contact_id INT UNSIGNED NULL DEFAULT NULL,
                deal_id INT UNSIGNED NULL DEFAULT NULL,
                quote_number VARCHAR(40) NOT NULL,
                status VARCHAR(24) NOT NULL DEFAULT 'draft',
                issue_date DATE NOT NULL,
                expiry_date DATE NULL DEFAULT NULL,
                currency CHAR(3) NOT NULL DEFAULT 'EUR',
                subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
                tax_total DECIMAL(12,2) NOT NULL DEFAULT 0,
                total DECIMAL(12,2) NOT NULL DEFAULT 0,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY uniq_crm_quotes_number (quote_number),
                KEY idx_crm_quotes_company (company_id),
                KEY idx_crm_quotes_contact (contact_id),
                KEY idx_crm_quotes_deal (deal_id),
                KEY idx_crm_quotes_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_quote_lines (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                quote_id INT UNSIGNED NOT NULL,
                description VARCHAR(255) NOT NULL,
                quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
                unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
                tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0,
                line_total DECIMAL(12,2) NOT NULL DEFAULT 0,
                sort_order INT UNSIGNED NOT NULL DEFAULT 0,
                KEY idx_crm_quote_lines_quote (quote_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_invoices (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                company_id INT UNSIGNED NULL DEFAULT NULL,
                contact_id INT UNSIGNED NULL DEFAULT NULL,
                deal_id INT UNSIGNED NULL DEFAULT NULL,
                invoice_number VARCHAR(40) NOT NULL,
                status VARCHAR(24) NOT NULL DEFAULT 'draft',
                issue_date DATE NOT NULL,
                due_date DATE NULL DEFAULT NULL,
                currency CHAR(3) NOT NULL DEFAULT 'EUR',
                subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
                tax_total DECIMAL(12,2) NOT NULL DEFAULT 0,
                total DECIMAL(12,2) NOT NULL DEFAULT 0,
                paid_total DECIMAL(12,2) NOT NULL DEFAULT 0,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY uniq_crm_invoices_number (invoice_number),
                KEY idx_crm_invoices_company (company_id),
                KEY idx_crm_invoices_contact (contact_id),
                KEY idx_crm_invoices_deal (deal_id),
                KEY idx_crm_invoices_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query(" 
            CREATE TABLE IF NOT EXISTS crm_invoice_lines (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                invoice_id INT UNSIGNED NOT NULL,
                description VARCHAR(255) NOT NULL,
                quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
                unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
                tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0,
                line_total DECIMAL(12,2) NOT NULL DEFAULT 0,
                sort_order INT UNSIGNED NOT NULL DEFAULT 0,
                KEY idx_crm_invoice_lines_invoice (invoice_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        $booted = true;
    }

    private function ensureDemoData(): void {
        static $seeded = false;
        if ($seeded) {
            return;
        }

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_companies")->fetch();
        if ((int)($row['total'] ?? 0) > 0) {
            $seeded = true;
            return;
        }

        $users = DB::query("SELECT id, name, email, role FROM users ORDER BY id ASC")->fetchAll();
        $adminId = null;
        $operatorId = null;
        $customerId = null;
        foreach ($users as $user) {
            $role = (string)($user['role'] ?? '');
            if ($role === 'admin' && $adminId === null) {
                $adminId = (int)$user['id'];
            }
            if ($role === 'operator' && $operatorId === null) {
                $operatorId = (int)$user['id'];
            }
            if ($role === 'customer' && $customerId === null) {
                $customerId = (int)$user['id'];
            }
        }
        $ownerId = $operatorId ?: $adminId;

        $companyStmt = DB::prepare("INSERT INTO crm_companies (name, status, industry, website, email, phone, address, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $companySeed = [
            ['Northwind Retail Group', 'prospect', 'Retail', 'https://northwind.example.com', 'procurement@northwind.example.com', '+39 081 555 0101', 'Via Toledo 12, Napoli', 'Gruppo retail con esigenza di centralizzare pipeline, offerte e documenti commerciali.'],
            ['Blue Atlas Logistics', 'active', 'Logistics', 'https://blueatlas.example.com', 'ops@blueatlas.example.com', '+39 02 555 0144', 'Via Tortona 88, Milano', 'Cliente con trattativa enterprise in corso e need di reminder per follow-up negoziali.'],
            ['Solaris Hospitality', 'prospect', 'Hospitality', 'https://solaris.example.com', 'finance@solaris.example.com', '+39 06 555 0198', 'Piazza Barberini 4, Roma', 'Opportunity in fase iniziale con focus su portale clienti e archivio documenti.'],
        ];

        $companyIds = [];
        foreach ($companySeed as $seed) {
            $companyStmt->execute($seed);
            $companyIds[$seed[0]] = (int)DB::lastInsertId();
        }

        $contactStmt = DB::prepare("INSERT INTO crm_contacts (company_id, customer_user_id, name, role_title, email, phone, is_primary, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $contactSeed = [
            [$companyIds['Northwind Retail Group'], $customerId, 'Claudia Ferri', 'Procurement Lead', 'claudia.ferri@northwind.example.com', '+39 347 000 1122', 1, 'Sponsor del progetto lato procurement.'],
            [$companyIds['Blue Atlas Logistics'], null, 'Luca Berni', 'Operations Director', 'luca.berni@blueatlas.example.com', '+39 348 000 2233', 1, 'Decision maker per la parte operations e SLA.'],
            [$companyIds['Solaris Hospitality'], null, 'Marta Rosi', 'Finance Manager', 'marta.rosi@solaris.example.com', '+39 349 000 3344', 1, 'Coinvolta su preventivo e governance documentale.'],
        ];

        $contactIds = [];
        foreach ($contactSeed as $seed) {
            $contactStmt->execute($seed);
            $contactIds[$seed[2]] = (int)DB::lastInsertId();
        }

        $leadStmt = DB::prepare("INSERT INTO crm_leads (company_id, contact_id, owner_id, title, source, status, score, estimated_value, currency, next_step, next_contact_at, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $leadSeed = [
            [$companyIds['Northwind Retail Group'], $contactIds['Claudia Ferri'], $ownerId, 'Digitalizzazione flusso offerte retail', 'Referral', 'qualified', 78, 18500, 'EUR', 'Workshop di scoperta con procurement', '2026-03-21 10:30:00', 'Lead gia qualificato con obiettivo di chiudere entro il mese.'],
            [$companyIds['Solaris Hospitality'], $contactIds['Marta Rosi'], $adminId, 'Portale hospitality con quote native', 'Website', 'contacted', 54, 12600, 'EUR', 'Invio deck commerciale e prima demo', '2026-03-24 15:00:00', 'Necessario mostrare preventivi, reminder e calendario commerciale.'],
        ];

        $leadIds = [];
        foreach ($leadSeed as $seed) {
            $leadStmt->execute($seed);
            $leadIds[$seed[3]] = (int)DB::lastInsertId();
        }

        $dealStmt = DB::prepare("INSERT INTO crm_deals (company_id, contact_id, lead_id, owner_id, title, stage, status, amount, currency, probability, expected_close_date, next_action, next_action_at, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $dealSeed = [
            [$companyIds['Blue Atlas Logistics'], $contactIds['Luca Berni'], null, $ownerId, 'Suite operations Blue Atlas', 'negotiation', 'open', 42000, 'EUR', 72, '2026-03-31', 'Chiusura economica e definizione rollout', '2026-03-20 11:00:00', 'Trattativa attiva con scambio finale su pricing annuale.'],
            [$companyIds['Northwind Retail Group'], $contactIds['Claudia Ferri'], $leadIds['Digitalizzazione flusso offerte retail'], $ownerId, 'Northwind commercial workspace', 'proposal', 'open', 18500, 'EUR', 61, '2026-03-28', 'Invio preventivo definitivo', '2026-03-22 09:30:00', 'Deal collegato a quote native e fase proposal.'],
            [$companyIds['Solaris Hospitality'], $contactIds['Marta Rosi'], $leadIds['Portale hospitality con quote native'], $adminId, 'Solaris onboarding package', 'qualified', 'open', 12600, 'EUR', 38, '2026-04-08', 'Demo guidata con finance e operations', '2026-03-25 16:00:00', 'Opportunity early-stage ma gia con agenda commerciale definita.'],
        ];

        $dealIds = [];
        foreach ($dealSeed as $seed) {
            $dealStmt->execute($seed);
            $dealIds[$seed[4]] = (int)DB::lastInsertId();
        }

        $activityStmt = DB::prepare("INSERT INTO crm_activities (company_id, contact_id, lead_id, deal_id, user_id, type, subject, notes, scheduled_at, completed_at, outcome) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $activitySeed = [
            [$companyIds['Blue Atlas Logistics'], $contactIds['Luca Berni'], null, $dealIds['Suite operations Blue Atlas'], $ownerId, 'call', 'Allineamento pricing Q2', 'Call commerciale su pricing e clausole onboarding.', '2026-03-18 15:00:00', '2026-03-18 15:40:00', 'Cliente interessato ma richiede revisione canone setup.'],
            [$companyIds['Northwind Retail Group'], $contactIds['Claudia Ferri'], $leadIds['Digitalizzazione flusso offerte retail'], $dealIds['Northwind commercial workspace'], $ownerId, 'meeting', 'Workshop procurement', 'Workshop per mappare touchpoint quote e approvazioni.', '2026-03-21 10:30:00', null, null],
            [$companyIds['Solaris Hospitality'], $contactIds['Marta Rosi'], $leadIds['Portale hospitality con quote native'], $dealIds['Solaris onboarding package'], $adminId, 'note', 'Nota discovery hospitality', 'Richiesta esplicita di reminder automatici su follow-up e scadenza preventivi.', null, null, null],
        ];

        foreach ($activitySeed as $seed) {
            $activityStmt->execute($seed);
        }

        $reminderStmt = DB::prepare("INSERT INTO crm_reminders (company_id, contact_id, lead_id, deal_id, activity_id, user_id, title, remind_at, status, channel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $reminderSeed = [
            [$companyIds['Blue Atlas Logistics'], $contactIds['Luca Berni'], null, $dealIds['Suite operations Blue Atlas'], null, $ownerId, 'Follow-up negoziazione Blue Atlas', '2026-03-20 11:00:00', 'pending', 'in_app'],
            [$companyIds['Northwind Retail Group'], $contactIds['Claudia Ferri'], $leadIds['Digitalizzazione flusso offerte retail'], $dealIds['Northwind commercial workspace'], null, $ownerId, 'Inviare preventivo Northwind', '2026-03-22 09:30:00', 'pending', 'in_app'],
            [$companyIds['Solaris Hospitality'], $contactIds['Marta Rosi'], $leadIds['Portale hospitality con quote native'], $dealIds['Solaris onboarding package'], null, $adminId, 'Demo commerciale Solaris', '2026-03-25 16:00:00', 'pending', 'in_app'],
        ];

        foreach ($reminderSeed as $seed) {
            $reminderStmt->execute($seed);
        }

        $quoteStmt = DB::prepare("INSERT INTO crm_quotes (company_id, contact_id, deal_id, quote_number, status, issue_date, expiry_date, currency, subtotal, tax_total, total, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $quoteLineStmt = DB::prepare("INSERT INTO crm_quote_lines (quote_id, description, quantity, unit_price, tax_rate, line_total, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $quoteStmt->execute([$companyIds['Northwind Retail Group'], $contactIds['Claudia Ferri'], $dealIds['Northwind commercial workspace'], 'Q-2026-001', 'sent', '2026-03-18', '2026-03-31', 'EUR', 16500, 3630, 20130, 'Preventivo enterprise con setup iniziale e training.']);
        $quoteId = (int)DB::lastInsertId();
        $quoteLines = [
            ['Setup commerciale e pipeline', 1, 7500, 22, 9150, 1],
            ['Calendar e reminder automation', 1, 4000, 22, 4880, 2],
            ['Training team e rollout', 2, 2500, 22, 6100, 3],
        ];
        foreach ($quoteLines as $line) {
            $quoteLineStmt->execute([$quoteId, $line[0], $line[1], $line[2], $line[3], $line[4], $line[5]]);
        }

        $invoiceStmt = DB::prepare("INSERT INTO crm_invoices (company_id, contact_id, deal_id, invoice_number, status, issue_date, due_date, currency, subtotal, tax_total, total, paid_total, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $invoiceLineStmt = DB::prepare("INSERT INTO crm_invoice_lines (invoice_id, description, quantity, unit_price, tax_rate, line_total, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $invoiceStmt->execute([$companyIds['Blue Atlas Logistics'], $contactIds['Luca Berni'], $dealIds['Suite operations Blue Atlas'], 'INV-2026-001', 'issued', '2026-03-18', '2026-04-02', 'EUR', 12000, 2640, 14640, 0, 'Fattura onboarding fase 1.']);
        $invoiceId = (int)DB::lastInsertId();
        $invoiceLines = [
            ['Kickoff e configurazione iniziale', 1, 6000, 22, 7320, 1],
            ['Migrazione contenuti commerciali', 1, 6000, 22, 7320, 2],
        ];
        foreach ($invoiceLines as $line) {
            $invoiceLineStmt->execute([$invoiceId, $line[0], $line[1], $line[2], $line[3], $line[4], $line[5]]);
        }

        $seeded = true;
    }

    private function authorizeView(): void {
        if (!RolePermissions::canCurrent('sales_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    private function authorizeManage(): void {
        if (!RolePermissions::canCurrent('sales_manage')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    private function requireCsrf(): void {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /sales');
            exit;
        }
    }

    private function messages(): array {
        return [
            'it' => [
                'company_created' => 'Azienda salvata con successo.',
                'contact_created' => 'Contatto salvato con successo.',
                'lead_created' => 'Lead salvato con successo.',
                'deal_created' => 'Deal salvato con successo.',
                'activity_created' => 'Attivita commerciale salvata.',
                'reminder_created' => 'Reminder commerciale salvato.',
                'quote_created' => 'Preventivo creato con successo.',
                'invoice_created' => 'Fattura creata con successo.',
                'quote_updated' => 'Preventivo aggiornato con successo.',
                'invoice_updated' => 'Fattura aggiornata con successo.',
                'deal_stage_updated' => 'Stage del deal aggiornato.',
                'reminder_completed' => 'Reminder completato.',
                'name_required' => 'Inserisci un nome valido.',
                'title_required' => 'Inserisci un titolo valido.',
                'lines_required' => 'Inserisci almeno una riga documento valida.',
                'date_required' => 'Inserisci una data valida.',
            ],
            'en' => [
                'company_created' => 'Company saved successfully.',
                'contact_created' => 'Contact saved successfully.',
                'lead_created' => 'Lead saved successfully.',
                'deal_created' => 'Deal saved successfully.',
                'activity_created' => 'Sales activity saved.',
                'reminder_created' => 'Sales reminder saved.',
                'quote_created' => 'Quote created successfully.',
                'invoice_created' => 'Invoice created successfully.',
                'quote_updated' => 'Quote updated successfully.',
                'invoice_updated' => 'Invoice updated successfully.',
                'deal_stage_updated' => 'Deal stage updated.',
                'reminder_completed' => 'Reminder completed.',
                'name_required' => 'Enter a valid name.',
                'title_required' => 'Enter a valid title.',
                'lines_required' => 'Add at least one valid document line.',
                'date_required' => 'Enter a valid date.',
            ],
            'fr' => [
                'company_created' => 'Societe enregistree avec succes.',
                'contact_created' => 'Contact enregistre avec succes.',
                'lead_created' => 'Lead enregistre avec succes.',
                'deal_created' => 'Deal enregistre avec succes.',
                'activity_created' => 'Activite commerciale enregistree.',
                'reminder_created' => 'Rappel commercial enregistre.',
                'quote_created' => 'Devis cree avec succes.',
                'invoice_created' => 'Facture creee avec succes.',
                'quote_updated' => 'Devis mis a jour avec succes.',
                'invoice_updated' => 'Facture mise a jour avec succes.',
                'deal_stage_updated' => 'Etape du deal mise a jour.',
                'reminder_completed' => 'Rappel complete.',
                'name_required' => 'Saisissez un nom valide.',
                'title_required' => 'Saisissez un titre valide.',
                'lines_required' => 'Ajoutez au moins une ligne de document valide.',
                'date_required' => 'Saisissez une date valide.',
            ],
            'es' => [
                'company_created' => 'Empresa guardada con exito.',
                'contact_created' => 'Contacto guardado con exito.',
                'lead_created' => 'Lead guardado con exito.',
                'deal_created' => 'Deal guardado con exito.',
                'activity_created' => 'Actividad comercial guardada.',
                'reminder_created' => 'Recordatorio comercial guardado.',
                'quote_created' => 'Presupuesto creado con exito.',
                'invoice_created' => 'Factura creada con exito.',
                'quote_updated' => 'Presupuesto actualizado con exito.',
                'invoice_updated' => 'Factura actualizada con exito.',
                'deal_stage_updated' => 'Etapa del deal actualizada.',
                'reminder_completed' => 'Recordatorio completado.',
                'name_required' => 'Introduce un nombre valido.',
                'title_required' => 'Introduce un titulo valido.',
                'lines_required' => 'Agrega al menos una linea de documento valida.',
                'date_required' => 'Introduce una fecha valida.',
            ],
        ];
    }

    private function message(string $key): string {
        $locale = Locale::current();
        $messages = $this->messages();
        return $messages[$locale][$key] ?? $messages['it'][$key] ?? $key;
    }

    private function companyStatuses(): array {
        return ['prospect', 'active', 'partner', 'inactive'];
    }

    private function leadStatuses(): array {
        return ['new', 'contacted', 'qualified', 'nurturing', 'disqualified'];
    }

    private function dealStages(): array {
        return ['lead_in', 'qualified', 'proposal', 'negotiation', 'verbal_commit', 'won', 'lost'];
    }

    private function quoteStatuses(): array {
        return ['draft', 'sent', 'accepted', 'expired', 'rejected'];
    }

    private function invoiceStatuses(): array {
        return ['draft', 'issued', 'partial', 'paid', 'overdue'];
    }

    private function activityTypes(): array {
        return ['note', 'call', 'meeting', 'email', 'task'];
    }

    private function labels(): array {
        return [
            'it' => [
                'company_status' => ['prospect' => 'Prospect', 'active' => 'Attiva', 'partner' => 'Partner', 'inactive' => 'Inattiva'],
                'lead_status' => ['new' => 'Nuovo', 'contacted' => 'Contattato', 'qualified' => 'Qualificato', 'nurturing' => 'Nurturing', 'disqualified' => 'Perso'],
                'deal_stage' => ['lead_in' => 'Lead in', 'qualified' => 'Qualificato', 'proposal' => 'Proposta', 'negotiation' => 'Negoziazione', 'verbal_commit' => 'Commit verbale', 'won' => 'Chiuso vinto', 'lost' => 'Chiuso perso'],
                'quote_status' => ['draft' => 'Bozza', 'sent' => 'Inviato', 'accepted' => 'Accettato', 'expired' => 'Scaduto', 'rejected' => 'Rifiutato'],
                'invoice_status' => ['draft' => 'Bozza', 'issued' => 'Emessa', 'partial' => 'Parziale', 'paid' => 'Pagata', 'overdue' => 'Scaduta'],
                'activity_type' => ['note' => 'Nota', 'call' => 'Call', 'meeting' => 'Meeting', 'email' => 'Email', 'task' => 'Task'],
            ],
            'en' => [
                'company_status' => ['prospect' => 'Prospect', 'active' => 'Active', 'partner' => 'Partner', 'inactive' => 'Inactive'],
                'lead_status' => ['new' => 'New', 'contacted' => 'Contacted', 'qualified' => 'Qualified', 'nurturing' => 'Nurturing', 'disqualified' => 'Disqualified'],
                'deal_stage' => ['lead_in' => 'Lead in', 'qualified' => 'Qualified', 'proposal' => 'Proposal', 'negotiation' => 'Negotiation', 'verbal_commit' => 'Verbal commit', 'won' => 'Won', 'lost' => 'Lost'],
                'quote_status' => ['draft' => 'Draft', 'sent' => 'Sent', 'accepted' => 'Accepted', 'expired' => 'Expired', 'rejected' => 'Rejected'],
                'invoice_status' => ['draft' => 'Draft', 'issued' => 'Issued', 'partial' => 'Partial', 'paid' => 'Paid', 'overdue' => 'Overdue'],
                'activity_type' => ['note' => 'Note', 'call' => 'Call', 'meeting' => 'Meeting', 'email' => 'Email', 'task' => 'Task'],
            ],
            'fr' => [
                'company_status' => ['prospect' => 'Prospect', 'active' => 'Active', 'partner' => 'Partenaire', 'inactive' => 'Inactive'],
                'lead_status' => ['new' => 'Nouveau', 'contacted' => 'Contacte', 'qualified' => 'Qualifie', 'nurturing' => 'Nurturing', 'disqualified' => 'Perdu'],
                'deal_stage' => ['lead_in' => 'Lead in', 'qualified' => 'Qualifie', 'proposal' => 'Proposition', 'negotiation' => 'Negociation', 'verbal_commit' => 'Accord verbal', 'won' => 'Gagne', 'lost' => 'Perdu'],
                'quote_status' => ['draft' => 'Brouillon', 'sent' => 'Envoye', 'accepted' => 'Accepte', 'expired' => 'Expire', 'rejected' => 'Refuse'],
                'invoice_status' => ['draft' => 'Brouillon', 'issued' => 'Emise', 'partial' => 'Partielle', 'paid' => 'Payee', 'overdue' => 'En retard'],
                'activity_type' => ['note' => 'Note', 'call' => 'Appel', 'meeting' => 'Meeting', 'email' => 'Email', 'task' => 'Tache'],
            ],
            'es' => [
                'company_status' => ['prospect' => 'Prospecto', 'active' => 'Activa', 'partner' => 'Partner', 'inactive' => 'Inactiva'],
                'lead_status' => ['new' => 'Nuevo', 'contacted' => 'Contactado', 'qualified' => 'Cualificado', 'nurturing' => 'Nurturing', 'disqualified' => 'Descartado'],
                'deal_stage' => ['lead_in' => 'Lead in', 'qualified' => 'Cualificado', 'proposal' => 'Propuesta', 'negotiation' => 'Negociacion', 'verbal_commit' => 'Compromiso verbal', 'won' => 'Ganado', 'lost' => 'Perdido'],
                'quote_status' => ['draft' => 'Borrador', 'sent' => 'Enviado', 'accepted' => 'Aceptado', 'expired' => 'Vencido', 'rejected' => 'Rechazado'],
                'invoice_status' => ['draft' => 'Borrador', 'issued' => 'Emitida', 'partial' => 'Parcial', 'paid' => 'Pagada', 'overdue' => 'Vencida'],
                'activity_type' => ['note' => 'Nota', 'call' => 'Llamada', 'meeting' => 'Meeting', 'email' => 'Email', 'task' => 'Tarea'],
            ],
        ];
    }

    public function label(string $group, string $key): string {
        $locale = Locale::current();
        $labels = $this->labels();
        return $labels[$locale][$group][$key] ?? $labels['it'][$group][$key] ?? $key;
    }

    public function translateLabel(string $group, string $key): string {
        return $this->label($group, $key);
    }

    private function parseAmount($value): float {
        $normalized = str_replace(',', '.', trim((string)$value));
        return round((float)$normalized, 2);
    }

    private function nullableDate(?string $value): ?string {
        $value = trim((string)$value);
        return $value !== '' ? $value : null;
    }

    private function nullableDateTime(?string $value): ?string {
        $value = trim((string)$value);
        return $value !== '' ? $value : null;
    }

    private function nextDocumentNumber(string $table, string $prefix): string {
        $row = DB::query("SELECT COUNT(*) AS total FROM {$table}")->fetch();
        $count = (int)($row['total'] ?? 0) + 1;
        return $prefix . '-' . date('Y') . '-' . str_pad((string)$count, 3, '0', STR_PAD_LEFT);
    }

    private function parseDocumentLines($raw): array {
        $lines = [];
        $sortOrder = 1;

        if (is_array($raw)) {
            $descriptions = array_values((array)($raw['description'] ?? []));
            $quantities = array_values((array)($raw['quantity'] ?? []));
            $unitPrices = array_values((array)($raw['unit_price'] ?? []));
            $taxRates = array_values((array)($raw['tax_rate'] ?? []));
            $rowsCount = max(count($descriptions), count($quantities), count($unitPrices), count($taxRates));
            for ($i = 0; $i < $rowsCount; $i++) {
                $description = trim((string)($descriptions[$i] ?? ''));
                $quantityRaw = (string)($quantities[$i] ?? '1');
                $unitPriceRaw = (string)($unitPrices[$i] ?? '0');
                $taxRateRaw = (string)($taxRates[$i] ?? '0');
                if ($description === '' && trim($quantityRaw) === '' && trim($unitPriceRaw) === '' && trim($taxRateRaw) === '') {
                    continue;
                }
                if ($description === '') {
                    continue;
                }
                $quantity = max(0.01, $this->parseAmount($quantityRaw));
                $unitPrice = max(0, $this->parseAmount($unitPriceRaw));
                $taxRate = max(0, $this->parseAmount($taxRateRaw));
                $net = round($quantity * $unitPrice, 2);
                $lineTotal = round($net + ($net * ($taxRate / 100)), 2);
                $lines[] = [
                    'description' => $description,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'tax_rate' => $taxRate,
                    'net_total' => $net,
                    'line_total' => $lineTotal,
                    'sort_order' => $sortOrder++,
                ];
            }

            return $lines;
        }

        $rows = preg_split('/\r\n|\r|\n/', trim((string)$raw));
        foreach ($rows as $row) {
            $row = trim($row);
            if ($row === '') {
                continue;
            }
            $parts = array_map('trim', explode('|', $row));
            if (count($parts) < 3 || $parts[0] === '') {
                continue;
            }
            $quantity = isset($parts[1]) ? max(0.01, $this->parseAmount($parts[1])) : 1;
            $unitPrice = isset($parts[2]) ? max(0, $this->parseAmount($parts[2])) : 0;
            $taxRate = isset($parts[3]) ? max(0, $this->parseAmount($parts[3])) : 0;
            $net = round($quantity * $unitPrice, 2);
            $lineTotal = round($net + ($net * ($taxRate / 100)), 2);
            $lines[] = [
                'description' => $parts[0],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'tax_rate' => $taxRate,
                'net_total' => $net,
                'line_total' => $lineTotal,
                'sort_order' => $sortOrder++,
            ];
        }
        return $lines;
    }

    private function calculateTotals(array $lines): array {
        $subtotal = 0.0;
        $taxTotal = 0.0;
        foreach ($lines as $line) {
            $subtotal += (float)$line['net_total'];
            $taxTotal += (float)$line['line_total'] - (float)$line['net_total'];
        }
        return [
            'subtotal' => round($subtotal, 2),
            'tax_total' => round($taxTotal, 2),
            'total' => round($subtotal + $taxTotal, 2),
        ];
    }

    private function autoReminderForLead(int $leadId, ?int $companyId, ?int $contactId, ?int $ownerId, string $title, ?string $when): void {
        if ($when === null) {
            return;
        }
        $stmt = DB::prepare("INSERT INTO crm_reminders (company_id, contact_id, lead_id, deal_id, activity_id, user_id, title, remind_at, status, channel) VALUES (?, ?, ?, NULL, NULL, ?, ?, ?, 'pending', 'auto')");
        $stmt->execute([$companyId, $contactId, $leadId, $ownerId, $title, $when]);
    }

    private function autoReminderForDeal(int $dealId, ?int $companyId, ?int $contactId, ?int $ownerId, string $title, ?string $when): void {
        if ($when === null) {
            return;
        }
        $stmt = DB::prepare("INSERT INTO crm_reminders (company_id, contact_id, lead_id, deal_id, activity_id, user_id, title, remind_at, status, channel) VALUES (?, ?, NULL, ?, NULL, ?, ?, ?, 'pending', 'auto')");
        $stmt->execute([$companyId, $contactId, $dealId, $ownerId, $title, $when]);
    }

    private function loadOwners(): array {
        $stmt = DB::prepare("SELECT id, name, role FROM users WHERE role IN ('admin', 'operator') AND status = 'active' ORDER BY FIELD(role, 'admin', 'operator'), name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadCompanies(): array {
        $stmt = DB::prepare("SELECT id, name, status, industry, website, email, phone, address, notes, created_at FROM crm_companies ORDER BY created_at DESC LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadAllCompanyOptions(): array {
        $stmt = DB::prepare("SELECT id, name FROM crm_companies ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadAllContactOptions(): array {
        $stmt = DB::prepare("SELECT c.id, c.name, c.company_id, co.name AS company_name FROM crm_contacts c LEFT JOIN crm_companies co ON co.id = c.company_id ORDER BY c.name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadAllLeadOptions(): array {
        $stmt = DB::prepare("SELECT id, title FROM crm_leads ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadAllDealOptions(): array {
        $stmt = DB::prepare("SELECT id, title FROM crm_deals ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadContacts(): array {
        $stmt = DB::prepare("SELECT c.*, co.name AS company_name FROM crm_contacts c LEFT JOIN crm_companies co ON co.id = c.company_id ORDER BY c.created_at DESC LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadLeads(): array {
        $stmt = DB::prepare("SELECT l.*, co.name AS company_name, ct.name AS contact_name, u.name AS owner_name FROM crm_leads l LEFT JOIN crm_companies co ON co.id = l.company_id LEFT JOIN crm_contacts ct ON ct.id = l.contact_id LEFT JOIN users u ON u.id = l.owner_id ORDER BY l.created_at DESC LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadDeals(): array {
        $stageOrder = "FIELD(d.stage, 'lead_in', 'qualified', 'proposal', 'negotiation', 'verbal_commit', 'won', 'lost')";
        $stmt = DB::prepare("SELECT d.*, co.name AS company_name, ct.name AS contact_name, u.name AS owner_name FROM crm_deals d LEFT JOIN crm_companies co ON co.id = d.company_id LEFT JOIN crm_contacts ct ON ct.id = d.contact_id LEFT JOIN users u ON u.id = d.owner_id ORDER BY {$stageOrder}, d.expected_close_date IS NULL, d.expected_close_date ASC, d.created_at DESC LIMIT 12");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadActivities(): array {
        $stmt = DB::prepare("SELECT a.*, co.name AS company_name, d.title AS deal_title, l.title AS lead_title, u.name AS owner_name FROM crm_activities a LEFT JOIN crm_companies co ON co.id = a.company_id LEFT JOIN crm_deals d ON d.id = a.deal_id LEFT JOIN crm_leads l ON l.id = a.lead_id LEFT JOIN users u ON u.id = a.user_id ORDER BY COALESCE(a.scheduled_at, a.created_at) DESC LIMIT 10");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadReminders(): array {
        $stmt = DB::prepare("SELECT r.*, co.name AS company_name, d.title AS deal_title, l.title AS lead_title, u.name AS owner_name FROM crm_reminders r LEFT JOIN crm_companies co ON co.id = r.company_id LEFT JOIN crm_deals d ON d.id = r.deal_id LEFT JOIN crm_leads l ON l.id = r.lead_id LEFT JOIN users u ON u.id = r.user_id ORDER BY r.remind_at ASC LIMIT 10");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadQuotes(): array {
        $stmt = DB::prepare("SELECT q.*, co.name AS company_name, d.title AS deal_title FROM crm_quotes q LEFT JOIN crm_companies co ON co.id = q.company_id LEFT JOIN crm_deals d ON d.id = q.deal_id ORDER BY q.created_at DESC LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadInvoices(): array {
        $stmt = DB::prepare("SELECT i.*, co.name AS company_name, d.title AS deal_title FROM crm_invoices i LEFT JOIN crm_companies co ON co.id = i.company_id LEFT JOIN crm_deals d ON d.id = i.deal_id ORDER BY i.created_at DESC LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadQuoteDocument(int $id): ?array {
        $stmt = DB::prepare("SELECT q.*, co.name AS company_name, co.email AS company_email, co.phone AS company_phone, co.address AS company_address, ct.name AS contact_name, ct.email AS contact_email, ct.phone AS contact_phone, d.title AS deal_title
            FROM crm_quotes q
            LEFT JOIN crm_companies co ON co.id = q.company_id
            LEFT JOIN crm_contacts ct ON ct.id = q.contact_id
            LEFT JOIN crm_deals d ON d.id = q.deal_id
            WHERE q.id = ?
            LIMIT 1");
        $stmt->execute([$id]);
        $document = $stmt->fetch();
        if (!$document) {
            return null;
        }

        $lineStmt = DB::prepare("SELECT description, quantity, unit_price, tax_rate, line_total, sort_order FROM crm_quote_lines WHERE quote_id = ? ORDER BY sort_order ASC, id ASC");
        $lineStmt->execute([$id]);
        $document['lines'] = $lineStmt->fetchAll();
        return $document;
    }

    private function loadInvoiceDocument(int $id): ?array {
        $stmt = DB::prepare("SELECT i.*, co.name AS company_name, co.email AS company_email, co.phone AS company_phone, co.address AS company_address, ct.name AS contact_name, ct.email AS contact_email, ct.phone AS contact_phone, d.title AS deal_title
            FROM crm_invoices i
            LEFT JOIN crm_companies co ON co.id = i.company_id
            LEFT JOIN crm_contacts ct ON ct.id = i.contact_id
            LEFT JOIN crm_deals d ON d.id = i.deal_id
            WHERE i.id = ?
            LIMIT 1");
        $stmt->execute([$id]);
        $document = $stmt->fetch();
        if (!$document) {
            return null;
        }

        $lineStmt = DB::prepare("SELECT description, quantity, unit_price, tax_rate, line_total, sort_order FROM crm_invoice_lines WHERE invoice_id = ? ORDER BY sort_order ASC, id ASC");
        $lineStmt->execute([$id]);
        $document['lines'] = $lineStmt->fetchAll();
        return $document;
    }

    private function moneyPlain($value, $currency = 'EUR'): string {
        return number_format((float)$value, 2, ',', '.') . ' ' . (string)$currency;
    }

    private function renderDocumentPdf(string $kind, array $document): void {
        $workspace = WorkspaceSettings::all();
        $pdf = new SimplePdf();
        $title = $kind === 'quote' ? 'PREVENTIVO' : 'FATTURA';
        $number = $kind === 'quote' ? (string)($document['quote_number'] ?? '') : (string)($document['invoice_number'] ?? '');
        $statusGroup = $kind === 'quote' ? 'quote_status' : 'invoice_status';
        $status = $this->label($statusGroup, (string)($document['status'] ?? 'draft'));
        $issueDate = Locale::formatDate((string)($document['issue_date'] ?? ''));
        $secondaryDate = $kind === 'quote'
            ? Locale::formatDate((string)($document['expiry_date'] ?? ''))
            : Locale::formatDate((string)($document['due_date'] ?? ''));
        $secondaryLabel = $kind === 'quote' ? 'Scadenza offerta' : 'Scadenza pagamento';
        $currency = (string)($document['currency'] ?? 'EUR');
        $companyName = (string)($document['company_name'] ?? '-');
        $contactName = (string)($document['contact_name'] ?? '-');
        $dealTitle = (string)($document['deal_title'] ?? '-');
        $supportEmail = (string)($workspace['support_email'] ?? 'support@example.com');
        $supportPhone = (string)($workspace['support_phone'] ?? '');
        $workspaceName = (string)($workspace['workspace_name'] ?? 'CoreSuite Lite');
        $legalName = (string)($workspace['legal_name'] ?? $workspaceName);
        $addressLine = trim((string)($workspace['address_line'] ?? ''));
        $addressCity = trim((string)($workspace['address_city'] ?? ''));
        $addressZip = trim((string)($workspace['address_zip'] ?? ''));
        $addressCountry = trim((string)($workspace['address_country'] ?? 'Italia'));
        $vatNumber = trim((string)($workspace['vat_number'] ?? ''));
        $taxCode = trim((string)($workspace['tax_code'] ?? ''));
        $pecEmail = trim((string)($workspace['pec_email'] ?? ''));
        $sdiCode = trim((string)($workspace['sdi_code'] ?? ''));
        $iban = trim((string)($workspace['iban'] ?? ''));
        $appUrl = trim((string)($workspace['app_url'] ?? ''));
        $companyAddress = trim((string)($document['company_address'] ?? ''));
        $logoInitials = strtoupper(substr(preg_replace('/[^A-Z0-9]/i', '', $workspaceName), 0, 2) ?: 'CS');

        $x = 42.0;
        $contentWidth = $pdf->pageWidth() - ($x * 2);
        $bottomLimit = 748.0;
        $col = [
            'description_left' => $x,
            'description_right' => $x + 250,
            'qty_left' => $x + 250,
            'qty_right' => $x + 298,
            'unit_left' => $x + 298,
            'unit_right' => $x + 386,
            'tax_left' => $x + 386,
            'tax_right' => $x + 428,
            'total_left' => $x + 428,
            'total_right' => $x + $contentWidth,
        ];
        $drawRightText = function (float $rightX, float $y, string $text, float $size) use ($pdf): void {
            $pdf->text(max(24.0, $rightX - $pdf->textWidth($text, $size)), $y, $text, $size);
        };
        $pageNumber = 0;

        $drawFooter = function () use ($pdf, $x, $contentWidth, $workspaceName, $supportEmail, $supportPhone, $vatNumber, $taxCode, $appUrl, &$pageNumber) {
            $footerY = 794.0;
            $pdf->strokeColor(215, 224, 236);
            $pdf->line($x, $footerY - 16, $x + $contentWidth, $footerY - 16, 0.8);
            $footerText = trim($workspaceName . ' · ' . $supportEmail . ($supportPhone !== '' ? ' · ' . $supportPhone : ''));
            $compliance = trim(($vatNumber !== '' ? 'P.IVA ' . $vatNumber : '') . ($taxCode !== '' ? ' · C.F. ' . $taxCode : '') . ($appUrl !== '' ? ' · ' . preg_replace('#^https?://#', '', $appUrl) : ''));
            $pdf->fillColor(100, 116, 139);
            $pdf->text($x, $footerY, $footerText, 8.5);
            if ($compliance !== '') {
                $pdf->text($x, $footerY + 12, $compliance, 8.5);
            }
            $pdf->text($x + $contentWidth - 46, $footerY, 'Pag. ' . $pageNumber, 8.5);
        };

        $drawTableHeader = function (float $top) use ($pdf, $x, $contentWidth, $col, $drawRightText) {
            $pdf->fillColor(15, 23, 42);
            $pdf->rect($x, $top, $contentWidth, 26, 'f');
            $pdf->fillColor(255, 255, 255);
            $pdf->text($col['description_left'] + 8, $top + 17, 'Descrizione', 9);
            $pdf->text($col['qty_left'] + 8, $top + 17, 'Qta', 9);
            $drawRightText($col['unit_right'] - 10, $top + 17, 'Prezzo', 9);
            $drawRightText($col['tax_right'] - 10, $top + 17, 'IVA', 9);
            $drawRightText($col['total_right'] - 10, $top + 17, 'Totale', 9);
            $pdf->strokeColor(215, 224, 236);
            $pdf->line($col['description_right'], $top, $col['description_right'], $top + 26, 0.4);
            $pdf->line($col['qty_right'], $top, $col['qty_right'], $top + 26, 0.4);
            $pdf->line($col['unit_right'], $top, $col['unit_right'], $top + 26, 0.4);
            $pdf->line($col['tax_right'], $top, $col['tax_right'], $top + 26, 0.4);
            $pdf->fillColor(15, 23, 42);
        };

        $startPage = function (bool $firstPage) use (
            $pdf,
            $x,
            $contentWidth,
            $workspaceName,
            $legalName,
            $logoInitials,
            $title,
            $number,
            $status,
            $issueDate,
            $secondaryLabel,
            $secondaryDate,
            $companyName,
            $companyAddress,
            $contactName,
            $dealTitle,
            $document,
            $addressLine,
            $addressCity,
            $addressZip,
            $addressCountry,
            $supportEmail,
            $supportPhone,
            $vatNumber,
            $taxCode,
            $pecEmail,
            $sdiCode,
            $iban,
            $drawTableHeader,
            $drawFooter,
            &$pageNumber
        ): float {
            $pageNumber++;
            $pdf->addPage();
            $pdf->fillColor(15, 23, 42);
            $pdf->rect($x, 42, 54, 54, 'f');
            $pdf->fillColor(255, 255, 255);
            $pdf->text($x + 15, 75, $logoInitials, 22);
            $pdf->fillColor(15, 23, 42);
            $pdf->text($x + 72, 62, $workspaceName, 18);
            $pdf->text($x + 72, 84, $legalName, 10.5);

            $pdf->fillColor(14, 165, 168);
            $pdf->rect($x + 312, 42, $contentWidth - 312, 54, 'f');
            $pdf->fillColor(255, 255, 255);
            $pdf->text($x + 330, 63, $title, 22);
            $pdf->text($x + 330, 84, ($number !== '' ? $number : '-'), 12);

            $pdf->fillColor(100, 116, 139);
            $pdf->text($x, 118, 'Status: ' . $status, 10);
            $pdf->text($x + 160, 118, 'Emissione: ' . $issueDate, 10);
            $pdf->text($x + 326, 118, $secondaryLabel . ': ' . ($secondaryDate !== '' ? $secondaryDate : '-'), 10);

            $cursor = 148.0;
            if ($firstPage) {
                $issuerLines = array_filter([
                    $legalName,
                    $addressLine,
                    trim($addressZip . ' ' . $addressCity . ($addressCountry !== '' ? ' · ' . $addressCountry : '')),
                    $vatNumber !== '' ? 'P.IVA: ' . $vatNumber : '',
                    $taxCode !== '' ? 'C.F.: ' . $taxCode : '',
                    $pecEmail !== '' ? 'PEC: ' . $pecEmail : '',
                    $sdiCode !== '' ? 'SDI: ' . $sdiCode : '',
                    $iban !== '' ? 'IBAN: ' . $iban : '',
                    'Email: ' . $supportEmail . ($supportPhone !== '' ? ' · Tel: ' . $supportPhone : ''),
                ]);
                $recipientLines = array_filter([
                    $companyName,
                    $contactName !== '-' ? 'Contatto: ' . $contactName : '',
                    $companyAddress !== '' ? $companyAddress : '',
                    'Email: ' . ((string)($document['company_email'] ?: $document['contact_email'] ?: '-')),
                    'Telefono: ' . ((string)($document['company_phone'] ?: $document['contact_phone'] ?: '-')),
                    $dealTitle !== '-' ? 'Deal: ' . $dealTitle : '',
                ]);
                $issuerHeight = 24.0;
                foreach ($issuerLines as $line) {
                    $issuerHeight += $pdf->estimateWrappedHeight((string)$line, 216, 9.5, 12);
                }
                $recipientHeight = 24.0;
                foreach ($recipientLines as $line) {
                    $recipientHeight += $pdf->estimateWrappedHeight((string)$line, 216, 9.5, 12);
                }
                $partyBoxHeight = max(118.0, max($issuerHeight, $recipientHeight) + 22.0);

                $pdf->fillColor(238, 243, 250);
                $pdf->rect($x, $cursor, 246, $partyBoxHeight, 'f');
                $pdf->rect($x + 254, $cursor, $contentWidth - 254, $partyBoxHeight, 'f');
                $pdf->fillColor(15, 23, 42);
                $pdf->text($x + 14, $cursor + 18, 'Mittente', 10.5);
                $pdf->text($x + 268, $cursor + 18, 'Destinatario', 10.5);

                $issuerY = $cursor + 38;
                foreach ($issuerLines as $line) {
                    $issuerY = $pdf->wrappedText($x + 14, $issuerY, 216, (string)$line, 9.5, 12);
                }
                $recipientY = $cursor + 38;
                foreach ($recipientLines as $line) {
                    $recipientY = $pdf->wrappedText($x + 268, $recipientY, 216, (string)$line, 9.5, 12);
                }
                $cursor += $partyBoxHeight + 22;
            }

            $drawTableHeader($cursor);
            $drawFooter();
            return $cursor + 40;
        };

        $currentY = $startPage(true);
        foreach ((array)($document['lines'] ?? []) as $line) {
            $descriptionLines = $pdf->wrapLines((string)($line['description'] ?? '-'), $col['description_right'] - $col['description_left'] - 16, 9.0);
            $isFirstChunk = true;
            while ($descriptionLines !== []) {
                $availableHeight = $bottomLimit - $currentY - 8.0;
                $maxLines = max(1, (int)floor($availableHeight / 12.0));
                $chunk = array_splice($descriptionLines, 0, $maxLines);
                $rowHeight = max(24.0, (count($chunk) * 12.0) + 10.0);

                if ($currentY + $rowHeight > $bottomLimit) {
                    $currentY = $startPage(false);
                    continue;
                }

                $pdf->line($x, $currentY - 10, $x + $contentWidth, $currentY - 10, 0.6);
                $pdf->fillColor(15, 23, 42);
                $pdf->strokeColor(229, 233, 240);
                $pdf->line($col['description_right'], $currentY - 10, $col['description_right'], $currentY + $rowHeight - 2, 0.35);
                $pdf->line($col['qty_right'], $currentY - 10, $col['qty_right'], $currentY + $rowHeight - 2, 0.35);
                $pdf->line($col['unit_right'], $currentY - 10, $col['unit_right'], $currentY + $rowHeight - 2, 0.35);
                $pdf->line($col['tax_right'], $currentY - 10, $col['tax_right'], $currentY + $rowHeight - 2, 0.35);
                $pdf->fillColor(15, 23, 42);
                $descriptionBottom = $pdf->wrappedText($col['description_left'] + 8, $currentY, $col['description_right'] - $col['description_left'] - 16, implode("\n", $chunk), 9.0, 12);
                if ($isFirstChunk) {
                    $pdf->text($col['qty_left'] + 8, $currentY, number_format((float)($line['quantity'] ?? 0), 2, ',', '.'), 8.8);
                    $drawRightText($col['unit_right'] - 10, $currentY, $this->moneyPlain($line['unit_price'] ?? 0, $currency), 8.8);
                    $drawRightText($col['tax_right'] - 10, $currentY, number_format((float)($line['tax_rate'] ?? 0), 2, ',', '.') . '%', 8.8);
                    $drawRightText($col['total_right'] - 10, $currentY, $this->moneyPlain($line['line_total'] ?? 0, $currency), 8.8);
                    $isFirstChunk = false;
                }
                $currentY = max($currentY + $rowHeight, $descriptionBottom + 8);

                if ($descriptionLines !== []) {
                    $currentY = $startPage(false);
                }
            }
        }

        $notesLines = $pdf->wrapLines((string)($document['notes'] ?? 'Nessuna nota aggiuntiva.'), $contentWidth - 28, 9.3);
        $notesChunks = array_chunk($notesLines, 16);
        if ($notesChunks === []) {
            $notesChunks = [['Nessuna nota aggiuntiva.']];
        }
        foreach ($notesChunks as $index => $notesChunk) {
            $notesHeight = max(72.0, 34.0 + (count($notesChunk) * 12.0));
            if ($currentY + $notesHeight > $bottomLimit) {
                $currentY = $startPage(false);
            }
            $pdf->fillColor(238, 243, 250);
            $pdf->rect($x, $currentY + 8, $contentWidth, $notesHeight, 'f');
            $pdf->fillColor(15, 23, 42);
            $pdf->text($x + 14, $currentY + 28, $index === 0 ? 'Note documento' : 'Note documento (continua)', 10.5);
            $pdf->fillColor(100, 116, 139);
            $notesCursor = $currentY + 48;
            foreach ($notesChunk as $line) {
                $pdf->text($x + 14, $notesCursor, $line, 9.3);
                $notesCursor += 12;
            }
            $currentY += $notesHeight + 18;
        }

        $summaryHeight = $kind === 'invoice' ? 118.0 : 94.0;
        if ($currentY + $summaryHeight > $bottomLimit) {
            $currentY = $startPage(false);
        }
        $summaryW = 220.0;
        $summaryX = $x + $contentWidth - $summaryW;
        $pdf->fillColor(238, 243, 250);
        $pdf->rect($summaryX, $currentY + 8, $summaryW, $summaryHeight, 'f');
        $pdf->fillColor(15, 23, 42);
        $pdf->text($summaryX + 14, $currentY + 28, 'Subtotale', 10);
        $pdf->text($summaryX + 14, $currentY + 48, 'IVA', 10);
        $pdf->text($summaryX + 14, $currentY + 70, 'Totale', 12);
        if ($kind === 'invoice') {
            $pdf->text($summaryX + 14, $currentY + 92, 'Incassato', 10);
        }
        $summaryRight = $summaryX + $summaryW - 14;
        $drawRightText($summaryRight, $currentY + 28, $this->moneyPlain($document['subtotal'] ?? 0, $currency), 10);
        $drawRightText($summaryRight, $currentY + 48, $this->moneyPlain($document['tax_total'] ?? 0, $currency), 10);
        $drawRightText($summaryRight, $currentY + 70, $this->moneyPlain($document['total'] ?? 0, $currency), 12);
        if ($kind === 'invoice') {
            $drawRightText($summaryRight, $currentY + 92, $this->moneyPlain($document['paid_total'] ?? 0, $currency), 10);
        }

        $fileName = strtolower($title . '-' . ($number !== '' ? $number : 'documento')) . '.pdf';
        $fileName = preg_replace('/[^a-z0-9\-_.]+/i', '-', $fileName) ?: 'document.pdf';
        $download = !empty($_GET['download']);
        $pdf->output($fileName, $download);
        exit;
    }

    private function dashboardMetrics(): array {
        $metrics = [
            'companies' => 0,
            'contacts' => 0,
            'qualified_leads' => 0,
            'open_deals' => 0,
            'pipeline_value' => 0.0,
            'forecast_value' => 0.0,
            'pending_quotes' => 0,
            'open_invoices' => 0,
            'upcoming_actions' => 0,
        ];

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_companies")->fetch();
        $metrics['companies'] = (int)($row['total'] ?? 0);

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_contacts")->fetch();
        $metrics['contacts'] = (int)($row['total'] ?? 0);

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_leads WHERE status IN ('qualified', 'nurturing')")->fetch();
        $metrics['qualified_leads'] = (int)($row['total'] ?? 0);

        $row = DB::query("SELECT COUNT(*) AS total, COALESCE(SUM(amount), 0) AS total_value, COALESCE(SUM(amount * (probability / 100)), 0) AS weighted_value FROM crm_deals WHERE status = 'open' AND stage NOT IN ('won', 'lost')")->fetch();
        $metrics['open_deals'] = (int)($row['total'] ?? 0);
        $metrics['pipeline_value'] = (float)($row['total_value'] ?? 0);
        $metrics['forecast_value'] = (float)($row['weighted_value'] ?? 0);

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_quotes WHERE status IN ('draft', 'sent')")->fetch();
        $metrics['pending_quotes'] = (int)($row['total'] ?? 0);

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_invoices WHERE status IN ('issued', 'partial', 'overdue')")->fetch();
        $metrics['open_invoices'] = (int)($row['total'] ?? 0);

        $row = DB::query("SELECT COUNT(*) AS total FROM crm_reminders WHERE status = 'pending' AND remind_at >= NOW() AND remind_at <= DATE_ADD(NOW(), INTERVAL 7 DAY)")->fetch();
        $metrics['upcoming_actions'] = (int)($row['total'] ?? 0);

        return $metrics;
    }

    private function pipelineData(): array {
        $deals = $this->loadDeals();
        $groups = [];
        foreach ($this->dealStages() as $stage) {
            $groups[$stage] = [];
        }
        foreach ($deals as $deal) {
            $stage = (string)($deal['stage'] ?? 'lead_in');
            if (!isset($groups[$stage])) {
                $groups[$stage] = [];
            }
            $groups[$stage][] = $deal;
        }
        return $groups;
    }

    private function calendarData(): array {
        $stmt = DB::prepare(" 
            SELECT 'reminder' AS item_type, id, title AS subject, remind_at AS event_at, status, company_id, deal_id, lead_id, NULL AS activity_type, channel, created_at
            FROM crm_reminders
            WHERE remind_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            UNION ALL
            SELECT 'activity' AS item_type, id, subject, scheduled_at AS event_at, CASE WHEN completed_at IS NULL THEN 'planned' ELSE 'done' END AS status, company_id, deal_id, lead_id, type AS activity_type, NULL AS channel, created_at
            FROM crm_activities
            WHERE scheduled_at IS NOT NULL AND scheduled_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            ORDER BY event_at ASC
        ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $groups = [];
        foreach ($rows as $row) {
            $key = substr((string)($row['event_at'] ?? ''), 0, 10);
            if ($key === '') {
                continue;
            }
            if (!isset($groups[$key])) {
                $groups[$key] = [];
            }
            $groups[$key][] = $row;
        }

        return $groups;
    }

    public function index($params = []): void {
        $this->authorizeView();
        $this->ensureSchema();
        $this->ensureDemoData();

        $metrics = $this->dashboardMetrics();
        $companies = $this->loadCompanies();
        $contacts = $this->loadContacts();
        $leads = $this->loadLeads();
        $deals = $this->loadDeals();
        $activities = $this->loadActivities();
        $reminders = $this->loadReminders();
        $quotes = $this->loadQuotes();
        $invoices = $this->loadInvoices();
        $owners = $this->loadOwners();
        $companyOptions = $this->loadAllCompanyOptions();
        $contactOptions = $this->loadAllContactOptions();
        $leadOptions = $this->loadAllLeadOptions();
        $dealOptions = $this->loadAllDealOptions();
        $companyStatuses = $this->companyStatuses();
        $leadStatuses = $this->leadStatuses();
        $dealStages = $this->dealStages();
        $quoteStatuses = $this->quoteStatuses();
        $invoiceStatuses = $this->invoiceStatuses();
        $activityTypes = $this->activityTypes();

        include __DIR__ . '/../Views/sales_dashboard.php';
    }

    public function pipeline($params = []): void {
        $this->authorizeView();
        $this->ensureSchema();
        $this->ensureDemoData();

        $dealStages = $this->dealStages();
        $pipelineGroups = $this->pipelineData();
        include __DIR__ . '/../Views/sales_pipeline.php';
    }

    public function calendar($params = []): void {
        $this->authorizeView();
        $this->ensureSchema();
        $this->ensureDemoData();

        $agendaGroups = $this->calendarData();
        include __DIR__ . '/../Views/sales_calendar.php';
    }

    private function salesFormPrefill(): array {
        return [
            'company_id' => (int)($_GET['company_id'] ?? 0),
            'contact_id' => (int)($_GET['contact_id'] ?? 0),
            'lead_id' => (int)($_GET['lead_id'] ?? 0),
            'deal_id' => (int)($_GET['deal_id'] ?? 0),
        ];
    }

    private function salesSelectOptions(array $rows, string $valueKey, string $labelKey, bool $includeBlank = true): array {
        $options = $includeBlank ? [['value' => '', 'label' => '-']] : [];
        foreach ($rows as $row) {
            $options[] = [
                'value' => (string)($row[$valueKey] ?? ''),
                'label' => (string)($row[$labelKey] ?? ''),
            ];
        }
        return $options;
    }

    private function salesStatusOptions(string $group, array $values): array {
        $options = [];
        foreach ($values as $value) {
            $options[] = [
                'value' => $value,
                'label' => $this->label($group, $value),
            ];
        }
        return $options;
    }

    private function salesFormText(string $key): string {
        $locale = Locale::current();
        $copy = [
            'it' => [
                'eyebrow' => 'Sales CRM',
                'back_sales' => 'Torna al cockpit sales',
                'back_calendar' => 'Vai al calendario sales',
                'owner' => 'Owner',
                'website' => 'Website',
                'notes' => 'Note',
                'company' => 'Azienda',
                'contact' => 'Contatto',
                'linked_lead' => 'Lead collegato',
                'linked_deal' => 'Deal collegato',
                'title' => 'Titolo',
                'status' => 'Stato',
                'type' => 'Tipo',
                'currency' => 'Valuta',
                'issue_date' => 'Data emissione',
                'quote_expiry' => 'Scadenza preventivo',
                'invoice_due' => 'Scadenza fattura',
                'document_number' => 'Numero documento',
                'document_lines' => 'Righe documento',
                'document_lines_help' => 'Compila ogni voce su una riga separata con descrizione, quantita, prezzo e IVA.',
                'new_company_page' => 'Nuova azienda',
                'new_company_title' => 'Apri una nuova azienda nel cockpit commerciale',
                'new_company_lead' => 'Crea l anagrafica base in una pagina dedicata, con dati chiari e pronta per contatti, lead e deal collegati.',
                'save_company' => 'Salva azienda',
                'company_summary_title' => 'Azienda pronta per il CRM',
                'company_summary_text' => 'Una scheda pulita rende piu rapide ricerca, assegnazioni e aperture di trattativa.',
                'name' => 'Nome',
                'industry' => 'Settore',
                'phone' => 'Telefono',
                'address' => 'Indirizzo',
                'new_contact_page' => 'Nuovo contatto',
                'new_contact_title' => 'Aggiungi un decision maker o referente operativo',
                'new_contact_lead' => 'Collega il contatto all azienda corretta e rendilo subito riutilizzabile nei flussi lead, deal e reminder.',
                'save_contact' => 'Salva contatto',
                'contact_summary_title' => 'Rubrica pronta per azioni rapide',
                'contact_summary_text' => 'Un contatto chiaro evita duplicazioni e accelera assegnazioni, follow-up e apertura deal.',
                'role' => 'Ruolo',
                'primary_contact' => 'Contatto principale',
                'primary_contact_help' => 'Segna il referente principale della relazione commerciale.',
                'new_lead_page' => 'Nuovo lead',
                'new_lead_title' => 'Qualifica una nuova opportunita commerciale',
                'new_lead_lead' => 'Apri un lead strutturato con owner, score, valore stimato e prossimo step, senza appesantire il cockpit.',
                'save_lead' => 'Salva lead',
                'lead_summary_title' => 'Lead leggibile e assegnabile',
                'lead_summary_text' => 'Score, owner e next step aiutano il team a capire subito cosa fare e quando intervenire.',
                'source' => 'Fonte',
                'score' => 'Score',
                'estimated_value' => 'Valore stimato',
                'next_contact' => 'Prossimo contatto',
                'next_step' => 'Prossimo step',
                'new_deal_page' => 'Nuovo deal',
                'new_deal_title' => 'Trasforma contesto commerciale in trattativa attiva',
                'new_deal_lead' => 'Usa una pagina dedicata per definire valore, probabilita, stage e prossima azione senza appesantire la dashboard.',
                'save_deal' => 'Salva deal',
                'deal_summary_title' => 'Deal pronto per pipeline e forecast',
                'deal_summary_text' => 'Stage, amount e probabilita alimentano in modo credibile board commerciale e forecast pesato.',
                'stage' => 'Stage',
                'probability' => 'Probabilita %',
                'amount' => 'Importo',
                'expected_close_date' => 'Chiusura prevista',
                'next_action' => 'Prossima azione',
                'when' => 'Quando',
                'new_activity_page' => 'Nuova attivita',
                'new_activity_title' => 'Registra una touchpoint commerciale in una vista dedicata',
                'new_activity_lead' => 'Logga call, email, meeting e note operative con tutti i collegamenti corretti a lead e deal.',
                'save_activity' => 'Salva attivita',
                'activity_summary_title' => 'Storico commerciale pulito',
                'activity_summary_text' => 'Uno storico ben collegato rende piu semplice capire contesto, timing e prossime mosse.',
                'subject' => 'Oggetto',
                'scheduled_at' => 'Pianificata il',
                'new_reminder_page' => 'Nuovo reminder',
                'new_reminder_title' => 'Programma il prossimo follow-up commerciale',
                'new_reminder_lead' => 'Apri un reminder chiaro e tracciabile per non perdere scadenze, richiami e azioni critiche.',
                'save_reminder' => 'Salva reminder',
                'reminder_summary_title' => 'Agenda operativa sotto controllo',
                'reminder_summary_text' => 'Un reminder con owner e contesto corretto evita buchi nel follow-up e nelle scadenze commerciali.',
                'channel' => 'Canale',
                'remind_at' => 'Ricorda il',
                'new_quote_page' => 'Nuovo preventivo',
                'new_quote_title' => 'Crea un preventivo nativo fuori dal cockpit',
                'new_quote_lead' => 'Compila documento, righe e note in una pagina focalizzata, pensata per lavorare bene su offerte strutturate.',
                'save_quote' => 'Salva preventivo',
                'edit_quote_page' => 'Modifica preventivo',
                'edit_quote_title' => 'Aggiorna il preventivo in una pagina dedicata',
                'edit_quote_lead' => 'Rivedi righe, stato, date e note senza perdere il contesto commerciale del documento.',
                'update_quote' => 'Aggiorna preventivo',
                'quote_summary_title' => 'Documento commerciale leggibile',
                'quote_summary_text' => 'Separare il form dal cockpit migliora focus, precisione e controllo sulle righe documento.',
                'new_invoice_page' => 'Nuova fattura',
                'new_invoice_title' => 'Genera una fattura nativa in un workflow dedicato',
                'new_invoice_lead' => 'Mantieni il cockpit leggero e usa una pagina focalizzata per compilare documento, incassato e righe fattura.',
                'save_invoice' => 'Salva fattura',
                'edit_invoice_page' => 'Modifica fattura',
                'edit_invoice_title' => 'Aggiorna la fattura in un workflow dedicato',
                'edit_invoice_lead' => 'Correggi righe, stato, scadenza e incassato mantenendo il documento ordinato e leggibile.',
                'update_invoice' => 'Aggiorna fattura',
                'invoice_summary_title' => 'Fatturazione piu ordinata',
                'invoice_summary_text' => 'Separare la compilazione dalla dashboard riduce errori e migliora leggibilita dei dati commerciali.',
                'paid_total' => 'Incassato',
            ],
            'en' => [
                'eyebrow' => 'Sales CRM',
                'back_sales' => 'Back to sales cockpit',
                'back_calendar' => 'Go to sales calendar',
                'owner' => 'Owner',
                'website' => 'Website',
                'notes' => 'Notes',
                'company' => 'Company',
                'contact' => 'Contact',
                'linked_lead' => 'Linked lead',
                'linked_deal' => 'Linked deal',
                'title' => 'Title',
                'status' => 'Status',
                'type' => 'Type',
                'currency' => 'Currency',
                'issue_date' => 'Issue date',
                'quote_expiry' => 'Quote expiry',
                'invoice_due' => 'Invoice due date',
                'document_number' => 'Document number',
                'document_lines' => 'Document lines',
                'document_lines_help' => 'Fill each row with separate description, quantity, price, and VAT fields.',
                'new_company_page' => 'New company',
                'new_company_title' => 'Open a new company in the commercial cockpit',
                'new_company_lead' => 'Create the core account record in a dedicated page, ready for linked contacts, leads, and deals.',
                'save_company' => 'Save company',
                'company_summary_title' => 'Company ready for CRM',
                'company_summary_text' => 'A clean record makes search, assignments, and deal opening faster.',
                'name' => 'Name',
                'industry' => 'Industry',
                'phone' => 'Phone',
                'address' => 'Address',
                'new_contact_page' => 'New contact',
                'new_contact_title' => 'Add a decision maker or operational contact',
                'new_contact_lead' => 'Link the contact to the right company and make it reusable in lead, deal, and reminder flows.',
                'save_contact' => 'Save contact',
                'contact_summary_title' => 'Directory ready for quick actions',
                'contact_summary_text' => 'A clear contact reduces duplication and speeds up assignments, follow-ups, and deal creation.',
                'role' => 'Role',
                'primary_contact' => 'Primary contact',
                'primary_contact_help' => 'Mark the main contact for the commercial relationship.',
                'new_lead_page' => 'New lead',
                'new_lead_title' => 'Qualify a new sales opportunity',
                'new_lead_lead' => 'Open a structured lead with owner, score, estimated value, and next step without cluttering the cockpit.',
                'save_lead' => 'Save lead',
                'lead_summary_title' => 'Readable and assignable lead',
                'lead_summary_text' => 'Score, owner, and next step help the team understand what to do next and when.',
                'source' => 'Source',
                'score' => 'Score',
                'estimated_value' => 'Estimated value',
                'next_contact' => 'Next contact',
                'next_step' => 'Next step',
                'new_deal_page' => 'New deal',
                'new_deal_title' => 'Turn commercial context into an active deal',
                'new_deal_lead' => 'Use a dedicated page to define value, probability, stage, and next action without overloading the dashboard.',
                'save_deal' => 'Save deal',
                'deal_summary_title' => 'Deal ready for pipeline and forecast',
                'deal_summary_text' => 'Stage, amount, and probability feed the commercial board and weighted forecast credibly.',
                'stage' => 'Stage',
                'probability' => 'Probability %',
                'amount' => 'Amount',
                'expected_close_date' => 'Expected close date',
                'next_action' => 'Next action',
                'when' => 'When',
                'new_activity_page' => 'New activity',
                'new_activity_title' => 'Log a commercial touchpoint in a dedicated view',
                'new_activity_lead' => 'Log calls, emails, meetings, and operational notes with the right links to leads and deals.',
                'save_activity' => 'Save activity',
                'activity_summary_title' => 'Clean sales history',
                'activity_summary_text' => 'A well-linked history makes context, timing, and next moves easier to understand.',
                'subject' => 'Subject',
                'scheduled_at' => 'Scheduled at',
                'new_reminder_page' => 'New reminder',
                'new_reminder_title' => 'Schedule the next commercial follow-up',
                'new_reminder_lead' => 'Open a clear and trackable reminder so you do not miss deadlines, callbacks, or critical actions.',
                'save_reminder' => 'Save reminder',
                'reminder_summary_title' => 'Operational agenda under control',
                'reminder_summary_text' => 'A reminder with the right owner and context avoids gaps in follow-ups and commercial deadlines.',
                'channel' => 'Channel',
                'remind_at' => 'Remind at',
                'new_quote_page' => 'New quote',
                'new_quote_title' => 'Create a native quote outside the cockpit',
                'new_quote_lead' => 'Complete document, lines, and notes in a focused page designed for structured offers.',
                'save_quote' => 'Save quote',
                'edit_quote_page' => 'Edit quote',
                'edit_quote_title' => 'Update the quote in a dedicated page',
                'edit_quote_lead' => 'Review lines, status, dates, and notes without losing the commercial context of the document.',
                'update_quote' => 'Update quote',
                'quote_summary_title' => 'Readable commercial document',
                'quote_summary_text' => 'Separating the form from the cockpit improves focus, precision, and control over document lines.',
                'new_invoice_page' => 'New invoice',
                'new_invoice_title' => 'Generate a native invoice in a dedicated workflow',
                'new_invoice_lead' => 'Keep the cockpit light and use a focused page to fill in document, paid amount, and invoice lines.',
                'save_invoice' => 'Save invoice',
                'edit_invoice_page' => 'Edit invoice',
                'edit_invoice_title' => 'Update the invoice in a dedicated workflow',
                'edit_invoice_lead' => 'Adjust lines, status, due date, and paid amount while keeping the document clear and ordered.',
                'update_invoice' => 'Update invoice',
                'invoice_summary_title' => 'More orderly invoicing',
                'invoice_summary_text' => 'Separating entry from the dashboard reduces errors and improves readability of commercial data.',
                'paid_total' => 'Paid',
            ],
            'fr' => [
                'eyebrow' => 'Sales CRM',
                'back_sales' => 'Retour au cockpit commercial',
                'back_calendar' => 'Aller au calendrier commercial',
                'owner' => 'Responsable',
                'website' => 'Site web',
                'notes' => 'Notes',
                'company' => 'Societe',
                'contact' => 'Contact',
                'linked_lead' => 'Lead lie',
                'linked_deal' => 'Deal lie',
                'title' => 'Titre',
                'status' => 'Statut',
                'type' => 'Type',
                'currency' => 'Devise',
                'issue_date' => 'Date emission',
                'quote_expiry' => 'Expiration devis',
                'invoice_due' => 'Echeance facture',
                'document_number' => 'Numero document',
                'document_lines' => 'Lignes document',
                'document_lines_help' => 'Renseignez chaque ligne avec description, quantite, prix et TVA separes.',
                'new_company_page' => 'Nouvelle societe',
                'new_company_title' => 'Ouvrir une nouvelle societe dans le cockpit commercial',
                'new_company_lead' => 'Creez la fiche de base dans une page dediee, prete pour contacts, leads et deals lies.',
                'save_company' => 'Enregistrer societe',
                'company_summary_title' => 'Societe prete pour le CRM',
                'company_summary_text' => 'Une fiche claire accelere recherche, affectations et ouverture des opportunites.',
                'name' => 'Nom',
                'industry' => 'Secteur',
                'phone' => 'Telephone',
                'address' => 'Adresse',
                'new_contact_page' => 'Nouveau contact',
                'new_contact_title' => 'Ajouter un decideur ou contact operationnel',
                'new_contact_lead' => 'Liez le contact a la bonne societe et rendez-le reutilisable dans les flux leads, deals et rappels.',
                'save_contact' => 'Enregistrer contact',
                'contact_summary_title' => 'Carnet pret pour actions rapides',
                'contact_summary_text' => 'Un contact clair evite les doublons et accelere affectations, suivis et ouverture de deals.',
                'role' => 'Role',
                'primary_contact' => 'Contact principal',
                'primary_contact_help' => 'Indiquez le contact principal de la relation commerciale.',
                'new_lead_page' => 'Nouveau lead',
                'new_lead_title' => 'Qualifier une nouvelle opportunite commerciale',
                'new_lead_lead' => 'Ouvrez un lead structure avec responsable, score, valeur estimee et prochaine etape.',
                'save_lead' => 'Enregistrer lead',
                'lead_summary_title' => 'Lead lisible et attribuable',
                'lead_summary_text' => 'Score, responsable et prochaine etape aident l equipe a savoir quoi faire et quand.',
                'source' => 'Source',
                'score' => 'Score',
                'estimated_value' => 'Valeur estimee',
                'next_contact' => 'Prochain contact',
                'next_step' => 'Prochaine etape',
                'new_deal_page' => 'Nouveau deal',
                'new_deal_title' => 'Transformer le contexte commercial en deal actif',
                'new_deal_lead' => 'Utilisez une page dediee pour definir valeur, probabilite, etape et prochaine action.',
                'save_deal' => 'Enregistrer deal',
                'deal_summary_title' => 'Deal pret pour pipeline et forecast',
                'deal_summary_text' => 'Etape, montant et probabilite alimentent pipeline et forecast ponderes.',
                'stage' => 'Etape',
                'probability' => 'Probabilite %',
                'amount' => 'Montant',
                'expected_close_date' => 'Cloture prevue',
                'next_action' => 'Prochaine action',
                'when' => 'Quand',
                'new_activity_page' => 'Nouvelle activite',
                'new_activity_title' => 'Enregistrer un point de contact commercial',
                'new_activity_lead' => 'Journalisez appels, emails, reunions et notes avec les bons liens vers leads et deals.',
                'save_activity' => 'Enregistrer activite',
                'activity_summary_title' => 'Historique commercial propre',
                'activity_summary_text' => 'Un historique bien relie facilite la lecture du contexte, du timing et des prochaines actions.',
                'subject' => 'Objet',
                'scheduled_at' => 'Planifie le',
                'new_reminder_page' => 'Nouveau rappel',
                'new_reminder_title' => 'Programmer le prochain suivi commercial',
                'new_reminder_lead' => 'Ouvrez un rappel clair et tracable pour ne perdre aucune echeance ou action critique.',
                'save_reminder' => 'Enregistrer rappel',
                'reminder_summary_title' => 'Agenda operationnel sous controle',
                'reminder_summary_text' => 'Un rappel avec le bon responsable et contexte evite les trous dans le suivi.',
                'channel' => 'Canal',
                'remind_at' => 'Rappeler le',
                'new_quote_page' => 'Nouveau devis',
                'new_quote_title' => 'Creer un devis natif hors du cockpit',
                'new_quote_lead' => 'Remplissez document, lignes et notes dans une page focalisee pour les offres structurees.',
                'save_quote' => 'Enregistrer devis',
                'edit_quote_page' => 'Modifier devis',
                'edit_quote_title' => 'Mettre a jour le devis dans une page dediee',
                'edit_quote_lead' => 'Revisez lignes, statut, dates et notes sans perdre le contexte commercial du document.',
                'update_quote' => 'Mettre a jour devis',
                'quote_summary_title' => 'Document commercial lisible',
                'quote_summary_text' => 'Separ er le formulaire du cockpit ameliore focus, precision et controle des lignes.',
                'new_invoice_page' => 'Nouvelle facture',
                'new_invoice_title' => 'Generer une facture native dans un workflow dedie',
                'new_invoice_lead' => 'Gardez le cockpit leger et utilisez une page focalisee pour document, encaisse et lignes facture.',
                'save_invoice' => 'Enregistrer facture',
                'edit_invoice_page' => 'Modifier facture',
                'edit_invoice_title' => 'Mettre a jour la facture dans un workflow dedie',
                'edit_invoice_lead' => 'Corrigez lignes, statut, echeance et encaisse tout en gardant un document lisible.',
                'update_invoice' => 'Mettre a jour facture',
                'invoice_summary_title' => 'Facturation plus ordonnee',
                'invoice_summary_text' => 'Separ er la saisie du dashboard reduit les erreurs et ameliore la lisibilite des donnees commerciales.',
                'paid_total' => 'Encaisse',
            ],
            'es' => [
                'eyebrow' => 'Sales CRM',
                'back_sales' => 'Volver al cockpit comercial',
                'back_calendar' => 'Ir al calendario comercial',
                'owner' => 'Responsable',
                'website' => 'Sitio web',
                'notes' => 'Notas',
                'company' => 'Empresa',
                'contact' => 'Contacto',
                'linked_lead' => 'Lead vinculado',
                'linked_deal' => 'Deal vinculado',
                'title' => 'Titulo',
                'status' => 'Estado',
                'type' => 'Tipo',
                'currency' => 'Moneda',
                'issue_date' => 'Fecha emision',
                'quote_expiry' => 'Vencimiento presupuesto',
                'invoice_due' => 'Vencimiento factura',
                'document_number' => 'Numero documento',
                'document_lines' => 'Lineas del documento',
                'document_lines_help' => 'Completa cada linea con descripcion, cantidad, precio e IVA separados.',
                'new_company_page' => 'Nueva empresa',
                'new_company_title' => 'Abrir una nueva empresa en el cockpit comercial',
                'new_company_lead' => 'Crea la ficha base en una pagina dedicada, lista para contactos, leads y deals vinculados.',
                'save_company' => 'Guardar empresa',
                'company_summary_title' => 'Empresa lista para el CRM',
                'company_summary_text' => 'Una ficha clara acelera busqueda, asignaciones y apertura de oportunidades.',
                'name' => 'Nombre',
                'industry' => 'Sector',
                'phone' => 'Telefono',
                'address' => 'Direccion',
                'new_contact_page' => 'Nuevo contacto',
                'new_contact_title' => 'Agregar un decisor o contacto operativo',
                'new_contact_lead' => 'Vincula el contacto a la empresa correcta y hazlo reutilizable en leads, deals y recordatorios.',
                'save_contact' => 'Guardar contacto',
                'contact_summary_title' => 'Agenda lista para acciones rapidas',
                'contact_summary_text' => 'Un contacto claro evita duplicados y acelera asignaciones, seguimientos y apertura de deals.',
                'role' => 'Rol',
                'primary_contact' => 'Contacto principal',
                'primary_contact_help' => 'Marca el referente principal de la relacion comercial.',
                'new_lead_page' => 'Nuevo lead',
                'new_lead_title' => 'Calificar una nueva oportunidad comercial',
                'new_lead_lead' => 'Abre un lead estructurado con responsable, score, valor estimado y siguiente paso.',
                'save_lead' => 'Guardar lead',
                'lead_summary_title' => 'Lead legible y asignable',
                'lead_summary_text' => 'Score, responsable y siguiente paso ayudan al equipo a saber que hacer y cuando.',
                'source' => 'Fuente',
                'score' => 'Score',
                'estimated_value' => 'Valor estimado',
                'next_contact' => 'Proximo contacto',
                'next_step' => 'Siguiente paso',
                'new_deal_page' => 'Nuevo deal',
                'new_deal_title' => 'Convertir contexto comercial en una negociacion activa',
                'new_deal_lead' => 'Usa una pagina dedicada para definir valor, probabilidad, etapa y proxima accion.',
                'save_deal' => 'Guardar deal',
                'deal_summary_title' => 'Deal listo para pipeline y forecast',
                'deal_summary_text' => 'Etapa, importe y probabilidad alimentan pipeline y forecast ponderado.',
                'stage' => 'Etapa',
                'probability' => 'Probabilidad %',
                'amount' => 'Importe',
                'expected_close_date' => 'Cierre previsto',
                'next_action' => 'Proxima accion',
                'when' => 'Cuando',
                'new_activity_page' => 'Nueva actividad',
                'new_activity_title' => 'Registrar un touchpoint comercial en una vista dedicada',
                'new_activity_lead' => 'Registra llamadas, emails, reuniones y notas con los enlaces correctos a leads y deals.',
                'save_activity' => 'Guardar actividad',
                'activity_summary_title' => 'Historial comercial limpio',
                'activity_summary_text' => 'Un historial bien conectado facilita entender contexto, timing y siguientes movimientos.',
                'subject' => 'Asunto',
                'scheduled_at' => 'Programada el',
                'new_reminder_page' => 'Nuevo recordatorio',
                'new_reminder_title' => 'Programar el proximo seguimiento comercial',
                'new_reminder_lead' => 'Abre un recordatorio claro y trazable para no perder vencimientos o acciones criticas.',
                'save_reminder' => 'Guardar recordatorio',
                'reminder_summary_title' => 'Agenda operativa bajo control',
                'reminder_summary_text' => 'Un recordatorio con responsable y contexto correctos evita huecos en el seguimiento.',
                'channel' => 'Canal',
                'remind_at' => 'Recordar el',
                'new_quote_page' => 'Nuevo presupuesto',
                'new_quote_title' => 'Crear un presupuesto nativo fuera del cockpit',
                'new_quote_lead' => 'Completa documento, lineas y notas en una pagina enfocada para ofertas estructuradas.',
                'save_quote' => 'Guardar presupuesto',
                'edit_quote_page' => 'Editar presupuesto',
                'edit_quote_title' => 'Actualizar el presupuesto en una pagina dedicada',
                'edit_quote_lead' => 'Revisa lineas, estado, fechas y notas sin perder el contexto comercial del documento.',
                'update_quote' => 'Actualizar presupuesto',
                'quote_summary_title' => 'Documento comercial legible',
                'quote_summary_text' => 'Separar el formulario del cockpit mejora foco, precision y control sobre las lineas.',
                'new_invoice_page' => 'Nueva factura',
                'new_invoice_title' => 'Generar una factura nativa en un flujo dedicado',
                'new_invoice_lead' => 'Mantiene ligero el cockpit y usa una pagina enfocada para documento, cobrado y lineas de factura.',
                'save_invoice' => 'Guardar factura',
                'edit_invoice_page' => 'Editar factura',
                'edit_invoice_title' => 'Actualizar la factura en un flujo dedicado',
                'edit_invoice_lead' => 'Corrige lineas, estado, vencimiento y cobrado manteniendo el documento claro y ordenado.',
                'update_invoice' => 'Actualizar factura',
                'invoice_summary_title' => 'Facturacion mas ordenada',
                'invoice_summary_text' => 'Separar la carga del dashboard reduce errores y mejora la legibilidad de los datos comerciales.',
                'paid_total' => 'Cobrado',
            ],
        ];

        return $copy[$locale][$key] ?? $copy['it'][$key] ?? $key;
    }

    private function applySalesFormValues(array $config, array $values): array {
        if (empty($config['fields'])) {
            return $config;
        }

        foreach ($config['fields'] as &$field) {
            $name = (string)($field['name'] ?? '');
            if ($name !== '' && array_key_exists($name, $values)) {
                $field['value'] = $values[$name];
            }
        }
        unset($field);

        return $config;
    }

    private function documentLineFormValue(array $lines): array {
        $value = [
            'description' => [],
            'quantity' => [],
            'unit_price' => [],
            'tax_rate' => [],
        ];

        foreach ($lines as $line) {
            $value['description'][] = (string)($line['description'] ?? '');
            $value['quantity'][] = (string)(float)($line['quantity'] ?? 1);
            $value['unit_price'][] = (string)(float)($line['unit_price'] ?? 0);
            $value['tax_rate'][] = (string)(float)($line['tax_rate'] ?? 0);
        }

        return $value;
    }

    private function salesFormConfig(string $type, array $prefill): array {
        $companyOptions = $this->salesSelectOptions($this->loadAllCompanyOptions(), 'id', 'name');
        $contactOptions = $this->salesSelectOptions($this->loadAllContactOptions(), 'id', 'name');
        $leadOptions = $this->salesSelectOptions($this->loadAllLeadOptions(), 'id', 'title');
        $dealOptions = $this->salesSelectOptions($this->loadAllDealOptions(), 'id', 'title');
        $ownerOptions = $this->salesSelectOptions($this->loadOwners(), 'id', 'name');
        $baseMeta = [
            'companies' => count($companyOptions) - 1,
            'contacts' => count($contactOptions) - 1,
            'deals' => count($dealOptions) - 1,
        ];

        switch ($type) {
            case 'company':
                return [
                    'key' => 'company',
                    'page_title' => $this->salesFormText('new_company_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_company_title'),
                    'lead' => $this->salesFormText('new_company_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_company'),
                    'action' => '/sales/companies',
                    'summary_title' => $this->salesFormText('company_summary_title'),
                    'summary_text' => $this->salesFormText('company_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'name', 'label' => $this->salesFormText('name'), 'type' => 'text', 'required' => true, 'col' => 'col-lg-8', 'placeholder' => 'Blue Atlas Logistics'],
                        ['name' => 'status', 'label' => $this->salesFormText('status'), 'type' => 'select', 'col' => 'col-lg-4', 'options' => $this->salesStatusOptions('company_status', $this->companyStatuses())],
                        ['name' => 'industry', 'label' => $this->salesFormText('industry'), 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => 'Logistica, hospitality, retail'],
                        ['name' => 'website', 'label' => $this->salesFormText('website'), 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => 'https://azienda.it'],
                        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'col' => 'col-md-6', 'placeholder' => 'team@azienda.it'],
                        ['name' => 'phone', 'label' => $this->salesFormText('phone'), 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => '+39 ...'],
                        ['name' => 'address', 'label' => $this->salesFormText('address'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 3],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 4],
                    ],
                ];
            case 'contact':
                return [
                    'key' => 'contact',
                    'page_title' => $this->salesFormText('new_contact_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_contact_title'),
                    'lead' => $this->salesFormText('new_contact_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_contact'),
                    'action' => '/sales/contacts',
                    'summary_title' => $this->salesFormText('contact_summary_title'),
                    'summary_text' => $this->salesFormText('contact_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'name', 'label' => $this->salesFormText('name'), 'type' => 'text', 'required' => true, 'col' => 'col-md-6', 'placeholder' => 'Marta Rosi'],
                        ['name' => 'role_title', 'label' => $this->salesFormText('role'), 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => 'Operations Manager'],
                        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'col' => 'col-md-6', 'placeholder' => 'marta.rosi@azienda.it'],
                        ['name' => 'phone', 'label' => $this->salesFormText('phone'), 'type' => 'text', 'col' => 'col-md-6'],
                        ['name' => 'is_primary', 'label' => $this->salesFormText('primary_contact'), 'type' => 'checkbox', 'col' => 'col-md-6', 'help' => $this->salesFormText('primary_contact_help')],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 4],
                    ],
                ];
            case 'lead':
                return [
                    'key' => 'lead',
                    'page_title' => $this->salesFormText('new_lead_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_lead_title'),
                    'lead' => $this->salesFormText('new_lead_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_lead'),
                    'action' => '/sales/leads',
                    'summary_title' => $this->salesFormText('lead_summary_title'),
                    'summary_text' => $this->salesFormText('lead_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'contact_id', 'label' => $this->salesFormText('contact'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $contactOptions, 'value' => (string)$prefill['contact_id']],
                        ['name' => 'title', 'label' => $this->salesFormText('title'), 'type' => 'text', 'required' => true, 'col' => 'col-lg-7', 'placeholder' => 'Portale hospitality con quote native'],
                        ['name' => 'owner_id', 'label' => $this->salesFormText('owner'), 'type' => 'select', 'col' => 'col-lg-5', 'options' => $ownerOptions],
                        ['name' => 'source', 'label' => $this->salesFormText('source'), 'type' => 'text', 'col' => 'col-md-4', 'placeholder' => 'Referral, inbound, evento'],
                        ['name' => 'status', 'label' => $this->salesFormText('status'), 'type' => 'select', 'col' => 'col-md-4', 'options' => $this->salesStatusOptions('lead_status', $this->leadStatuses())],
                        ['name' => 'score', 'label' => $this->salesFormText('score'), 'type' => 'number', 'col' => 'col-md-4', 'value' => '50', 'min' => '0', 'max' => '100'],
                        ['name' => 'estimated_value', 'label' => $this->salesFormText('estimated_value'), 'type' => 'text', 'col' => 'col-md-4', 'value' => '0'],
                        ['name' => 'currency', 'label' => $this->salesFormText('currency'), 'type' => 'text', 'col' => 'col-md-4', 'value' => 'EUR'],
                        ['name' => 'next_contact_at', 'label' => $this->salesFormText('next_contact'), 'type' => 'datetime-local', 'col' => 'col-md-4'],
                        ['name' => 'next_step', 'label' => $this->salesFormText('next_step'), 'type' => 'text', 'col' => 'col-12', 'placeholder' => 'Invio proposta, discovery, meeting'],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 5],
                    ],
                ];
            case 'deal':
                return [
                    'key' => 'deal',
                    'page_title' => $this->salesFormText('new_deal_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_deal_title'),
                    'lead' => $this->salesFormText('new_deal_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_deal'),
                    'action' => '/sales/deals',
                    'summary_title' => $this->salesFormText('deal_summary_title'),
                    'summary_text' => $this->salesFormText('deal_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'contact_id', 'label' => $this->salesFormText('contact'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $contactOptions, 'value' => (string)$prefill['contact_id']],
                        ['name' => 'lead_id', 'label' => $this->salesFormText('linked_lead'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $leadOptions, 'value' => (string)$prefill['lead_id']],
                        ['name' => 'owner_id', 'label' => $this->salesFormText('owner'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $ownerOptions],
                        ['name' => 'title', 'label' => $this->salesFormText('title'), 'type' => 'text', 'required' => true, 'col' => 'col-lg-6', 'placeholder' => 'Suite operations Blue Atlas'],
                        ['name' => 'stage', 'label' => $this->salesFormText('stage'), 'type' => 'select', 'col' => 'col-lg-3', 'options' => $this->salesStatusOptions('deal_stage', $this->dealStages())],
                        ['name' => 'probability', 'label' => $this->salesFormText('probability'), 'type' => 'number', 'col' => 'col-lg-3', 'value' => '50', 'min' => '0', 'max' => '100'],
                        ['name' => 'amount', 'label' => $this->salesFormText('amount'), 'type' => 'text', 'col' => 'col-md-4', 'value' => '0'],
                        ['name' => 'currency', 'label' => $this->salesFormText('currency'), 'type' => 'text', 'col' => 'col-md-4', 'value' => 'EUR'],
                        ['name' => 'expected_close_date', 'label' => $this->salesFormText('expected_close_date'), 'type' => 'date', 'col' => 'col-md-4'],
                        ['name' => 'next_action', 'label' => $this->salesFormText('next_action'), 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => 'Call decision maker, invio documento, negoziazione'],
                        ['name' => 'next_action_at', 'label' => $this->salesFormText('when'), 'type' => 'datetime-local', 'col' => 'col-md-6'],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 5],
                    ],
                ];
            case 'activity':
                return [
                    'key' => 'activity',
                    'page_title' => $this->salesFormText('new_activity_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_activity_title'),
                    'lead' => $this->salesFormText('new_activity_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_activity'),
                    'action' => '/sales/activities',
                    'summary_title' => $this->salesFormText('activity_summary_title'),
                    'summary_text' => $this->salesFormText('activity_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'type', 'label' => $this->salesFormText('type'), 'type' => 'select', 'col' => 'col-md-4', 'options' => $this->salesStatusOptions('activity_type', $this->activityTypes())],
                        ['name' => 'subject', 'label' => $this->salesFormText('subject'), 'type' => 'text', 'required' => true, 'col' => 'col-md-8', 'placeholder' => 'Discovery hospitality, demo, follow-up email'],
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'contact_id', 'label' => $this->salesFormText('contact'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $contactOptions, 'value' => (string)$prefill['contact_id']],
                        ['name' => 'lead_id', 'label' => $this->salesFormText('linked_lead'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $leadOptions, 'value' => (string)$prefill['lead_id']],
                        ['name' => 'deal_id', 'label' => $this->salesFormText('linked_deal'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $dealOptions, 'value' => (string)$prefill['deal_id']],
                        ['name' => 'user_id', 'label' => $this->salesFormText('owner'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $ownerOptions],
                        ['name' => 'scheduled_at', 'label' => $this->salesFormText('scheduled_at'), 'type' => 'datetime-local', 'col' => 'col-md-6'],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 5],
                    ],
                ];
            case 'reminder':
                return [
                    'key' => 'reminder',
                    'page_title' => $this->salesFormText('new_reminder_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_reminder_title'),
                    'lead' => $this->salesFormText('new_reminder_lead'),
                    'back_href' => '/sales/calendar',
                    'back_label' => $this->salesFormText('back_calendar'),
                    'submit_label' => $this->salesFormText('save_reminder'),
                    'action' => '/sales/reminders',
                    'summary_title' => $this->salesFormText('reminder_summary_title'),
                    'summary_text' => $this->salesFormText('reminder_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'title', 'label' => $this->salesFormText('title'), 'type' => 'text', 'required' => true, 'col' => 'col-lg-8', 'placeholder' => 'Richiamare cliente, verificare firma, inviare revisione'],
                        ['name' => 'channel', 'label' => $this->salesFormText('channel'), 'type' => 'text', 'col' => 'col-lg-4', 'value' => 'in_app'],
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'user_id', 'label' => $this->salesFormText('owner'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $ownerOptions],
                        ['name' => 'lead_id', 'label' => $this->salesFormText('linked_lead'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $leadOptions, 'value' => (string)$prefill['lead_id']],
                        ['name' => 'deal_id', 'label' => $this->salesFormText('linked_deal'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $dealOptions, 'value' => (string)$prefill['deal_id']],
                        ['name' => 'remind_at', 'label' => $this->salesFormText('remind_at'), 'type' => 'datetime-local', 'required' => true, 'col' => 'col-md-6'],
                    ],
                ];
            case 'quote':
                return [
                    'key' => 'quote',
                    'page_title' => $this->salesFormText('new_quote_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_quote_title'),
                    'lead' => $this->salesFormText('new_quote_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_quote'),
                    'action' => '/sales/quotes',
                    'summary_title' => $this->salesFormText('quote_summary_title'),
                    'summary_text' => $this->salesFormText('quote_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'contact_id', 'label' => $this->salesFormText('contact'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $contactOptions, 'value' => (string)$prefill['contact_id']],
                        ['name' => 'deal_id', 'label' => $this->salesFormText('linked_deal'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $dealOptions, 'value' => (string)$prefill['deal_id']],
                        ['name' => 'quote_number', 'label' => $this->salesFormText('document_number'), 'type' => 'text', 'col' => 'col-md-3', 'value' => $this->nextDocumentNumber('crm_quotes', 'Q')],
                        ['name' => 'status', 'label' => $this->salesFormText('status'), 'type' => 'select', 'col' => 'col-md-3', 'options' => $this->salesStatusOptions('quote_status', $this->quoteStatuses())],
                        ['name' => 'issue_date', 'label' => $this->salesFormText('issue_date'), 'type' => 'date', 'required' => true, 'col' => 'col-md-4', 'value' => date('Y-m-d')],
                        ['name' => 'expiry_date', 'label' => $this->salesFormText('quote_expiry'), 'type' => 'date', 'col' => 'col-md-4'],
                        ['name' => 'currency', 'label' => $this->salesFormText('currency'), 'type' => 'text', 'col' => 'col-md-4', 'value' => 'EUR'],
                        ['name' => 'lines', 'label' => $this->salesFormText('document_lines'), 'type' => 'document_lines', 'required' => true, 'col' => 'col-12', 'help' => $this->salesFormText('document_lines_help')],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 4],
                    ],
                ];
            case 'invoice':
                return [
                    'key' => 'invoice',
                    'page_title' => $this->salesFormText('new_invoice_page'),
                    'eyebrow' => $this->salesFormText('eyebrow'),
                    'title' => $this->salesFormText('new_invoice_title'),
                    'lead' => $this->salesFormText('new_invoice_lead'),
                    'back_href' => '/sales',
                    'back_label' => $this->salesFormText('back_sales'),
                    'submit_label' => $this->salesFormText('save_invoice'),
                    'action' => '/sales/invoices',
                    'summary_title' => $this->salesFormText('invoice_summary_title'),
                    'summary_text' => $this->salesFormText('invoice_summary_text'),
                    'meta' => $baseMeta,
                    'fields' => [
                        ['name' => 'company_id', 'label' => $this->salesFormText('company'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $companyOptions, 'value' => (string)$prefill['company_id']],
                        ['name' => 'contact_id', 'label' => $this->salesFormText('contact'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $contactOptions, 'value' => (string)$prefill['contact_id']],
                        ['name' => 'deal_id', 'label' => $this->salesFormText('linked_deal'), 'type' => 'select', 'col' => 'col-md-6', 'options' => $dealOptions, 'value' => (string)$prefill['deal_id']],
                        ['name' => 'invoice_number', 'label' => $this->salesFormText('document_number'), 'type' => 'text', 'col' => 'col-md-3', 'value' => $this->nextDocumentNumber('crm_invoices', 'INV')],
                        ['name' => 'status', 'label' => $this->salesFormText('status'), 'type' => 'select', 'col' => 'col-md-3', 'options' => $this->salesStatusOptions('invoice_status', $this->invoiceStatuses())],
                        ['name' => 'issue_date', 'label' => $this->salesFormText('issue_date'), 'type' => 'date', 'required' => true, 'col' => 'col-md-4', 'value' => date('Y-m-d')],
                        ['name' => 'due_date', 'label' => $this->salesFormText('invoice_due'), 'type' => 'date', 'col' => 'col-md-4'],
                        ['name' => 'paid_total', 'label' => $this->salesFormText('paid_total'), 'type' => 'text', 'col' => 'col-md-4', 'value' => '0'],
                        ['name' => 'currency', 'label' => $this->salesFormText('currency'), 'type' => 'text', 'col' => 'col-md-4', 'value' => 'EUR'],
                        ['name' => 'lines', 'label' => $this->salesFormText('document_lines'), 'type' => 'document_lines', 'required' => true, 'col' => 'col-12', 'help' => $this->salesFormText('document_lines_help')],
                        ['name' => 'notes', 'label' => $this->salesFormText('notes'), 'type' => 'textarea', 'col' => 'col-12', 'rows' => 4],
                    ],
                ];
        }

        throw new \InvalidArgumentException('Unknown sales form type');
    }

    private function renderCreatePage(string $type): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->ensureDemoData();

        $salesForm = $this->salesFormConfig($type, $this->salesFormPrefill());
        include __DIR__ . '/../Views/sales_form.php';
    }

    private function renderEditPage(string $type, array $document, string $action): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->ensureDemoData();

        $prefill = $this->salesFormPrefill();
        $prefill['company_id'] = (int)($document['company_id'] ?? 0);
        $prefill['contact_id'] = (int)($document['contact_id'] ?? 0);
        $prefill['deal_id'] = (int)($document['deal_id'] ?? 0);

        $salesForm = $this->salesFormConfig($type, $prefill);
        $values = [
            'company_id' => (string)($document['company_id'] ?? ''),
            'contact_id' => (string)($document['contact_id'] ?? ''),
            'deal_id' => (string)($document['deal_id'] ?? ''),
            'status' => (string)($document['status'] ?? ''),
            'issue_date' => (string)($document['issue_date'] ?? ''),
            'currency' => (string)($document['currency'] ?? 'EUR'),
            'lines' => $this->documentLineFormValue((array)($document['lines'] ?? [])),
            'notes' => (string)($document['notes'] ?? ''),
        ];

        if ($type === 'quote') {
            $values['quote_number'] = (string)($document['quote_number'] ?? '');
            $values['expiry_date'] = (string)($document['expiry_date'] ?? '');
            $salesForm['page_title'] = $this->salesFormText('edit_quote_page');
            $salesForm['title'] = $this->salesFormText('edit_quote_title');
            $salesForm['lead'] = $this->salesFormText('edit_quote_lead');
            $salesForm['submit_label'] = $this->salesFormText('update_quote');
        } else {
            $values['invoice_number'] = (string)($document['invoice_number'] ?? '');
            $values['due_date'] = (string)($document['due_date'] ?? '');
            $values['paid_total'] = (string)(float)($document['paid_total'] ?? 0);
            $salesForm['page_title'] = $this->salesFormText('edit_invoice_page');
            $salesForm['title'] = $this->salesFormText('edit_invoice_title');
            $salesForm['lead'] = $this->salesFormText('edit_invoice_lead');
            $salesForm['submit_label'] = $this->salesFormText('update_invoice');
        }

        $salesForm['action'] = $action;
        $salesForm = $this->applySalesFormValues($salesForm, $values);

        include __DIR__ . '/../Views/sales_form.php';
    }

    public function createCompany($params = []): void {
        $this->renderCreatePage('company');
    }

    public function createContact($params = []): void {
        $this->renderCreatePage('contact');
    }

    public function createLead($params = []): void {
        $this->renderCreatePage('lead');
    }

    public function createDeal($params = []): void {
        $this->renderCreatePage('deal');
    }

    public function createActivity($params = []): void {
        $this->renderCreatePage('activity');
    }

    public function createReminder($params = []): void {
        $this->renderCreatePage('reminder');
    }

    public function createQuote($params = []): void {
        $this->renderCreatePage('quote');
    }

    public function createInvoice($params = []): void {
        $this->renderCreatePage('invoice');
    }

    public function editQuote($params = []): void {
        $document = $this->loadQuoteDocument((int)($params['id'] ?? 0));
        if ($document === null) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        $this->renderEditPage('quote', $document, '/sales/quotes/' . (int)$document['id']);
    }

    public function editInvoice($params = []): void {
        $document = $this->loadInvoiceDocument((int)($params['id'] ?? 0));
        if ($document === null) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        $this->renderEditPage('invoice', $document, '/sales/invoices/' . (int)$document['id']);
    }

    public function quotePdf($params = []): void {
        $this->authorizeView();
        $this->ensureSchema();
        $this->ensureDemoData();

        $document = $this->loadQuoteDocument((int)($params['id'] ?? 0));
        if ($document === null) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        $this->renderDocumentPdf('quote', $document);
    }

    public function invoicePdf($params = []): void {
        $this->authorizeView();
        $this->ensureSchema();
        $this->ensureDemoData();

        $document = $this->loadInvoiceDocument((int)($params['id'] ?? 0));
        if ($document === null) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        $this->renderDocumentPdf('invoice', $document);
    }

    public function storeCompany($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $name = trim((string)($_POST['name'] ?? ''));
        if ($name === '') {
            Auth::flash($this->message('name_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $stmt = DB::prepare("INSERT INTO crm_companies (name, status, industry, website, email, phone, address, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $name,
            in_array((string)($_POST['status'] ?? 'prospect'), $this->companyStatuses(), true) ? (string)$_POST['status'] : 'prospect',
            trim((string)($_POST['industry'] ?? '')) ?: null,
            trim((string)($_POST['website'] ?? '')) ?: null,
            trim((string)($_POST['email'] ?? '')) ?: null,
            trim((string)($_POST['phone'] ?? '')) ?: null,
            trim((string)($_POST['address'] ?? '')) ?: null,
            trim((string)($_POST['notes'] ?? '')) ?: null,
        ]);

        Auth::logAction('create', 'crm_company', (int)DB::lastInsertId());
        Auth::flash($this->message('company_created'), 'success');
        header('Location: /sales');
        exit;
    }

    public function storeContact($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $name = trim((string)($_POST['name'] ?? ''));
        if ($name === '') {
            Auth::flash($this->message('name_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $stmt = DB::prepare("INSERT INTO crm_contacts (company_id, customer_user_id, name, role_title, email, phone, is_primary, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['customer_user_id'] ?? 0) ?: null,
            $name,
            trim((string)($_POST['role_title'] ?? '')) ?: null,
            trim((string)($_POST['email'] ?? '')) ?: null,
            trim((string)($_POST['phone'] ?? '')) ?: null,
            !empty($_POST['is_primary']) ? 1 : 0,
            trim((string)($_POST['notes'] ?? '')) ?: null,
        ]);

        Auth::logAction('create', 'crm_contact', (int)DB::lastInsertId());
        Auth::flash($this->message('contact_created'), 'success');
        header('Location: /sales');
        exit;
    }

    public function storeLead($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $title = trim((string)($_POST['title'] ?? ''));
        if ($title === '') {
            Auth::flash($this->message('title_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $companyId = (int)($_POST['company_id'] ?? 0) ?: null;
        $contactId = (int)($_POST['contact_id'] ?? 0) ?: null;
        $ownerId = (int)($_POST['owner_id'] ?? 0) ?: null;
        $nextContactAt = $this->nullableDateTime($_POST['next_contact_at'] ?? null);
        $stmt = DB::prepare("INSERT INTO crm_leads (company_id, contact_id, owner_id, title, source, status, score, estimated_value, currency, next_step, next_contact_at, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $companyId,
            $contactId,
            $ownerId,
            $title,
            trim((string)($_POST['source'] ?? '')) ?: null,
            in_array((string)($_POST['status'] ?? 'new'), $this->leadStatuses(), true) ? (string)$_POST['status'] : 'new',
            max(0, min(100, (int)($_POST['score'] ?? 0))),
            $this->parseAmount($_POST['estimated_value'] ?? 0),
            trim((string)($_POST['currency'] ?? 'EUR')) ?: 'EUR',
            trim((string)($_POST['next_step'] ?? '')) ?: null,
            $nextContactAt,
            trim((string)($_POST['notes'] ?? '')) ?: null,
        ]);

        $leadId = (int)DB::lastInsertId();
        $this->autoReminderForLead($leadId, $companyId, $contactId, $ownerId, 'Auto follow-up lead: ' . $title, $nextContactAt);
        Auth::logAction('create', 'crm_lead', $leadId);
        Auth::flash($this->message('lead_created'), 'success');
        header('Location: /sales');
        exit;
    }

    public function storeDeal($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $title = trim((string)($_POST['title'] ?? ''));
        if ($title === '') {
            Auth::flash($this->message('title_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $companyId = (int)($_POST['company_id'] ?? 0) ?: null;
        $contactId = (int)($_POST['contact_id'] ?? 0) ?: null;
        $leadId = (int)($_POST['lead_id'] ?? 0) ?: null;
        $ownerId = (int)($_POST['owner_id'] ?? 0) ?: null;
        $nextActionAt = $this->nullableDateTime($_POST['next_action_at'] ?? null);
        $stage = in_array((string)($_POST['stage'] ?? 'lead_in'), $this->dealStages(), true) ? (string)$_POST['stage'] : 'lead_in';

        $stmt = DB::prepare("INSERT INTO crm_deals (company_id, contact_id, lead_id, owner_id, title, stage, status, amount, currency, probability, expected_close_date, next_action, next_action_at, notes) VALUES (?, ?, ?, ?, ?, ?, 'open', ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $companyId,
            $contactId,
            $leadId,
            $ownerId,
            $title,
            $stage,
            $this->parseAmount($_POST['amount'] ?? 0),
            trim((string)($_POST['currency'] ?? 'EUR')) ?: 'EUR',
            max(0, min(100, (int)($_POST['probability'] ?? 0))),
            $this->nullableDate($_POST['expected_close_date'] ?? null),
            trim((string)($_POST['next_action'] ?? '')) ?: null,
            $nextActionAt,
            trim((string)($_POST['notes'] ?? '')) ?: null,
        ]);

        $dealId = (int)DB::lastInsertId();
        $this->autoReminderForDeal($dealId, $companyId, $contactId, $ownerId, 'Auto next action: ' . $title, $nextActionAt);
        Auth::logAction('create', 'crm_deal', $dealId);
        Auth::flash($this->message('deal_created'), 'success');
        header('Location: /sales');
        exit;
    }

    public function updateDealStage($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $id = (int)($params['id'] ?? 0);
        $stage = in_array((string)($_POST['stage'] ?? ''), $this->dealStages(), true) ? (string)$_POST['stage'] : 'lead_in';
        $status = in_array($stage, ['won', 'lost'], true) ? $stage : 'open';
        $stmt = DB::prepare("UPDATE crm_deals SET stage = ?, status = ? WHERE id = ?");
        $stmt->execute([$stage, $status, $id]);

        Auth::logAction('update', 'crm_deal', $id);
        Auth::flash($this->message('deal_stage_updated'), 'success');
        header('Location: /sales/pipeline');
        exit;
    }

    public function storeActivity($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $subject = trim((string)($_POST['subject'] ?? ''));
        if ($subject === '') {
            Auth::flash($this->message('title_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $stmt = DB::prepare("INSERT INTO crm_activities (company_id, contact_id, lead_id, deal_id, user_id, type, subject, notes, scheduled_at, completed_at, outcome) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['contact_id'] ?? 0) ?: null,
            (int)($_POST['lead_id'] ?? 0) ?: null,
            (int)($_POST['deal_id'] ?? 0) ?: null,
            (int)($_POST['user_id'] ?? 0) ?: null,
            in_array((string)($_POST['type'] ?? 'note'), $this->activityTypes(), true) ? (string)$_POST['type'] : 'note',
            $subject,
            trim((string)($_POST['notes'] ?? '')) ?: null,
            $this->nullableDateTime($_POST['scheduled_at'] ?? null),
            $this->nullableDateTime($_POST['completed_at'] ?? null),
            trim((string)($_POST['outcome'] ?? '')) ?: null,
        ]);

        Auth::logAction('create', 'crm_activity', (int)DB::lastInsertId());
        Auth::flash($this->message('activity_created'), 'success');
        header('Location: /sales');
        exit;
    }

    public function storeReminder($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $title = trim((string)($_POST['title'] ?? ''));
        $remindAt = $this->nullableDateTime($_POST['remind_at'] ?? null);
        if ($title === '') {
            Auth::flash($this->message('title_required'), 'danger');
            header('Location: /sales');
            exit;
        }
        if ($remindAt === null) {
            Auth::flash($this->message('date_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $stmt = DB::prepare("INSERT INTO crm_reminders (company_id, contact_id, lead_id, deal_id, activity_id, user_id, title, remind_at, status, channel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['contact_id'] ?? 0) ?: null,
            (int)($_POST['lead_id'] ?? 0) ?: null,
            (int)($_POST['deal_id'] ?? 0) ?: null,
            (int)($_POST['activity_id'] ?? 0) ?: null,
            (int)($_POST['user_id'] ?? 0) ?: null,
            $title,
            $remindAt,
            trim((string)($_POST['channel'] ?? 'in_app')) ?: 'in_app',
        ]);

        Auth::logAction('create', 'crm_reminder', (int)DB::lastInsertId());
        Auth::flash($this->message('reminder_created'), 'success');
        header('Location: /sales/calendar');
        exit;
    }

    public function completeReminder($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $id = (int)($params['id'] ?? 0);
        $stmt = DB::prepare("UPDATE crm_reminders SET status = 'done' WHERE id = ?");
        $stmt->execute([$id]);

        Auth::logAction('update', 'crm_reminder', $id);
        Auth::flash($this->message('reminder_completed'), 'success');
        header('Location: /sales/calendar');
        exit;
    }

    public function storeQuote($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $issueDate = $this->nullableDate($_POST['issue_date'] ?? null);
        $lines = $this->parseDocumentLines($_POST['document_lines'] ?? ($_POST['lines'] ?? ''));
        if ($issueDate === null) {
            Auth::flash($this->message('date_required'), 'danger');
            header('Location: /sales');
            exit;
        }
        if (empty($lines)) {
            Auth::flash($this->message('lines_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $totals = $this->calculateTotals($lines);
        $quoteNumber = trim((string)($_POST['quote_number'] ?? '')) ?: $this->nextDocumentNumber('crm_quotes', 'Q');
        $stmt = DB::prepare("INSERT INTO crm_quotes (company_id, contact_id, deal_id, quote_number, status, issue_date, expiry_date, currency, subtotal, tax_total, total, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['contact_id'] ?? 0) ?: null,
            (int)($_POST['deal_id'] ?? 0) ?: null,
            $quoteNumber,
            in_array((string)($_POST['status'] ?? 'draft'), $this->quoteStatuses(), true) ? (string)$_POST['status'] : 'draft',
            $issueDate,
            $this->nullableDate($_POST['expiry_date'] ?? null),
            trim((string)($_POST['currency'] ?? 'EUR')) ?: 'EUR',
            $totals['subtotal'],
            $totals['tax_total'],
            $totals['total'],
            trim((string)($_POST['notes'] ?? '')) ?: null,
        ]);

        $quoteId = (int)DB::lastInsertId();
        $lineStmt = DB::prepare("INSERT INTO crm_quote_lines (quote_id, description, quantity, unit_price, tax_rate, line_total, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($lines as $line) {
            $lineStmt->execute([$quoteId, $line['description'], $line['quantity'], $line['unit_price'], $line['tax_rate'], $line['line_total'], $line['sort_order']]);
        }

        Auth::logAction('create', 'crm_quote', $quoteId);
        Auth::flash($this->message('quote_created'), 'success');
        header('Location: /sales/quotes/' . $quoteId . '/pdf');
        exit;
    }

    public function storeInvoice($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $issueDate = $this->nullableDate($_POST['issue_date'] ?? null);
        $lines = $this->parseDocumentLines($_POST['document_lines'] ?? ($_POST['lines'] ?? ''));
        if ($issueDate === null) {
            Auth::flash($this->message('date_required'), 'danger');
            header('Location: /sales');
            exit;
        }
        if (empty($lines)) {
            Auth::flash($this->message('lines_required'), 'danger');
            header('Location: /sales');
            exit;
        }

        $totals = $this->calculateTotals($lines);
        $invoiceNumber = trim((string)($_POST['invoice_number'] ?? '')) ?: $this->nextDocumentNumber('crm_invoices', 'INV');
        $stmt = DB::prepare("INSERT INTO crm_invoices (company_id, contact_id, deal_id, invoice_number, status, issue_date, due_date, currency, subtotal, tax_total, total, paid_total, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['contact_id'] ?? 0) ?: null,
            (int)($_POST['deal_id'] ?? 0) ?: null,
            $invoiceNumber,
            in_array((string)($_POST['status'] ?? 'draft'), $this->invoiceStatuses(), true) ? (string)$_POST['status'] : 'draft',
            $issueDate,
            $this->nullableDate($_POST['due_date'] ?? null),
            trim((string)($_POST['currency'] ?? 'EUR')) ?: 'EUR',
            $totals['subtotal'],
            $totals['tax_total'],
            $totals['total'],
            max(0, $this->parseAmount($_POST['paid_total'] ?? 0)),
            trim((string)($_POST['notes'] ?? '')) ?: null,
        ]);

        $invoiceId = (int)DB::lastInsertId();
        $lineStmt = DB::prepare("INSERT INTO crm_invoice_lines (invoice_id, description, quantity, unit_price, tax_rate, line_total, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($lines as $line) {
            $lineStmt->execute([$invoiceId, $line['description'], $line['quantity'], $line['unit_price'], $line['tax_rate'], $line['line_total'], $line['sort_order']]);
        }

        Auth::logAction('create', 'crm_invoice', $invoiceId);
        Auth::flash($this->message('invoice_created'), 'success');
        header('Location: /sales/invoices/' . $invoiceId . '/pdf');
        exit;
    }

    public function updateQuote($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $quoteId = (int)($params['id'] ?? 0);
        $existing = $this->loadQuoteDocument($quoteId);
        if ($existing === null) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        $issueDate = $this->nullableDate($_POST['issue_date'] ?? null);
        $lines = $this->parseDocumentLines($_POST['document_lines'] ?? ($_POST['lines'] ?? ''));
        if ($issueDate === null) {
            Auth::flash($this->message('date_required'), 'danger');
            header('Location: /sales/quotes/' . $quoteId . '/edit');
            exit;
        }
        if (empty($lines)) {
            Auth::flash($this->message('lines_required'), 'danger');
            header('Location: /sales/quotes/' . $quoteId . '/edit');
            exit;
        }

        $totals = $this->calculateTotals($lines);
        $quoteNumber = trim((string)($_POST['quote_number'] ?? '')) ?: (string)($existing['quote_number'] ?? '');
        $stmt = DB::prepare("UPDATE crm_quotes SET company_id = ?, contact_id = ?, deal_id = ?, quote_number = ?, status = ?, issue_date = ?, expiry_date = ?, currency = ?, subtotal = ?, tax_total = ?, total = ?, notes = ? WHERE id = ?");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['contact_id'] ?? 0) ?: null,
            (int)($_POST['deal_id'] ?? 0) ?: null,
            $quoteNumber,
            in_array((string)($_POST['status'] ?? 'draft'), $this->quoteStatuses(), true) ? (string)$_POST['status'] : 'draft',
            $issueDate,
            $this->nullableDate($_POST['expiry_date'] ?? null),
            trim((string)($_POST['currency'] ?? 'EUR')) ?: 'EUR',
            $totals['subtotal'],
            $totals['tax_total'],
            $totals['total'],
            trim((string)($_POST['notes'] ?? '')) ?: null,
            $quoteId,
        ]);

        DB::prepare("DELETE FROM crm_quote_lines WHERE quote_id = ?")->execute([$quoteId]);
        $lineStmt = DB::prepare("INSERT INTO crm_quote_lines (quote_id, description, quantity, unit_price, tax_rate, line_total, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($lines as $line) {
            $lineStmt->execute([$quoteId, $line['description'], $line['quantity'], $line['unit_price'], $line['tax_rate'], $line['line_total'], $line['sort_order']]);
        }

        Auth::logAction('update', 'crm_quote', $quoteId);
        Auth::flash($this->message('quote_updated'), 'success');
        header('Location: /sales/quotes/' . $quoteId . '/pdf');
        exit;
    }

    public function updateInvoice($params = []): void {
        $this->authorizeManage();
        $this->ensureSchema();
        $this->requireCsrf();

        $invoiceId = (int)($params['id'] ?? 0);
        $existing = $this->loadInvoiceDocument($invoiceId);
        if ($existing === null) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            exit;
        }

        $issueDate = $this->nullableDate($_POST['issue_date'] ?? null);
        $lines = $this->parseDocumentLines($_POST['document_lines'] ?? ($_POST['lines'] ?? ''));
        if ($issueDate === null) {
            Auth::flash($this->message('date_required'), 'danger');
            header('Location: /sales/invoices/' . $invoiceId . '/edit');
            exit;
        }
        if (empty($lines)) {
            Auth::flash($this->message('lines_required'), 'danger');
            header('Location: /sales/invoices/' . $invoiceId . '/edit');
            exit;
        }

        $totals = $this->calculateTotals($lines);
        $invoiceNumber = trim((string)($_POST['invoice_number'] ?? '')) ?: (string)($existing['invoice_number'] ?? '');
        $stmt = DB::prepare("UPDATE crm_invoices SET company_id = ?, contact_id = ?, deal_id = ?, invoice_number = ?, status = ?, issue_date = ?, due_date = ?, currency = ?, subtotal = ?, tax_total = ?, total = ?, paid_total = ?, notes = ? WHERE id = ?");
        $stmt->execute([
            (int)($_POST['company_id'] ?? 0) ?: null,
            (int)($_POST['contact_id'] ?? 0) ?: null,
            (int)($_POST['deal_id'] ?? 0) ?: null,
            $invoiceNumber,
            in_array((string)($_POST['status'] ?? 'draft'), $this->invoiceStatuses(), true) ? (string)$_POST['status'] : 'draft',
            $issueDate,
            $this->nullableDate($_POST['due_date'] ?? null),
            trim((string)($_POST['currency'] ?? 'EUR')) ?: 'EUR',
            $totals['subtotal'],
            $totals['tax_total'],
            $totals['total'],
            max(0, $this->parseAmount($_POST['paid_total'] ?? 0)),
            trim((string)($_POST['notes'] ?? '')) ?: null,
            $invoiceId,
        ]);

        DB::prepare("DELETE FROM crm_invoice_lines WHERE invoice_id = ?")->execute([$invoiceId]);
        $lineStmt = DB::prepare("INSERT INTO crm_invoice_lines (invoice_id, description, quantity, unit_price, tax_rate, line_total, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($lines as $line) {
            $lineStmt->execute([$invoiceId, $line['description'], $line['quantity'], $line['unit_price'], $line['tax_rate'], $line['line_total'], $line['sort_order']]);
        }

        Auth::logAction('update', 'crm_invoice', $invoiceId);
        Auth::flash($this->message('invoice_updated'), 'success');
        header('Location: /sales/invoices/' . $invoiceId . '/pdf');
        exit;
    }
}
