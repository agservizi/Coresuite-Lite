<?php
use Core\Locale;

$isEdit = isset($user) && !empty($user['id']);
$adminUserFormText = [
    'it' => [
        'page_title_edit' => 'Modifica Utente',
        'page_title_create' => 'Nuovo Utente',
        'eyebrow_edit' => 'Edit user',
        'eyebrow_create' => 'Create user',
        'title_edit' => 'Aggiorna dati, ruolo e stato account',
        'title_create' => 'Crea un nuovo utente pronto all uso',
        'lead' => 'Configura accesso, ruolo operativo e dati di contatto mantenendo coerenza con tutta l area amministrativa.',
        'back' => 'Torna alla lista',
        'meta_access' => 'Access governance',
        'meta_role' => 'Role-based',
        'meta_security' => 'Secure onboarding',
        'step_1_title' => 'Anagrafica',
        'step_1_subtitle' => 'Nome e contatti',
        'step_2_title' => 'Accesso',
        'step_2_subtitle' => 'Password e ruolo',
        'step_3_title' => 'Governance',
        'step_3_subtitle' => 'Stato account',
        'card_eyebrow' => 'User form',
        'card_title_edit' => 'Modifica dati utente',
        'card_title_create' => 'Crea nuovo utente',
        'status_primary_edit' => 'Account update',
        'status_primary_create' => 'New account',
        'status_secondary_edit' => 'Controlled edit',
        'status_secondary_create' => 'Onboarding',
        'section_1_title' => 'Definisci identita e recapiti',
        'section_1_lead' => 'Questa base serve a rendere l utente riconoscibile in tutta la suite e nei flussi operativi.',
        'name' => 'Nome',
        'email' => 'Email',
        'password' => 'Password',
        'password_edit_hint' => '(lascia vuoto per non modificarla)',
        'phone' => 'Telefono',
        'phone_placeholder' => '+39 ...',
        'section_2_title' => 'Imposta accesso e perimetro operativo',
        'section_2_lead' => 'Ruolo e credenziali determinano cosa l utente potra vedere e fare nella piattaforma.',
        'role' => 'Ruolo',
        'role_admin' => 'Admin',
        'role_operator' => 'Operator',
        'role_customer' => 'Customer',
        'status' => 'Stato',
        'status_active' => 'Attivo',
        'status_suspended' => 'Sospeso',
        'save' => 'Salva',
        'cancel' => 'Annulla',
        'summary_eyebrow' => 'Governance summary',
        'summary_title' => 'Impatto della configurazione',
        'access' => 'Access',
        'access_edit' => 'Revised',
        'access_create' => 'Provisioned',
        'control' => 'Control',
        'control_value' => 'Role based',
        'summary_role' => 'Ruolo',
        'summary_role_value' => 'Definisce permessi e aree accessibili',
        'summary_password' => 'Password',
        'summary_password_edit' => 'Lascia vuoto per mantenerla invariata',
        'summary_password_create' => 'Serve per il primo accesso',
        'summary_status' => 'Stato',
        'summary_status_value' => 'Controlla l accesso immediato all account',
        'guidelines_eyebrow' => 'Guidelines',
        'guidelines_title' => 'Buone pratiche',
        'tip_role' => 'Assegna il ruolo minimo necessario.',
        'tip_password' => 'In modifica, cambia password solo quando serve.',
        'tip_suspend' => 'Usa lo stato sospeso per blocchi temporanei.',
        'note_eyebrow' => 'Admin note',
        'note_title' => 'Strategia consigliata',
        'least_privilege' => 'Least privilege',
        'least_privilege_value' => 'Apri con il ruolo minimo necessario e amplia solo se emerge un bisogno reale.',
        'account_state' => 'Account state',
        'account_state_value' => 'Usa `sospeso` come controllo temporaneo senza perdere storico e ownership.',
    ],
    'en' => [
        'page_title_edit' => 'Edit User',
        'page_title_create' => 'New User',
        'eyebrow_edit' => 'Edit user',
        'eyebrow_create' => 'Create user',
        'title_edit' => 'Update account details, role, and status',
        'title_create' => 'Create a new ready-to-use user',
        'lead' => 'Configure access, operational role, and contact details while staying consistent with the whole admin area.',
        'back' => 'Back to list',
        'meta_access' => 'Access governance',
        'meta_role' => 'Role-based',
        'meta_security' => 'Secure onboarding',
        'step_1_title' => 'Identity',
        'step_1_subtitle' => 'Name and contacts',
        'step_2_title' => 'Access',
        'step_2_subtitle' => 'Password and role',
        'step_3_title' => 'Governance',
        'step_3_subtitle' => 'Account status',
        'card_eyebrow' => 'User form',
        'card_title_edit' => 'Edit user details',
        'card_title_create' => 'Create new user',
        'status_primary_edit' => 'Account update',
        'status_primary_create' => 'New account',
        'status_secondary_edit' => 'Controlled edit',
        'status_secondary_create' => 'Onboarding',
        'section_1_title' => 'Define identity and contacts',
        'section_1_lead' => 'This base makes the user recognizable across the suite and workflows.',
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'password_edit_hint' => '(leave blank to keep unchanged)',
        'phone' => 'Phone',
        'phone_placeholder' => '+1 ...',
        'section_2_title' => 'Set access and operational scope',
        'section_2_lead' => 'Role and credentials determine what the user can see and do on the platform.',
        'role' => 'Role',
        'role_admin' => 'Admin',
        'role_operator' => 'Operator',
        'role_customer' => 'Customer',
        'status' => 'Status',
        'status_active' => 'Active',
        'status_suspended' => 'Suspended',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'summary_eyebrow' => 'Governance summary',
        'summary_title' => 'Configuration impact',
        'access' => 'Access',
        'access_edit' => 'Revised',
        'access_create' => 'Provisioned',
        'control' => 'Control',
        'control_value' => 'Role based',
        'summary_role' => 'Role',
        'summary_role_value' => 'Defines permissions and accessible areas',
        'summary_password' => 'Password',
        'summary_password_edit' => 'Leave blank to keep it unchanged',
        'summary_password_create' => 'Required for the first login',
        'summary_status' => 'Status',
        'summary_status_value' => 'Controls immediate account access',
        'guidelines_eyebrow' => 'Guidelines',
        'guidelines_title' => 'Best practices',
        'tip_role' => 'Assign the minimum required role.',
        'tip_password' => 'When editing, change the password only when needed.',
        'tip_suspend' => 'Use suspended status for temporary blocks.',
        'note_eyebrow' => 'Admin note',
        'note_title' => 'Recommended strategy',
        'least_privilege' => 'Least privilege',
        'least_privilege_value' => 'Start with the minimum role required and expand only if a real need appears.',
        'account_state' => 'Account state',
        'account_state_value' => 'Use `suspended` as a temporary control without losing history and ownership.',
    ],
    'fr' => [
        'page_title_edit' => 'Modifier utilisateur',
        'page_title_create' => 'Nouvel utilisateur',
        'eyebrow_edit' => 'Modifier utilisateur',
        'eyebrow_create' => 'Creer utilisateur',
        'title_edit' => 'Mettre a jour les donnees, le role et le statut du compte',
        'title_create' => 'Creer un nouvel utilisateur pret a l emploi',
        'lead' => 'Configurez acces, role operationnel et coordonnees en gardant la coherence avec toute la zone d administration.',
        'back' => 'Retour a la liste',
        'meta_access' => 'Gouvernance acces',
        'meta_role' => 'Base sur les roles',
        'meta_security' => 'Onboarding securise',
        'step_1_title' => 'Identite',
        'step_1_subtitle' => 'Nom et contacts',
        'step_2_title' => 'Acces',
        'step_2_subtitle' => 'Mot de passe et role',
        'step_3_title' => 'Gouvernance',
        'step_3_subtitle' => 'Statut du compte',
        'card_eyebrow' => 'Formulaire utilisateur',
        'card_title_edit' => 'Modifier les donnees utilisateur',
        'card_title_create' => 'Creer un nouvel utilisateur',
        'status_primary_edit' => 'Mise a jour compte',
        'status_primary_create' => 'Nouveau compte',
        'status_secondary_edit' => 'Edition controlee',
        'status_secondary_create' => 'Onboarding',
        'section_1_title' => 'Definir identite et contacts',
        'section_1_lead' => 'Cette base rend l utilisateur reconnaissable dans toute la suite et dans les flux operationnels.',
        'name' => 'Nom',
        'email' => 'Email',
        'password' => 'Mot de passe',
        'password_edit_hint' => '(laisser vide pour ne pas le modifier)',
        'phone' => 'Telephone',
        'phone_placeholder' => '+33 ...',
        'section_2_title' => 'Definir acces et perimetre operationnel',
        'section_2_lead' => 'Le role et les identifiants determinent ce que l utilisateur peut voir et faire dans la plateforme.',
        'role' => 'Role',
        'role_admin' => 'Admin',
        'role_operator' => 'Operateur',
        'role_customer' => 'Client',
        'status' => 'Statut',
        'status_active' => 'Actif',
        'status_suspended' => 'Suspendu',
        'save' => 'Enregistrer',
        'cancel' => 'Annuler',
        'summary_eyebrow' => 'Resume gouvernance',
        'summary_title' => 'Impact de la configuration',
        'access' => 'Acces',
        'access_edit' => 'Revu',
        'access_create' => 'Provisionne',
        'control' => 'Controle',
        'control_value' => 'Base sur les roles',
        'summary_role' => 'Role',
        'summary_role_value' => 'Definit permissions et zones accessibles',
        'summary_password' => 'Mot de passe',
        'summary_password_edit' => 'Laisser vide pour le conserver',
        'summary_password_create' => 'Necessaire pour la premiere connexion',
        'summary_status' => 'Statut',
        'summary_status_value' => 'Controle l acces immediat au compte',
        'guidelines_eyebrow' => 'Lignes directrices',
        'guidelines_title' => 'Bonnes pratiques',
        'tip_role' => 'Attribuez le role minimum necessaire.',
        'tip_password' => 'En modification, changez le mot de passe seulement si necessaire.',
        'tip_suspend' => 'Utilisez le statut suspendu pour des blocages temporaires.',
        'note_eyebrow' => 'Note admin',
        'note_title' => 'Strategie recommandee',
        'least_privilege' => 'Moindre privilege',
        'least_privilege_value' => 'Commencez avec le role minimum necessaire et elargissez seulement si un vrai besoin apparait.',
        'account_state' => 'Etat du compte',
        'account_state_value' => 'Utilisez `suspendu` comme controle temporaire sans perdre historique et ownership.',
    ],
    'es' => [
        'page_title_edit' => 'Editar usuario',
        'page_title_create' => 'Nuevo usuario',
        'eyebrow_edit' => 'Editar usuario',
        'eyebrow_create' => 'Crear usuario',
        'title_edit' => 'Actualizar datos, rol y estado de cuenta',
        'title_create' => 'Crear un nuevo usuario listo para usar',
        'lead' => 'Configura acceso, rol operativo y datos de contacto manteniendo coherencia con toda el area administrativa.',
        'back' => 'Volver a la lista',
        'meta_access' => 'Gobernanza de acceso',
        'meta_role' => 'Basado en roles',
        'meta_security' => 'Onboarding seguro',
        'step_1_title' => 'Identidad',
        'step_1_subtitle' => 'Nombre y contactos',
        'step_2_title' => 'Acceso',
        'step_2_subtitle' => 'Contrasena y rol',
        'step_3_title' => 'Gobernanza',
        'step_3_subtitle' => 'Estado de cuenta',
        'card_eyebrow' => 'Formulario de usuario',
        'card_title_edit' => 'Editar datos del usuario',
        'card_title_create' => 'Crear nuevo usuario',
        'status_primary_edit' => 'Actualizacion de cuenta',
        'status_primary_create' => 'Nueva cuenta',
        'status_secondary_edit' => 'Edicion controlada',
        'status_secondary_create' => 'Onboarding',
        'section_1_title' => 'Definir identidad y contactos',
        'section_1_lead' => 'Esta base hace al usuario reconocible en toda la suite y en los flujos operativos.',
        'name' => 'Nombre',
        'email' => 'Email',
        'password' => 'Contrasena',
        'password_edit_hint' => '(dejar vacio para no modificarla)',
        'phone' => 'Telefono',
        'phone_placeholder' => '+34 ...',
        'section_2_title' => 'Definir acceso y perimetro operativo',
        'section_2_lead' => 'Rol y credenciales determinan que podra ver y hacer el usuario en la plataforma.',
        'role' => 'Rol',
        'role_admin' => 'Admin',
        'role_operator' => 'Operador',
        'role_customer' => 'Cliente',
        'status' => 'Estado',
        'status_active' => 'Activo',
        'status_suspended' => 'Suspendido',
        'save' => 'Guardar',
        'cancel' => 'Cancelar',
        'summary_eyebrow' => 'Resumen de gobernanza',
        'summary_title' => 'Impacto de la configuracion',
        'access' => 'Acceso',
        'access_edit' => 'Revisado',
        'access_create' => 'Provisionado',
        'control' => 'Control',
        'control_value' => 'Basado en roles',
        'summary_role' => 'Rol',
        'summary_role_value' => 'Define permisos y areas accesibles',
        'summary_password' => 'Contrasena',
        'summary_password_edit' => 'Dejala vacia para mantenerla',
        'summary_password_create' => 'Necesaria para el primer acceso',
        'summary_status' => 'Estado',
        'summary_status_value' => 'Controla el acceso inmediato a la cuenta',
        'guidelines_eyebrow' => 'Guidelines',
        'guidelines_title' => 'Buenas practicas',
        'tip_role' => 'Asigna el rol minimo necesario.',
        'tip_password' => 'En edicion, cambia la contrasena solo cuando haga falta.',
        'tip_suspend' => 'Usa el estado suspendido para bloqueos temporales.',
        'note_eyebrow' => 'Nota admin',
        'note_title' => 'Estrategia recomendada',
        'least_privilege' => 'Minimo privilegio',
        'least_privilege_value' => 'Empieza con el rol minimo necesario y amplialo solo si aparece una necesidad real.',
        'account_state' => 'Estado de cuenta',
        'account_state_value' => 'Usa `suspendido` como control temporal sin perder historial ni ownership.',
    ],
];

$auft = $adminUserFormText[Locale::current()] ?? $adminUserFormText['it'];
$pageTitle = $isEdit ? $auft['page_title_edit'] : $auft['page_title_create'];
$action = $isEdit ? '/admin/users/' . (int)$user['id'] : '/admin/users';

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($isEdit ? $auft['eyebrow_edit'] : $auft['eyebrow_create']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($isEdit ? $auft['title_edit'] : $auft['title_create']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($auft['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a class="btn btn-outline-secondary" href="/admin/users"><?php echo htmlspecialchars($auft['back']); ?></a>
    </div>
</section>

<div class="admin-form-shell">
    <div class="admin-form-meta mb-3">
        <span class="admin-form-meta__pill"><i class="fas fa-users-gear"></i><?php echo htmlspecialchars($auft['meta_access']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-user-shield"></i><?php echo htmlspecialchars($auft['meta_role']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-lock"></i><?php echo htmlspecialchars($auft['meta_security']); ?></span>
    </div>

    <div class="admin-form-stepper mb-4">
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">1</span>
            <div>
                <strong><?php echo htmlspecialchars($auft['step_1_title']); ?></strong>
                <small><?php echo htmlspecialchars($auft['step_1_subtitle']); ?></small>
            </div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">2</span>
            <div>
                <strong><?php echo htmlspecialchars($auft['step_2_title']); ?></strong>
                <small><?php echo htmlspecialchars($auft['step_2_subtitle']); ?></small>
            </div>
        </div>
        <div class="admin-form-step">
            <span class="admin-form-step__index">3</span>
            <div>
                <strong><?php echo htmlspecialchars($auft['step_3_title']); ?></strong>
                <small><?php echo htmlspecialchars($auft['step_3_subtitle']); ?></small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
        <div class="card admin-form-card">
                <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($auft['card_eyebrow']); ?></p>
                    <span><?php echo htmlspecialchars($isEdit ? $auft['card_title_edit'] : $auft['card_title_create']); ?></span>
                </div>
                <div class="admin-form-card__status">
                    <span class="admin-form-card__status-pill"><?php echo htmlspecialchars($isEdit ? $auft['status_primary_edit'] : $auft['status_primary_create']); ?></span>
                    <span class="admin-form-card__status-pill is-soft"><?php echo htmlspecialchars($isEdit ? $auft['status_secondary_edit'] : $auft['status_secondary_create']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo $action; ?>" class="row g-3">
                    <?php echo CSRF::field(); ?>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 1</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($auft['section_1_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($auft['section_1_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($auft['name']); ?></label>
                        <input class="form-control" type="text" name="name" value="<?php echo htmlspecialchars((string)($user['name'] ?? '')); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($auft['email']); ?></label>
                        <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars((string)($user['email'] ?? '')); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($auft['password']); ?><?php if ($isEdit): ?> <?php echo htmlspecialchars($auft['password_edit_hint']); ?><?php endif; ?></label>
                        <input class="form-control" type="password" name="password" <?php echo !$isEdit ? 'required' : ''; ?> minlength="6">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($auft['phone']); ?></label>
                        <input class="form-control" type="text" name="phone" value="<?php echo htmlspecialchars((string)($user['phone'] ?? '')); ?>" placeholder="<?php echo htmlspecialchars($auft['phone_placeholder']); ?>">
                    </div>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 2</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($auft['section_2_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($auft['section_2_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($auft['role']); ?></label>
                        <select name="role" class="form-select">
                            <option value="admin" <?php echo (($user['role'] ?? '') === 'admin') ? 'selected' : ''; ?>><?php echo htmlspecialchars($auft['role_admin']); ?></option>
                            <option value="operator" <?php echo (($user['role'] ?? '') === 'operator') ? 'selected' : ''; ?>><?php echo htmlspecialchars($auft['role_operator']); ?></option>
                            <option value="customer" <?php echo (($user['role'] ?? 'customer') === 'customer') ? 'selected' : ''; ?>><?php echo htmlspecialchars($auft['role_customer']); ?></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($auft['status']); ?></label>
                        <select name="status" class="form-select">
                            <option value="active" <?php echo (($user['status'] ?? 'active') === 'active') ? 'selected' : ''; ?>><?php echo htmlspecialchars($auft['status_active']); ?></option>
                            <option value="suspended" <?php echo (($user['status'] ?? '') === 'suspended') ? 'selected' : ''; ?>><?php echo htmlspecialchars($auft['status_suspended']); ?></option>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2 flex-wrap">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save me-1"></i><?php echo htmlspecialchars($auft['save']); ?></button>
                        <a class="btn btn-outline-secondary" href="/admin/users"><?php echo htmlspecialchars($auft['cancel']); ?></a>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="col-xl-4">
            <div class="admin-form-sidebar">
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($auft['summary_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($auft['summary_title']); ?></h3>
                        <div class="admin-form-kpis mb-3">
                            <div class="admin-form-kpi">
                                <span><?php echo htmlspecialchars($auft['access']); ?></span>
                                <strong><?php echo htmlspecialchars($isEdit ? $auft['access_edit'] : $auft['access_create']); ?></strong>
                            </div>
                            <div class="admin-form-kpi">
                                <span><?php echo htmlspecialchars($auft['control']); ?></span>
                                <strong><?php echo htmlspecialchars($auft['control_value']); ?></strong>
                            </div>
                        </div>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($auft['summary_role']); ?></span>
                                <strong><?php echo htmlspecialchars($auft['summary_role_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($auft['summary_password']); ?></span>
                                <strong><?php echo htmlspecialchars($isEdit ? $auft['summary_password_edit'] : $auft['summary_password_create']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($auft['summary_status']); ?></span>
                                <strong><?php echo htmlspecialchars($auft['summary_status_value']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($auft['guidelines_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($auft['guidelines_title']); ?></h3>
                        <ul class="dashboard-insights mt-0">
                            <li><i class="fas fa-shield-alt"></i><?php echo htmlspecialchars($auft['tip_role']); ?></li>
                            <li><i class="fas fa-key"></i><?php echo htmlspecialchars($auft['tip_password']); ?></li>
                            <li><i class="fas fa-user-check"></i><?php echo htmlspecialchars($auft['tip_suspend']); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($auft['note_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($auft['note_title']); ?></h3>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($auft['least_privilege']); ?></span>
                                <strong><?php echo htmlspecialchars($auft['least_privilege_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($auft['account_state']); ?></span>
                                <strong><?php echo htmlspecialchars($auft['account_state_value']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layout.php';
