-- Schema SQL iniziale per CoreSuite Lite

-- Creazione database (esegui manualmente o tramite script)
-- CREATE DATABASE coresuite_lite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE coresuite_lite;

-- Tabella utenti
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'operator', 'customer') NOT NULL DEFAULT 'customer',
    status ENUM('active', 'suspended') NOT NULL DEFAULT 'active',
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per users
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_status ON users(status);

-- Tabella password_resets
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per password_resets
CREATE INDEX idx_password_resets_token ON password_resets(token_hash);
CREATE INDEX idx_password_resets_expires ON password_resets(expires_at);

-- Tabella remember_tokens
CREATE TABLE remember_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_used_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per remember_tokens
CREATE INDEX idx_remember_tokens_token ON remember_tokens(token_hash);
CREATE INDEX idx_remember_tokens_expires ON remember_tokens(expires_at);

-- Tabella tickets
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    assigned_to INT NULL,
    category VARCHAR(100) NOT NULL,
    subject VARCHAR(255),
    status ENUM('open', 'in_progress', 'resolved', 'closed') NOT NULL DEFAULT 'open',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per tickets
CREATE INDEX idx_tickets_customer ON tickets(customer_id);
CREATE INDEX idx_tickets_assigned ON tickets(assigned_to);
CREATE INDEX idx_tickets_status ON tickets(status);
CREATE INDEX idx_tickets_created ON tickets(created_at);

-- Tabella ticket_comments
CREATE TABLE ticket_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    author_id INT NOT NULL,
    body TEXT NOT NULL,
    visibility ENUM('public', 'internal') NOT NULL DEFAULT 'public',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per ticket_comments
CREATE INDEX idx_ticket_comments_ticket ON ticket_comments(ticket_id);
CREATE INDEX idx_ticket_comments_author ON ticket_comments(author_id);
CREATE INDEX idx_ticket_comments_visibility ON ticket_comments(visibility);

-- Tabella documents
CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    filename_original VARCHAR(255) NOT NULL,
    filename_storage VARCHAR(255) UNIQUE NOT NULL,
    mime VARCHAR(100) NOT NULL,
    size INT NOT NULL,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per documents
CREATE INDEX idx_documents_customer ON documents(customer_id);
CREATE INDEX idx_documents_uploaded_by ON documents(uploaded_by);
CREATE INDEX idx_documents_created ON documents(created_at);

-- Tabella audit_logs
CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    actor_id INT NULL,
    action VARCHAR(255) NOT NULL,
    entity VARCHAR(100) NOT NULL,
    entity_id INT NULL,
    ip VARCHAR(45) NOT NULL,
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (actor_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indici per audit_logs
CREATE INDEX idx_audit_logs_actor ON audit_logs(actor_id);
CREATE INDEX idx_audit_logs_entity ON audit_logs(entity, entity_id);
CREATE INDEX idx_audit_logs_created ON audit_logs(created_at);

-- Tabella projects
CREATE TABLE projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NULL,
    owner_id INT UNSIGNED NULL,
    name VARCHAR(180) NOT NULL,
    code VARCHAR(40) NOT NULL,
    status VARCHAR(32) NOT NULL DEFAULT 'planning',
    priority VARCHAR(24) NOT NULL DEFAULT 'medium',
    health VARCHAR(24) NOT NULL DEFAULT 'on_track',
    progress TINYINT UNSIGNED NOT NULL DEFAULT 0,
    budget DECIMAL(12,2) NULL DEFAULT NULL,
    start_date DATE NULL DEFAULT NULL,
    due_date DATE NULL DEFAULT NULL,
    description TEXT NULL,
    tags VARCHAR(255) NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_projects_code (code),
    KEY idx_projects_status (status),
    KEY idx_projects_priority (priority),
    KEY idx_projects_customer (customer_id),
    KEY idx_projects_owner (owner_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella project_milestones
CREATE TABLE project_milestones (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    title VARCHAR(180) NOT NULL,
    status VARCHAR(24) NOT NULL DEFAULT 'planned',
    due_date DATE NULL DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_project_milestones_project (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella project_tasks
CREATE TABLE project_tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    milestone_id INT UNSIGNED NULL DEFAULT NULL,
    title VARCHAR(180) NOT NULL,
    status VARCHAR(24) NOT NULL DEFAULT 'todo',
    priority VARCHAR(24) NOT NULL DEFAULT 'medium',
    assignee_id INT UNSIGNED NULL DEFAULT NULL,
    due_date DATE NULL DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_project_tasks_project (project_id),
    KEY idx_project_tasks_milestone (milestone_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_companies
CREATE TABLE crm_companies (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_contacts
CREATE TABLE crm_contacts (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_leads
CREATE TABLE crm_leads (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_deals
CREATE TABLE crm_deals (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_activities
CREATE TABLE crm_activities (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_reminders
CREATE TABLE crm_reminders (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_quotes
CREATE TABLE crm_quotes (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_quote_lines
CREATE TABLE crm_quote_lines (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quote_id INT UNSIGNED NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0,
    line_total DECIMAL(12,2) NOT NULL DEFAULT 0,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    KEY idx_crm_quote_lines_quote (quote_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_invoices
CREATE TABLE crm_invoices (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella crm_invoice_lines
CREATE TABLE crm_invoice_lines (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT UNSIGNED NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0,
    line_total DECIMAL(12,2) NOT NULL DEFAULT 0,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    KEY idx_crm_invoice_lines_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabella document_metadata
CREATE TABLE document_metadata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    description TEXT NULL,
    tags JSON NULL,
    uploaded_by INT NULL,
    uploaded_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_document_metadata_document ON document_metadata(document_id);

-- Tabella ticket_attachments
CREATE TABLE ticket_attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    stored_name VARCHAR(255) NOT NULL,
    uploaded_by INT NULL,
    uploaded_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_ticket_attachments_ticket ON ticket_attachments(ticket_id);
