<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

class RolesController {
    private function authorizeAdmin() {
        if (!Auth::isAdmin()) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    public function index($params = []) {
        $this->authorizeAdmin();

        $permissions = RolePermissions::all();
        $permissionDictionary = [
            'it' => [
                'sales_view' => ['label' => 'Vista sales CRM', 'meta' => 'Accesso al cockpit commerciale con aziende, lead e deal'],
                'sales_manage' => ['label' => 'Gestione sales CRM', 'meta' => 'Creazione e aggiornamento di aziende, contatti, lead, deal e attivita'],
                'sales_pipeline_view' => ['label' => 'Vista pipeline', 'meta' => 'Accesso alla board commerciale per stage'],
                'sales_calendar_view' => ['label' => 'Vista calendario sales', 'meta' => 'Accesso ad agenda, appuntamenti e reminder commerciali'],
                'quotes_view' => ['label' => 'Vista preventivi', 'meta' => 'Accesso ai preventivi nativi del modulo commerciale'],
                'quotes_manage' => ['label' => 'Gestione preventivi', 'meta' => 'Creazione e aggiornamento dei preventivi'],
                'invoices_view' => ['label' => 'Vista fatture', 'meta' => 'Accesso alle fatture del modulo commerciale'],
                'invoices_manage' => ['label' => 'Gestione fatture', 'meta' => 'Creazione e aggiornamento delle fatture native'],
                'projects_view' => ['label' => 'Vista progetti', 'meta' => 'Accesso a portfolio, board e workspace progetto'],
                'projects_manage' => ['label' => 'Gestione progetti', 'meta' => 'Creazione e aggiornamento del modulo progetti'],
                'tickets_view' => ['label' => 'Vista ticket', 'meta' => 'Accesso alla lista e ai dettagli ticket'],
                'tickets_create' => ['label' => 'Creazione ticket', 'meta' => 'Possibilita di aprire nuove richieste'],
                'tickets_manage' => ['label' => 'Gestione ticket', 'meta' => 'Cambio stato, assegnazione e controllo operativo'],
                'documents_view' => ['label' => 'Vista documenti', 'meta' => 'Accesso ad archivio e download documenti'],
                'documents_upload' => ['label' => 'Upload documenti', 'meta' => 'Caricamento documenti nel workspace'],
                'customers_view' => ['label' => 'Vista clienti', 'meta' => 'Accesso a lista clienti e customer workspace'],
                'reports_view' => ['label' => 'Vista report', 'meta' => 'Accesso al modulo reportistica'],
                'audit_logs_view' => ['label' => 'Vista audit logs', 'meta' => 'Accesso al centro audit'],
                'users_manage' => ['label' => 'Gestione utenti', 'meta' => 'Gestione utenti amministrativa'],
                'workspace_settings_view' => ['label' => 'Workspace settings', 'meta' => 'Configurazione shell e workspace'],
                'notification_settings_view' => ['label' => 'Notification settings', 'meta' => 'Governance inbox ed email strategy'],
                'roles_permissions_view' => ['label' => 'Ruoli e permessi', 'meta' => 'Accesso alla matrice ruoli e permessi'],
            ],
            'en' => [
                'sales_view' => ['label' => 'Sales CRM view', 'meta' => 'Access to the commercial cockpit with companies, leads, and deals'],
                'sales_manage' => ['label' => 'Sales CRM manage', 'meta' => 'Create and update companies, contacts, leads, deals, and activities'],
                'sales_pipeline_view' => ['label' => 'Pipeline view', 'meta' => 'Access to the commercial stage board'],
                'sales_calendar_view' => ['label' => 'Sales calendar view', 'meta' => 'Access to agenda, appointments, and sales reminders'],
                'quotes_view' => ['label' => 'Quotes view', 'meta' => 'Access native quotes in the commercial module'],
                'quotes_manage' => ['label' => 'Quotes manage', 'meta' => 'Create and update quotes'],
                'invoices_view' => ['label' => 'Invoices view', 'meta' => 'Access invoices in the commercial module'],
                'invoices_manage' => ['label' => 'Invoices manage', 'meta' => 'Create and update native invoices'],
                'projects_view' => ['label' => 'Projects view', 'meta' => 'Access to portfolio, board, and project workspace'],
                'projects_manage' => ['label' => 'Projects manage', 'meta' => 'Create and update the projects module'],
                'tickets_view' => ['label' => 'Tickets view', 'meta' => 'Access to ticket list and detail pages'],
                'tickets_create' => ['label' => 'Tickets create', 'meta' => 'Ability to open new requests'],
                'tickets_manage' => ['label' => 'Tickets manage', 'meta' => 'Status changes, assignment, and operational control'],
                'documents_view' => ['label' => 'Documents view', 'meta' => 'Access to archive and document downloads'],
                'documents_upload' => ['label' => 'Documents upload', 'meta' => 'Upload documents into the workspace'],
                'customers_view' => ['label' => 'Customers view', 'meta' => 'Access to customer list and customer workspace'],
                'reports_view' => ['label' => 'Reports view', 'meta' => 'Access to reporting module'],
                'audit_logs_view' => ['label' => 'Audit logs view', 'meta' => 'Access to audit center'],
                'users_manage' => ['label' => 'Users manage', 'meta' => 'Administrative user management'],
                'workspace_settings_view' => ['label' => 'Workspace settings', 'meta' => 'Shell and workspace configuration'],
                'notification_settings_view' => ['label' => 'Notification settings', 'meta' => 'Inbox and email strategy governance'],
                'roles_permissions_view' => ['label' => 'Roles permissions', 'meta' => 'Access to roles and permissions matrix'],
            ],
            'fr' => [
                'sales_view' => ['label' => 'Vue sales CRM', 'meta' => 'Acces au cockpit commercial avec societes, leads et deals'],
                'sales_manage' => ['label' => 'Gestion sales CRM', 'meta' => 'Creation et mise a jour des societes, contacts, leads, deals et activites'],
                'sales_pipeline_view' => ['label' => 'Vue pipeline', 'meta' => 'Acces a la board commerciale par etape'],
                'sales_calendar_view' => ['label' => 'Vue calendrier sales', 'meta' => 'Acces a l agenda, aux rendez-vous et rappels commerciaux'],
                'quotes_view' => ['label' => 'Vue devis', 'meta' => 'Acces aux devis natifs du module commercial'],
                'quotes_manage' => ['label' => 'Gestion devis', 'meta' => 'Creation et mise a jour des devis'],
                'invoices_view' => ['label' => 'Vue factures', 'meta' => 'Acces aux factures du module commercial'],
                'invoices_manage' => ['label' => 'Gestion factures', 'meta' => 'Creation et mise a jour des factures natives'],
                'projects_view' => ['label' => 'Vue projets', 'meta' => 'Acces au portefeuille, board et workspace projet'],
                'projects_manage' => ['label' => 'Gestion projets', 'meta' => 'Creation et mise a jour du module projets'],
                'tickets_view' => ['label' => 'Vue tickets', 'meta' => 'Acces a la liste et aux details des tickets'],
                'tickets_create' => ['label' => 'Creation tickets', 'meta' => 'Possibilite d ouvrir de nouvelles demandes'],
                'tickets_manage' => ['label' => 'Gestion tickets', 'meta' => 'Changement de statut, attribution et controle operationnel'],
                'documents_view' => ['label' => 'Vue documents', 'meta' => 'Acces aux archives et au telechargement des documents'],
                'documents_upload' => ['label' => 'Upload documents', 'meta' => 'Televersement de documents dans le workspace'],
                'customers_view' => ['label' => 'Vue clients', 'meta' => 'Acces a la liste clients et au customer workspace'],
                'reports_view' => ['label' => 'Vue rapports', 'meta' => 'Acces au module reporting'],
                'audit_logs_view' => ['label' => 'Vue audit logs', 'meta' => 'Acces au centre d audit'],
                'users_manage' => ['label' => 'Gestion utilisateurs', 'meta' => 'Gestion administrative des utilisateurs'],
                'workspace_settings_view' => ['label' => 'Workspace settings', 'meta' => 'Configuration de la shell et du workspace'],
                'notification_settings_view' => ['label' => 'Notification settings', 'meta' => 'Gouvernance de l inbox et de la strategie email'],
                'roles_permissions_view' => ['label' => 'Roles et permissions', 'meta' => 'Acces a la matrice roles et permissions'],
            ],
            'es' => [
                'sales_view' => ['label' => 'Vista sales CRM', 'meta' => 'Acceso al cockpit comercial con empresas, leads y deals'],
                'sales_manage' => ['label' => 'Gestion sales CRM', 'meta' => 'Creacion y actualizacion de empresas, contactos, leads, deals y actividades'],
                'sales_pipeline_view' => ['label' => 'Vista pipeline', 'meta' => 'Acceso a la board comercial por etapas'],
                'sales_calendar_view' => ['label' => 'Vista calendario sales', 'meta' => 'Acceso a agenda, citas y recordatorios comerciales'],
                'quotes_view' => ['label' => 'Vista presupuestos', 'meta' => 'Acceso a presupuestos nativos del modulo comercial'],
                'quotes_manage' => ['label' => 'Gestion presupuestos', 'meta' => 'Creacion y actualizacion de presupuestos'],
                'invoices_view' => ['label' => 'Vista facturas', 'meta' => 'Acceso a las facturas del modulo comercial'],
                'invoices_manage' => ['label' => 'Gestion facturas', 'meta' => 'Creacion y actualizacion de facturas nativas'],
                'projects_view' => ['label' => 'Vista proyectos', 'meta' => 'Acceso a portfolio, board y workspace de proyecto'],
                'projects_manage' => ['label' => 'Gestion proyectos', 'meta' => 'Creacion y actualizacion del modulo proyectos'],
                'tickets_view' => ['label' => 'Vista tickets', 'meta' => 'Acceso a la lista y al detalle de tickets'],
                'tickets_create' => ['label' => 'Creacion tickets', 'meta' => 'Posibilidad de abrir nuevas solicitudes'],
                'tickets_manage' => ['label' => 'Gestion tickets', 'meta' => 'Cambio de estado, asignacion y control operativo'],
                'documents_view' => ['label' => 'Vista documentos', 'meta' => 'Acceso a archivo y descarga de documentos'],
                'documents_upload' => ['label' => 'Carga documentos', 'meta' => 'Carga de documentos en el workspace'],
                'customers_view' => ['label' => 'Vista clientes', 'meta' => 'Acceso a lista de clientes y customer workspace'],
                'reports_view' => ['label' => 'Vista reportes', 'meta' => 'Acceso al modulo de reportes'],
                'audit_logs_view' => ['label' => 'Vista audit logs', 'meta' => 'Acceso al centro de auditoria'],
                'users_manage' => ['label' => 'Gestion usuarios', 'meta' => 'Gestion administrativa de usuarios'],
                'workspace_settings_view' => ['label' => 'Workspace settings', 'meta' => 'Configuracion de shell y workspace'],
                'notification_settings_view' => ['label' => 'Notification settings', 'meta' => 'Gobernanza de inbox y estrategia email'],
                'roles_permissions_view' => ['label' => 'Roles y permisos', 'meta' => 'Acceso a la matriz de roles y permisos'],
            ],
        ];
        $permissionLabels = $permissionDictionary[Locale::current()] ?? $permissionDictionary['it'];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 6;
        $totalPermissions = count($permissionLabels);
        $totalPages = max(1, (int)ceil($totalPermissions / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;
        $permissionLabels = array_slice($permissionLabels, $offset, $perPage, true);

        include __DIR__ . '/../Views/roles_permissions.php';
    }

    public function update($params = []) {
        $this->authorizeAdmin();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /admin/roles-permissions');
            exit;
        }

        $permissions = RolePermissions::save($_POST);
        Auth::logAction('update', 'role_permissions', 1);
        Auth::flash(Locale::runtime('roles_permissions_updated'), 'success');
        header('Location: /admin/roles-permissions');
        exit;
    }
}
