<?php
use Core\Locale;

$workspaceSettingsText = [
    'it' => [
        'page_title' => 'Workspace Settings',
        'eyebrow' => 'Workspace settings',
        'title' => 'Personalizza identita, shell e moduli visibili della suite',
        'lead' => 'Qui governi il naming del workspace, i default della shell e quali moduli amministrativi devono essere esposti nell esperienza quotidiana.',
        'audit_logs' => 'Audit logs',
        'admin_only' => 'Admin only',
        'meta_identity' => 'Workspace identity',
        'meta_shell' => 'Shell defaults',
        'meta_modules' => 'Module visibility',
        'meta_delivery' => 'Mail delivery',
        'step_1_title' => 'Identity',
        'step_1_subtitle' => 'Brand e contesto',
        'step_2_title' => 'Shell',
        'step_2_subtitle' => 'Default visivi',
        'step_3_title' => 'Modules',
        'step_3_subtitle' => 'Visibilita funzioni',
        'card_eyebrow' => 'Governance form',
        'card_title' => 'Impostazioni del workspace',
        'status_primary' => 'Suite control',
        'status_secondary' => 'Persistent',
        'section_1_title' => 'Definisci identita e contesto del workspace',
        'section_1_lead' => 'Questi valori alimentano brand, shell e messaggi amministrativi in tutta la suite.',
        'workspace_name' => 'Workspace name',
        'environment_label' => 'Nome ambiente',
        'support_email' => 'Support email',
        'support_phone' => 'Telefono supporto',
        'legal_name' => 'Ragione sociale',
        'address_line' => 'Indirizzo sede',
        'address_city' => 'Citta',
        'address_zip' => 'CAP',
        'address_country' => 'Paese',
        'vat_number' => 'Partita IVA',
        'tax_code' => 'Codice fiscale',
        'pec_email' => 'PEC',
        'sdi_code' => 'Codice SDI',
        'iban' => 'IBAN',
        'section_mail_title' => 'Configura consegna email e reset password',
        'section_mail_lead' => 'Configura il metodo di invio piu adatto al tuo ambiente. SMTP resta una scelta semplice e compatibile in molti contesti.',
        'app_url' => 'App URL',
        'app_url_help' => 'URL pubblico usato nei link email, ad esempio https://suite.example.com.',
        'mail_driver' => 'Mail driver',
        'mail_driver_disabled' => 'Disabilitato',
        'mail_driver_log' => 'Solo log',
        'mail_driver_smtp' => 'SMTP',
        'mail_driver_resend' => 'Resend',
        'mail_from_name' => 'Nome mittente',
        'mail_from_email' => 'Email mittente',
        'mail_reply_to' => 'Reply-to',
        'smtp_host' => 'SMTP host',
        'smtp_port' => 'SMTP port',
        'smtp_username' => 'SMTP username',
        'smtp_password' => 'SMTP password',
        'smtp_encryption' => 'Cifratura SMTP',
        'smtp_timeout' => 'SMTP timeout',
        'smtp_auth_enabled' => 'Richiedi autenticazione SMTP',
        'resend_api_key' => 'Resend API key',
        'secret_hint' => 'Lascia vuoto per mantenere il segreto gia salvato.',
        'mail_test_recipient' => 'Destinatario test email',
        'mail_test_recipient_help' => 'Se vuoto usa la support email o l email del tuo account admin.',
        'send_test' => 'Invia email di test',
        'mail_status_title' => 'Stato consegna email',
        'mail_status_driver' => 'Driver',
        'mail_status_sender' => 'Mittente',
        'mail_status_reply_to' => 'Reply-to',
        'mail_status_configured' => 'Configurato',
        'mail_status_pending' => 'Da completare',
        'default_theme' => 'Default theme',
        'theme_system' => 'System',
        'theme_light' => 'Light',
        'theme_dark' => 'Dark',
        'section_2_title' => 'Imposta i default della shell',
        'section_2_lead' => 'Queste preferenze guidano l esperienza iniziale per chi non ha ancora preferenze locali salvate.',
        'sidebar_default' => 'Sidebar collapsed di default',
        'sidebar_default_meta' => 'Compatta la shell desktop al primo accesso se non esistono preferenze locali.',
        'spotlight_hints' => 'Mostra hint della command palette',
        'spotlight_hints_meta' => 'Visualizza `Ctrl/Cmd + K` nel campo search della topbar.',
        'section_3_title' => 'Controlla i moduli visibili nella shell',
        'section_3_lead' => 'Disattiva rapidamente moduli secondari senza toccare codice o routing principale.',
        'customers' => 'Customers',
        'customers_meta' => 'Mostra la sezione clienti in sidebar, topbar e quick actions.',
        'reports' => 'Reports',
        'reports_meta' => 'Abilita il modulo analitico nella shell amministrativa.',
        'audit' => 'Audit logs',
        'audit_meta' => 'Espone il centro audit nella navigazione e nelle quick actions.',
        'documents_board' => 'Documents board',
        'documents_board_meta' => 'Mantiene disponibile la board documentale avanzata nel workspace.',
        'save' => 'Salva impostazioni',
        'back_dashboard' => 'Torna alla dashboard',
        'summary_eyebrow' => 'Workspace summary',
        'summary_title_fallback' => 'CoreSuite Lite',
        'summary_environment' => 'Environment',
        'summary_support' => 'Support',
        'summary_theme' => 'Theme default',
        'impact_eyebrow' => 'Impact area',
        'impact_title' => 'Cosa cambia davvero',
        'impact_brand' => 'Brand e naming si riflettono subito in topbar, sidebar e footer.',
        'impact_shell' => 'I default shell si applicano quando un utente non ha preferenze locali salvate.',
        'impact_modules' => 'I moduli disattivati spariscono dalla navigazione principale.',
        'note_eyebrow' => 'Governance note',
        'note_title' => 'Strategia consigliata',
        'note_shell' => 'Usa queste preferenze per definire l esperienza iniziale, non per sostituire le scelte personali dei singoli utenti.',
        'note_modules' => 'Attiva solo i moduli realmente pronti, cosi la shell resta pulita e credibile.',
        'shell_first' => 'Shell first',
        'module_rollout' => 'Module rollout',
    ],
    'en' => [
        'page_title' => 'Workspace Settings',
        'eyebrow' => 'Workspace settings',
        'title' => 'Customize identity, shell, and visible suite modules',
        'lead' => 'Here you govern workspace naming, shell defaults, and which administrative modules should be exposed in the daily experience.',
        'audit_logs' => 'Audit logs',
        'admin_only' => 'Admin only',
        'meta_identity' => 'Workspace identity',
        'meta_shell' => 'Shell defaults',
        'meta_modules' => 'Module visibility',
        'meta_delivery' => 'Mail delivery',
        'step_1_title' => 'Identity',
        'step_1_subtitle' => 'Brand and context',
        'step_2_title' => 'Shell',
        'step_2_subtitle' => 'Visual defaults',
        'step_3_title' => 'Modules',
        'step_3_subtitle' => 'Feature visibility',
        'card_eyebrow' => 'Governance form',
        'card_title' => 'Workspace settings',
        'status_primary' => 'Suite control',
        'status_secondary' => 'Persistent',
        'section_1_title' => 'Define workspace identity and context',
        'section_1_lead' => 'These values feed brand, shell, and administrative messages across the suite.',
        'workspace_name' => 'Workspace name',
        'environment_label' => 'Environment name',
        'support_email' => 'Support email',
        'support_phone' => 'Support phone',
        'legal_name' => 'Legal name',
        'address_line' => 'Registered address',
        'address_city' => 'City',
        'address_zip' => 'ZIP code',
        'address_country' => 'Country',
        'vat_number' => 'VAT number',
        'tax_code' => 'Tax code',
        'pec_email' => 'Certified email',
        'sdi_code' => 'SDI code',
        'iban' => 'IBAN',
        'section_mail_title' => 'Configure mail delivery and password reset',
        'section_mail_lead' => 'Configure the delivery method that best fits your environment. SMTP remains a simple and broadly compatible choice.',
        'app_url' => 'App URL',
        'app_url_help' => 'Public URL used in email links, for example https://suite.example.com.',
        'mail_driver' => 'Mail driver',
        'mail_driver_disabled' => 'Disabled',
        'mail_driver_log' => 'Log only',
        'mail_driver_smtp' => 'SMTP',
        'mail_driver_resend' => 'Resend',
        'mail_from_name' => 'Sender name',
        'mail_from_email' => 'Sender email',
        'mail_reply_to' => 'Reply-to',
        'smtp_host' => 'SMTP host',
        'smtp_port' => 'SMTP port',
        'smtp_username' => 'SMTP username',
        'smtp_password' => 'SMTP password',
        'smtp_encryption' => 'SMTP encryption',
        'smtp_timeout' => 'SMTP timeout',
        'smtp_auth_enabled' => 'Require SMTP authentication',
        'resend_api_key' => 'Resend API key',
        'secret_hint' => 'Leave empty to keep the saved secret.',
        'mail_test_recipient' => 'Test email recipient',
        'mail_test_recipient_help' => 'If empty, use the support email or your admin account email.',
        'send_test' => 'Send test email',
        'mail_status_title' => 'Mail delivery status',
        'mail_status_driver' => 'Driver',
        'mail_status_sender' => 'Sender',
        'mail_status_reply_to' => 'Reply-to',
        'mail_status_configured' => 'Configured',
        'mail_status_pending' => 'Needs setup',
        'default_theme' => 'Default theme',
        'theme_system' => 'System',
        'theme_light' => 'Light',
        'theme_dark' => 'Dark',
        'section_2_title' => 'Set shell defaults',
        'section_2_lead' => 'These preferences guide the initial experience for users with no saved local preferences.',
        'sidebar_default' => 'Sidebar collapsed by default',
        'sidebar_default_meta' => 'Compacts the desktop shell on first access if no local preferences exist.',
        'spotlight_hints' => 'Show command palette hints',
        'spotlight_hints_meta' => 'Displays `Ctrl/Cmd + K` in the topbar search field.',
        'section_3_title' => 'Control visible shell modules',
        'section_3_lead' => 'Quickly disable secondary modules without touching code or primary routing.',
        'customers' => 'Customers',
        'customers_meta' => 'Shows the customer section in sidebar, topbar, and quick actions.',
        'reports' => 'Reports',
        'reports_meta' => 'Enables the analytics module in the administrative shell.',
        'audit' => 'Audit logs',
        'audit_meta' => 'Exposes the audit center in navigation and quick actions.',
        'documents_board' => 'Documents board',
        'documents_board_meta' => 'Keeps the advanced document board available in the workspace.',
        'save' => 'Save settings',
        'back_dashboard' => 'Back to dashboard',
        'summary_eyebrow' => 'Workspace summary',
        'summary_title_fallback' => 'CoreSuite Lite',
        'summary_environment' => 'Environment',
        'summary_support' => 'Support',
        'summary_theme' => 'Theme default',
        'impact_eyebrow' => 'Impact area',
        'impact_title' => 'What actually changes',
        'impact_brand' => 'Brand and naming immediately reflect in topbar, sidebar, and footer.',
        'impact_shell' => 'Shell defaults apply when a user has no saved local preferences.',
        'impact_modules' => 'Disabled modules disappear from main navigation.',
        'note_eyebrow' => 'Governance note',
        'note_title' => 'Recommended strategy',
        'note_shell' => 'Use these preferences to define the initial experience, not to replace individual user choices.',
        'note_modules' => 'Enable only truly ready modules so the shell remains clean and credible.',
        'shell_first' => 'Shell first',
        'module_rollout' => 'Module rollout',
    ],
    'fr' => [
        'page_title' => 'Parametres workspace',
        'eyebrow' => 'Parametres workspace',
        'title' => 'Personnaliser identite, shell et modules visibles de la suite',
        'lead' => 'Ici vous gouvernez le naming du workspace, les defauts de la shell et les modules administratifs exposes dans l experience quotidienne.',
        'audit_logs' => 'Audit logs',
        'admin_only' => 'Admin only',
        'meta_identity' => 'Identite workspace',
        'meta_shell' => 'Defauts shell',
        'meta_modules' => 'Visibilite modules',
        'meta_delivery' => 'Mail delivery',
        'step_1_title' => 'Identite',
        'step_1_subtitle' => 'Brand et contexte',
        'step_2_title' => 'Shell',
        'step_2_subtitle' => 'Defauts visuels',
        'step_3_title' => 'Modules',
        'step_3_subtitle' => 'Visibilite fonctions',
        'card_eyebrow' => 'Formulaire gouvernance',
        'card_title' => 'Parametres du workspace',
        'status_primary' => 'Controle suite',
        'status_secondary' => 'Persistant',
        'section_1_title' => 'Definir identite et contexte du workspace',
        'section_1_lead' => 'Ces valeurs alimentent brand, shell et messages administratifs dans toute la suite.',
        'workspace_name' => 'Nom du workspace',
        'environment_label' => 'Nom environnement',
        'support_email' => 'Email support',
        'support_phone' => 'Telephone support',
        'legal_name' => 'Raison sociale',
        'address_line' => 'Adresse legale',
        'address_city' => 'Ville',
        'address_zip' => 'Code postal',
        'address_country' => 'Pays',
        'vat_number' => 'Numero TVA',
        'tax_code' => 'Code fiscal',
        'pec_email' => 'Email certifie',
        'sdi_code' => 'Code SDI',
        'iban' => 'IBAN',
        'section_mail_title' => 'Configurer la livraison email et le reset password',
        'section_mail_lead' => 'Configurez la methode d envoi la plus adaptee a votre environnement. SMTP reste un choix simple et largement compatible.',
        'app_url' => 'App URL',
        'app_url_help' => 'URL publique utilisee dans les liens email, par exemple https://suite.example.com.',
        'mail_driver' => 'Mail driver',
        'mail_driver_disabled' => 'Desactive',
        'mail_driver_log' => 'Log uniquement',
        'mail_driver_smtp' => 'SMTP',
        'mail_driver_resend' => 'Resend',
        'mail_from_name' => 'Nom expediteur',
        'mail_from_email' => 'Email expediteur',
        'mail_reply_to' => 'Reply-to',
        'smtp_host' => 'SMTP host',
        'smtp_port' => 'SMTP port',
        'smtp_username' => 'SMTP username',
        'smtp_password' => 'SMTP password',
        'smtp_encryption' => 'Encryption SMTP',
        'smtp_timeout' => 'SMTP timeout',
        'smtp_auth_enabled' => 'Exiger l authentification SMTP',
        'resend_api_key' => 'Resend API key',
        'secret_hint' => 'Laissez vide pour conserver le secret deja enregistre.',
        'mail_test_recipient' => 'Destinataire email de test',
        'mail_test_recipient_help' => 'Si vide, utilisez l email support ou l email de votre compte admin.',
        'send_test' => 'Envoyer un email de test',
        'mail_status_title' => 'Statut livraison email',
        'mail_status_driver' => 'Driver',
        'mail_status_sender' => 'Expediteur',
        'mail_status_reply_to' => 'Reply-to',
        'mail_status_configured' => 'Configure',
        'mail_status_pending' => 'A completer',
        'default_theme' => 'Theme par defaut',
        'theme_system' => 'Systeme',
        'theme_light' => 'Clair',
        'theme_dark' => 'Sombre',
        'section_2_title' => 'Definir les defauts de la shell',
        'section_2_lead' => 'Ces preferences guident l experience initiale des utilisateurs sans preferences locales sauvegardees.',
        'sidebar_default' => 'Sidebar repliee par defaut',
        'sidebar_default_meta' => 'Compacte la shell desktop au premier acces si aucune preference locale n existe.',
        'spotlight_hints' => 'Afficher les hints de la command palette',
        'spotlight_hints_meta' => 'Affiche `Ctrl/Cmd + K` dans le champ search de la topbar.',
        'section_3_title' => 'Controler les modules visibles dans la shell',
        'section_3_lead' => 'Desactive rapidement les modules secondaires sans toucher au code ni au routing principal.',
        'customers' => 'Customers',
        'customers_meta' => 'Affiche la section clients dans sidebar, topbar et quick actions.',
        'reports' => 'Reports',
        'reports_meta' => 'Active le module analytique dans la shell administrative.',
        'audit' => 'Audit logs',
        'audit_meta' => 'Expose le centre audit dans la navigation et les quick actions.',
        'documents_board' => 'Documents board',
        'documents_board_meta' => 'Maintient la board documentaire avancee disponible dans le workspace.',
        'save' => 'Enregistrer les parametres',
        'back_dashboard' => 'Retour au dashboard',
        'summary_eyebrow' => 'Resume workspace',
        'summary_title_fallback' => 'CoreSuite Lite',
        'summary_environment' => 'Environnement',
        'summary_support' => 'Support',
        'summary_theme' => 'Theme par defaut',
        'impact_eyebrow' => 'Zone d impact',
        'impact_title' => 'Ce qui change vraiment',
        'impact_brand' => 'Brand et naming se refletent immediatement dans topbar, sidebar et footer.',
        'impact_shell' => 'Les defauts shell s appliquent lorsqu un utilisateur n a pas de preferences locales sauvegardees.',
        'impact_modules' => 'Les modules desactives disparaissent de la navigation principale.',
        'note_eyebrow' => 'Note gouvernance',
        'note_title' => 'Strategie recommandee',
        'note_shell' => 'Utilisez ces preferences pour definir l experience initiale, pas pour remplacer les choix individuels.',
        'note_modules' => 'Activez seulement les modules vraiment prets pour garder une shell propre et credible.',
        'shell_first' => 'Shell first',
        'module_rollout' => 'Module rollout',
    ],
    'es' => [
        'page_title' => 'Ajustes del workspace',
        'eyebrow' => 'Ajustes del workspace',
        'title' => 'Personaliza identidad, shell y modulos visibles de la suite',
        'lead' => 'Aqui gobiernas el naming del workspace, los defaults de la shell y que modulos administrativos deben mostrarse en la experiencia diaria.',
        'audit_logs' => 'Audit logs',
        'admin_only' => 'Admin only',
        'meta_identity' => 'Identidad workspace',
        'meta_shell' => 'Defaults shell',
        'meta_modules' => 'Visibilidad modulos',
        'meta_delivery' => 'Mail delivery',
        'step_1_title' => 'Identidad',
        'step_1_subtitle' => 'Brand y contexto',
        'step_2_title' => 'Shell',
        'step_2_subtitle' => 'Defaults visuales',
        'step_3_title' => 'Modulos',
        'step_3_subtitle' => 'Visibilidad funciones',
        'card_eyebrow' => 'Formulario de gobernanza',
        'card_title' => 'Ajustes del workspace',
        'status_primary' => 'Control suite',
        'status_secondary' => 'Persistente',
        'section_1_title' => 'Define identidad y contexto del workspace',
        'section_1_lead' => 'Estos valores alimentan brand, shell y mensajes administrativos en toda la suite.',
        'workspace_name' => 'Nombre del workspace',
        'environment_label' => 'Nombre del entorno',
        'support_email' => 'Email de soporte',
        'support_phone' => 'Telefono soporte',
        'legal_name' => 'Razon social',
        'address_line' => 'Direccion legal',
        'address_city' => 'Ciudad',
        'address_zip' => 'Codigo postal',
        'address_country' => 'Pais',
        'vat_number' => 'Numero IVA',
        'tax_code' => 'Codigo fiscal',
        'pec_email' => 'Email certificada',
        'sdi_code' => 'Codigo SDI',
        'iban' => 'IBAN',
        'section_mail_title' => 'Configura entrega de email y reset password',
        'section_mail_lead' => 'Configura el metodo de envio mas adecuado para tu entorno. SMTP sigue siendo una opcion simple y ampliamente compatible.',
        'app_url' => 'App URL',
        'app_url_help' => 'URL publica usada en los enlaces email, por ejemplo https://suite.example.com.',
        'mail_driver' => 'Mail driver',
        'mail_driver_disabled' => 'Deshabilitado',
        'mail_driver_log' => 'Solo log',
        'mail_driver_smtp' => 'SMTP',
        'mail_driver_resend' => 'Resend',
        'mail_from_name' => 'Nombre remitente',
        'mail_from_email' => 'Email remitente',
        'mail_reply_to' => 'Reply-to',
        'smtp_host' => 'SMTP host',
        'smtp_port' => 'SMTP port',
        'smtp_username' => 'SMTP username',
        'smtp_password' => 'SMTP password',
        'smtp_encryption' => 'Cifrado SMTP',
        'smtp_timeout' => 'SMTP timeout',
        'smtp_auth_enabled' => 'Requerir autenticacion SMTP',
        'resend_api_key' => 'Resend API key',
        'secret_hint' => 'Deja vacio para mantener el secreto ya guardado.',
        'mail_test_recipient' => 'Destinatario email de prueba',
        'mail_test_recipient_help' => 'Si esta vacio, usa el email de soporte o el email de tu cuenta admin.',
        'send_test' => 'Enviar email de prueba',
        'mail_status_title' => 'Estado de entrega email',
        'mail_status_driver' => 'Driver',
        'mail_status_sender' => 'Remitente',
        'mail_status_reply_to' => 'Reply-to',
        'mail_status_configured' => 'Configurado',
        'mail_status_pending' => 'Pendiente',
        'default_theme' => 'Tema por defecto',
        'theme_system' => 'Sistema',
        'theme_light' => 'Claro',
        'theme_dark' => 'Oscuro',
        'section_2_title' => 'Define los defaults de la shell',
        'section_2_lead' => 'Estas preferencias guian la experiencia inicial para quien aun no tiene preferencias locales guardadas.',
        'sidebar_default' => 'Sidebar colapsada por defecto',
        'sidebar_default_meta' => 'Compacta la shell desktop en el primer acceso si no existen preferencias locales.',
        'spotlight_hints' => 'Mostrar hints de la command palette',
        'spotlight_hints_meta' => 'Muestra `Ctrl/Cmd + K` en el campo search de la topbar.',
        'section_3_title' => 'Controla los modulos visibles en la shell',
        'section_3_lead' => 'Desactiva rapidamente modulos secundarios sin tocar codigo ni routing principal.',
        'customers' => 'Customers',
        'customers_meta' => 'Muestra la seccion clientes en sidebar, topbar y quick actions.',
        'reports' => 'Reports',
        'reports_meta' => 'Habilita el modulo analitico en la shell administrativa.',
        'audit' => 'Audit logs',
        'audit_meta' => 'Expone el centro de auditoria en navegacion y quick actions.',
        'documents_board' => 'Documents board',
        'documents_board_meta' => 'Mantiene disponible la board documental avanzada en el workspace.',
        'save' => 'Guardar ajustes',
        'back_dashboard' => 'Volver al dashboard',
        'summary_eyebrow' => 'Resumen workspace',
        'summary_title_fallback' => 'CoreSuite Lite',
        'summary_environment' => 'Entorno',
        'summary_support' => 'Soporte',
        'summary_theme' => 'Tema por defecto',
        'impact_eyebrow' => 'Area de impacto',
        'impact_title' => 'Que cambia realmente',
        'impact_brand' => 'Brand y naming se reflejan enseguida en topbar, sidebar y footer.',
        'impact_shell' => 'Los defaults shell se aplican cuando un usuario no tiene preferencias locales guardadas.',
        'impact_modules' => 'Los modulos desactivados desaparecen de la navegacion principal.',
        'note_eyebrow' => 'Nota de gobernanza',
        'note_title' => 'Estrategia recomendada',
        'note_shell' => 'Usa estas preferencias para definir la experiencia inicial, no para sustituir elecciones personales.',
        'note_modules' => 'Activa solo modulos realmente listos para que la shell siga limpia y creible.',
        'shell_first' => 'Shell first',
        'module_rollout' => 'Module rollout',
    ],
];

$wst = $workspaceSettingsText[Locale::current()] ?? $workspaceSettingsText['it'];
$pageTitle = $wst['page_title'];
$settings = (array)($settings ?? []);
$mailStatus = (array)($mailStatus ?? []);
$mailTestRecipient = (string)($mailTestRecipient ?? '');
$driverLabels = [
    'disabled' => $wst['mail_driver_disabled'],
    'log' => $wst['mail_driver_log'],
    'smtp' => $wst['mail_driver_smtp'],
    'resend' => $wst['mail_driver_resend'],
];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($wst['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($wst['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($wst['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/audit-logs" class="btn btn-outline-secondary"><?php echo htmlspecialchars($wst['audit_logs']); ?></a>
        <span class="admin-section-chip"><i class="fas fa-sliders"></i><?php echo htmlspecialchars($wst['admin_only']); ?></span>
    </div>
</section>

<div class="admin-form-shell">
    <div class="admin-form-meta mb-3">
        <span class="admin-form-meta__pill"><i class="fas fa-layer-group"></i><?php echo htmlspecialchars($wst['meta_identity']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-paper-plane"></i><?php echo htmlspecialchars($wst['meta_delivery']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-desktop"></i><?php echo htmlspecialchars($wst['meta_shell']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-toggle-on"></i><?php echo htmlspecialchars($wst['meta_modules']); ?></span>
    </div>

    <div class="admin-form-stepper mb-4">
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">1</span>
            <div><strong><?php echo htmlspecialchars($wst['step_1_title']); ?></strong><small><?php echo htmlspecialchars($wst['step_1_subtitle']); ?></small></div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">2</span>
            <div><strong><?php echo htmlspecialchars($wst['step_2_title']); ?></strong><small><?php echo htmlspecialchars($wst['step_2_subtitle']); ?></small></div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">3</span>
            <div><strong><?php echo htmlspecialchars($wst['step_3_title']); ?></strong><small><?php echo htmlspecialchars($wst['step_3_subtitle']); ?></small></div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card admin-form-card">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wst['card_eyebrow']); ?></p>
                        <span><?php echo htmlspecialchars($wst['card_title']); ?></span>
                    </div>
                    <div class="admin-form-card__status">
                        <span class="admin-form-card__status-pill"><?php echo htmlspecialchars($wst['status_primary']); ?></span>
                        <span class="admin-form-card__status-pill is-soft"><?php echo htmlspecialchars($wst['status_secondary']); ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="/workspace/settings" class="row g-3">
                        <?php echo CSRF::field(); ?>
                        <div class="col-12">
                            <div class="admin-form-section admin-form-section--boxed">
                                <p class="admin-form-section__eyebrow">Step 1</p>
                                <h3 class="admin-form-section__title"><?php echo htmlspecialchars($wst['section_1_title']); ?></h3>
                                <p class="admin-form-section__lead"><?php echo htmlspecialchars($wst['section_1_lead']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['workspace_name']); ?></label>
                            <input class="form-control" type="text" name="workspace_name" value="<?php echo htmlspecialchars((string)($settings['workspace_name'] ?? 'CoreSuite Lite')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['environment_label']); ?></label>
                            <input class="form-control" type="text" name="environment_label" value="<?php echo htmlspecialchars((string)($settings['environment_label'] ?? 'Production workspace')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['support_email']); ?></label>
                            <input class="form-control" type="email" name="support_email" value="<?php echo htmlspecialchars((string)($settings['support_email'] ?? 'support@example.com')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['support_phone']); ?></label>
                            <input class="form-control" type="text" name="support_phone" value="<?php echo htmlspecialchars((string)($settings['support_phone'] ?? '')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['legal_name']); ?></label>
                            <input class="form-control" type="text" name="legal_name" value="<?php echo htmlspecialchars((string)($settings['legal_name'] ?? 'CoreSuite Lite S.r.l.')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['address_line']); ?></label>
                            <input class="form-control" type="text" name="address_line" value="<?php echo htmlspecialchars((string)($settings['address_line'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['address_city']); ?></label>
                            <input class="form-control" type="text" name="address_city" value="<?php echo htmlspecialchars((string)($settings['address_city'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['address_zip']); ?></label>
                            <input class="form-control" type="text" name="address_zip" value="<?php echo htmlspecialchars((string)($settings['address_zip'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['address_country']); ?></label>
                            <input class="form-control" type="text" name="address_country" value="<?php echo htmlspecialchars((string)($settings['address_country'] ?? 'Italia')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['vat_number']); ?></label>
                            <input class="form-control" type="text" name="vat_number" value="<?php echo htmlspecialchars((string)($settings['vat_number'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['tax_code']); ?></label>
                            <input class="form-control" type="text" name="tax_code" value="<?php echo htmlspecialchars((string)($settings['tax_code'] ?? '')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['iban']); ?></label>
                            <input class="form-control" type="text" name="iban" value="<?php echo htmlspecialchars((string)($settings['iban'] ?? '')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['pec_email']); ?></label>
                            <input class="form-control" type="text" name="pec_email" value="<?php echo htmlspecialchars((string)($settings['pec_email'] ?? '')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['sdi_code']); ?></label>
                            <input class="form-control" type="text" name="sdi_code" value="<?php echo htmlspecialchars((string)($settings['sdi_code'] ?? '')); ?>">
                        </div>
                        <div class="col-12">
                            <div class="admin-form-section admin-form-section--boxed">
                                <p class="admin-form-section__eyebrow">Mail</p>
                                <h3 class="admin-form-section__title"><?php echo htmlspecialchars($wst['section_mail_title']); ?></h3>
                                <p class="admin-form-section__lead"><?php echo htmlspecialchars($wst['section_mail_lead']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['app_url']); ?></label>
                            <input class="form-control" type="url" name="app_url" value="<?php echo htmlspecialchars((string)($settings['app_url'] ?? '')); ?>" placeholder="https://suite.example.com">
                            <div class="form-text"><?php echo htmlspecialchars($wst['app_url_help']); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['mail_driver']); ?></label>
                            <select class="form-select" name="mail_driver">
                                <?php $selectedDriver = (string)($settings['mail_driver'] ?? 'disabled'); ?>
                                <?php foreach ($driverLabels as $value => $label): ?>
                                    <option value="<?php echo htmlspecialchars($value); ?>" <?php echo $selectedDriver === $value ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['mail_from_name']); ?></label>
                            <input class="form-control" type="text" name="mail_from_name" value="<?php echo htmlspecialchars((string)($settings['mail_from_name'] ?? 'CoreSuite Lite')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['mail_from_email']); ?></label>
                            <input class="form-control" type="email" name="mail_from_email" value="<?php echo htmlspecialchars((string)($settings['mail_from_email'] ?? '')); ?>" placeholder="no-reply@example.com">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['mail_reply_to']); ?></label>
                            <input class="form-control" type="email" name="mail_reply_to" value="<?php echo htmlspecialchars((string)($settings['mail_reply_to'] ?? '')); ?>" placeholder="support@example.com">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['smtp_host']); ?></label>
                            <input class="form-control" type="text" name="smtp_host" value="<?php echo htmlspecialchars((string)($settings['smtp_host'] ?? '')); ?>" placeholder="smtp.example.com">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?php echo htmlspecialchars($wst['smtp_port']); ?></label>
                            <input class="form-control" type="number" name="smtp_port" value="<?php echo htmlspecialchars((string)($settings['smtp_port'] ?? '587')); ?>" min="1" max="65535">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?php echo htmlspecialchars($wst['smtp_username']); ?></label>
                            <input class="form-control" type="text" name="smtp_username" value="<?php echo htmlspecialchars((string)($settings['smtp_username'] ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?php echo htmlspecialchars($wst['smtp_password']); ?></label>
                            <input class="form-control" type="password" name="smtp_password" value="">
                            <div class="form-text"><?php echo htmlspecialchars($wst['secret_hint']); ?></div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?php echo htmlspecialchars($wst['smtp_timeout']); ?></label>
                            <input class="form-control" type="number" name="smtp_timeout" value="<?php echo htmlspecialchars((string)($settings['smtp_timeout'] ?? '15')); ?>" min="1" max="120">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?php echo htmlspecialchars($wst['smtp_encryption']); ?></label>
                            <select class="form-select" name="smtp_encryption">
                                <?php $smtpEncryption = (string)($settings['smtp_encryption'] ?? 'tls'); ?>
                                <option value="none" <?php echo $smtpEncryption === 'none' ? 'selected' : ''; ?>>none</option>
                                <option value="tls" <?php echo $smtpEncryption === 'tls' ? 'selected' : ''; ?>>tls</option>
                                <option value="ssl" <?php echo $smtpEncryption === 'ssl' ? 'selected' : ''; ?>>ssl</option>
                            </select>
                        </div>
                        <div class="col-md-5 d-flex align-items-end">
                            <label class="workspace-settings-toggle w-100 mb-0">
                                <input type="checkbox" name="smtp_auth_enabled" value="1" <?php echo !array_key_exists('smtp_auth_enabled', $settings) || !empty($settings['smtp_auth_enabled']) ? 'checked' : ''; ?>>
                                <span><strong><?php echo htmlspecialchars($wst['smtp_auth_enabled']); ?></strong><small><?php echo htmlspecialchars($wst['secret_hint']); ?></small></span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo htmlspecialchars($wst['resend_api_key']); ?></label>
                            <input class="form-control" type="password" name="resend_api_key" value="">
                            <div class="form-text"><?php echo htmlspecialchars($wst['secret_hint']); ?></div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label"><?php echo htmlspecialchars($wst['mail_test_recipient']); ?></label>
                            <input class="form-control" type="email" name="mail_test_recipient" value="<?php echo htmlspecialchars($mailTestRecipient); ?>" placeholder="support@example.com">
                            <div class="form-text"><?php echo htmlspecialchars($wst['mail_test_recipient_help']); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo htmlspecialchars($wst['default_theme']); ?></label>
                            <select class="form-select" name="default_theme">
                                <?php foreach (['system' => $wst['theme_system'], 'light' => $wst['theme_light'], 'dark' => $wst['theme_dark']] as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo (($settings['default_theme'] ?? 'system') === $value) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="admin-form-section admin-form-section--boxed">
                                <p class="admin-form-section__eyebrow">Step 2</p>
                                <h3 class="admin-form-section__title"><?php echo htmlspecialchars($wst['section_2_title']); ?></h3>
                                <p class="admin-form-section__lead"><?php echo htmlspecialchars($wst['section_2_lead']); ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="workspace-settings-toggle-list">
                                <label class="workspace-settings-toggle">
                                    <input type="checkbox" name="sidebar_collapsed_default" value="1" <?php echo !empty($settings['sidebar_collapsed_default']) ? 'checked' : ''; ?>>
                                    <span><strong><?php echo htmlspecialchars($wst['sidebar_default']); ?></strong><small><?php echo htmlspecialchars($wst['sidebar_default_meta']); ?></small></span>
                                </label>
                                <label class="workspace-settings-toggle">
                                    <input type="checkbox" name="spotlight_hints_enabled" value="1" <?php echo !empty($settings['spotlight_hints_enabled']) ? 'checked' : ''; ?>>
                                    <span><strong><?php echo htmlspecialchars($wst['spotlight_hints']); ?></strong><small><?php echo htmlspecialchars($wst['spotlight_hints_meta']); ?></small></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="admin-form-section admin-form-section--boxed">
                                <p class="admin-form-section__eyebrow">Step 3</p>
                                <h3 class="admin-form-section__title"><?php echo htmlspecialchars($wst['section_3_title']); ?></h3>
                                <p class="admin-form-section__lead"><?php echo htmlspecialchars($wst['section_3_lead']); ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="workspace-settings-toggle-list">
                                <label class="workspace-settings-toggle">
                                    <input type="checkbox" name="customers_enabled" value="1" <?php echo !empty($settings['customers_enabled']) ? 'checked' : ''; ?>>
                                    <span><strong><?php echo htmlspecialchars($wst['customers']); ?></strong><small><?php echo htmlspecialchars($wst['customers_meta']); ?></small></span>
                                </label>
                                <label class="workspace-settings-toggle">
                                    <input type="checkbox" name="reports_enabled" value="1" <?php echo !empty($settings['reports_enabled']) ? 'checked' : ''; ?>>
                                    <span><strong><?php echo htmlspecialchars($wst['reports']); ?></strong><small><?php echo htmlspecialchars($wst['reports_meta']); ?></small></span>
                                </label>
                                <label class="workspace-settings-toggle">
                                    <input type="checkbox" name="audit_logs_enabled" value="1" <?php echo !empty($settings['audit_logs_enabled']) ? 'checked' : ''; ?>>
                                    <span><strong><?php echo htmlspecialchars($wst['audit']); ?></strong><small><?php echo htmlspecialchars($wst['audit_meta']); ?></small></span>
                                </label>
                                <label class="workspace-settings-toggle">
                                    <input type="checkbox" name="documents_board_enabled" value="1" <?php echo !empty($settings['documents_board_enabled']) ? 'checked' : ''; ?>>
                                    <span><strong><?php echo htmlspecialchars($wst['documents_board']); ?></strong><small><?php echo htmlspecialchars($wst['documents_board_meta']); ?></small></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary" type="submit" name="action" value="save"><i class="fas fa-save me-1"></i><?php echo htmlspecialchars($wst['save']); ?></button>
                            <button class="btn btn-outline-primary" type="submit" name="action" value="send_test_email"><i class="fas fa-paper-plane me-1"></i><?php echo htmlspecialchars($wst['send_test']); ?></button>
                            <a class="btn btn-outline-secondary" href="/dashboard"><?php echo htmlspecialchars($wst['back_dashboard']); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="admin-form-sidebar">
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($wst['summary_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars((string)($settings['workspace_name'] ?? $wst['summary_title_fallback'])); ?></h3>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['summary_environment']); ?></span><strong><?php echo htmlspecialchars((string)($settings['environment_label'] ?? 'Production workspace')); ?></strong></div>
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['summary_support']); ?></span><strong><?php echo htmlspecialchars((string)($settings['support_email'] ?? 'support@example.com')); ?></strong></div>
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['summary_theme']); ?></span><strong><?php echo htmlspecialchars((string)($settings['default_theme'] ?? 'system')); ?></strong></div>
                        </div>
                    </div>
                </div>

                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($wst['mail_status_title']); ?></p>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['mail_status_driver']); ?></span><strong><?php echo htmlspecialchars($driverLabels[(string)($mailStatus['driver'] ?? 'disabled')] ?? strtoupper((string)($mailStatus['driver'] ?? 'disabled'))); ?></strong></div>
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['mail_status_sender']); ?></span><strong><?php echo htmlspecialchars((string)($mailStatus['from_email'] ?? '-')); ?></strong></div>
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['mail_status_reply_to']); ?></span><strong><?php echo htmlspecialchars((string)($mailStatus['reply_to'] ?? '-')); ?></strong></div>
                            <div class="admin-summary-item"><span>Status</span><strong><?php echo !empty($mailStatus['configured']) ? htmlspecialchars($wst['mail_status_configured']) : htmlspecialchars($wst['mail_status_pending']); ?></strong></div>
                        </div>
                    </div>
                </div>

                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($wst['impact_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($wst['impact_title']); ?></h3>
                        <ul class="dashboard-insights mt-0">
                            <li><i class="fas fa-layer-group"></i><?php echo htmlspecialchars($wst['impact_brand']); ?></li>
                            <li><i class="fas fa-desktop"></i><?php echo htmlspecialchars($wst['impact_shell']); ?></li>
                            <li><i class="fas fa-toggle-on"></i><?php echo htmlspecialchars($wst['impact_modules']); ?></li>
                        </ul>
                    </div>
                </div>

                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($wst['note_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($wst['note_title']); ?></h3>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['shell_first']); ?></span><strong><?php echo htmlspecialchars($wst['note_shell']); ?></strong></div>
                            <div class="admin-summary-item"><span><?php echo htmlspecialchars($wst['module_rollout']); ?></span><strong><?php echo htmlspecialchars($wst['note_modules']); ?></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
