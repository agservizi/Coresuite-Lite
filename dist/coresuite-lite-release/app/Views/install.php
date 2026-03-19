<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars(\Core\Locale::current()); ?>">
<head>
    <?php
    $installText = [
        'it' => ['title' => 'Installazione - CoreSuite Lite', 'aria_locale' => 'Seleziona lingua', 'aria_theme' => 'Seleziona tema', 'brand' => 'Setup guidato', 'eyebrow' => 'First-time setup', 'hero_title' => 'Configura CoreSuite Lite in pochi passaggi', 'hero_lead' => 'Imposta database, amministratore iniziale e consegna email da una procedura unica, chiara e pronta per la prima installazione.', 'feature_db' => 'Connessione database e bootstrap applicativo', 'feature_admin' => 'Creazione account amministratore iniziale', 'feature_suite' => 'Base pronta per dashboard, ticket, documenti e reset password', 'stat_1_value' => '1', 'stat_1_label' => 'flow di setup unificato', 'stat_2_value' => '4', 'stat_2_label' => 'lingue interfaccia', 'stat_3_value' => '24/7', 'stat_3_label' => 'base pronta per operations', 'showcase_title' => 'Primo avvio chiaro e guidato', 'showcase_lead' => 'La prima configurazione usa lo stesso linguaggio visuale del login e prepara subito workspace, accessi e consegna email.', 'showcase_card_title' => 'Launch layer', 'showcase_card_text' => 'Database, admin e impostazioni chiave in un solo passaggio guidato.', 'trust' => 'Dopo il setup puoi disattivare l installer e continuare dalla schermata login.', 'card_title' => 'Installazione', 'card_subtitle' => 'Completa i dati richiesti per inizializzare il sistema.', 'step_db' => 'Database', 'step_db_lead' => 'Connessione e base applicativa', 'step_admin' => 'Admin', 'step_admin_lead' => 'Accesso iniziale e ownership', 'step_mail' => 'Email', 'step_mail_lead' => 'Consegna e reset password', 'back' => 'Indietro', 'next' => 'Continua', 'section_db' => 'Database', 'section_admin' => 'Amministratore', 'section_mail' => 'Email e reset password', 'section_mail_lead' => 'Configurazione opzionale ma consigliata per abilitare subito il reset password.', 'host' => 'Host', 'db_name' => 'Nome database', 'user' => 'Utente', 'password' => 'Password', 'name' => 'Nome', 'email' => 'Email', 'app_url' => 'App URL', 'app_url_help' => 'Usa l URL pubblico del gestionale, ad esempio https://suite.example.com.', 'mail_driver' => 'Mail driver', 'mail_driver_disabled' => 'Disabilitato', 'mail_driver_log' => 'Solo log', 'mail_driver_smtp' => 'SMTP', 'mail_driver_resend' => 'Resend', 'mail_from_name' => 'Nome mittente', 'mail_from_email' => 'Email mittente', 'mail_reply_to' => 'Reply-to', 'smtp_host' => 'SMTP host', 'smtp_port' => 'SMTP port', 'smtp_username' => 'SMTP username', 'smtp_password' => 'SMTP password', 'smtp_encryption' => 'Cifratura SMTP', 'smtp_timeout' => 'SMTP timeout', 'smtp_auth_enabled' => 'Richiedi autenticazione SMTP', 'resend_api_key' => 'Resend API key', 'secret_hint' => 'Puoi lasciare i campi provider vuoti se il driver scelto non li usa.', 'submit' => 'Installa CoreSuite Lite', 'submit_meta' => 'Avvio guidato del workspace operativo', 'light' => 'Chiaro', 'dark' => 'Scuro', 'system' => 'Sistema'],
        'en' => ['title' => 'Installation - CoreSuite Lite', 'aria_locale' => 'Select language', 'aria_theme' => 'Select theme', 'brand' => 'Guided setup', 'eyebrow' => 'First-time setup', 'hero_title' => 'Set up CoreSuite Lite in a few steps', 'hero_lead' => 'Configure database, initial administrator, and email delivery from a single setup flow ready for first installation.', 'feature_db' => 'Database connection and application bootstrap', 'feature_admin' => 'Initial administrator account creation', 'feature_suite' => 'Foundation ready for dashboard, tickets, documents, and password reset', 'stat_1_value' => '1', 'stat_1_label' => 'unified setup flow', 'stat_2_value' => '4', 'stat_2_label' => 'interface languages', 'stat_3_value' => '24/7', 'stat_3_label' => 'operations-ready base', 'showcase_title' => 'Clear and guided first launch', 'showcase_lead' => 'First configuration uses the same visual language as login and prepares workspace, access, and email delivery from the start.', 'showcase_card_title' => 'Launch layer', 'showcase_card_text' => 'Database, admin account, and key settings in one guided step.', 'trust' => 'After setup, you can disable the installer and continue from the login screen.', 'card_title' => 'Installation', 'card_subtitle' => 'Complete the required information to initialize the system.', 'step_db' => 'Database', 'step_db_lead' => 'Connection and application base', 'step_admin' => 'Admin', 'step_admin_lead' => 'Initial access and ownership', 'step_mail' => 'Email', 'step_mail_lead' => 'Delivery and password reset', 'back' => 'Back', 'next' => 'Continue', 'section_db' => 'Database', 'section_admin' => 'Administrator', 'section_mail' => 'Email and password reset', 'section_mail_lead' => 'Optional but recommended configuration to enable password reset immediately.', 'host' => 'Host', 'db_name' => 'Database name', 'user' => 'User', 'password' => 'Password', 'name' => 'Name', 'email' => 'Email', 'app_url' => 'App URL', 'app_url_help' => 'Use the public URL of the suite, for example https://suite.example.com.', 'mail_driver' => 'Mail driver', 'mail_driver_disabled' => 'Disabled', 'mail_driver_log' => 'Log only', 'mail_driver_smtp' => 'SMTP', 'mail_driver_resend' => 'Resend', 'mail_from_name' => 'Sender name', 'mail_from_email' => 'Sender email', 'mail_reply_to' => 'Reply-to', 'smtp_host' => 'SMTP host', 'smtp_port' => 'SMTP port', 'smtp_username' => 'SMTP username', 'smtp_password' => 'SMTP password', 'smtp_encryption' => 'SMTP encryption', 'smtp_timeout' => 'SMTP timeout', 'smtp_auth_enabled' => 'Require SMTP authentication', 'resend_api_key' => 'Resend API key', 'secret_hint' => 'You can leave provider fields empty if the selected driver does not use them.', 'submit' => 'Install CoreSuite Lite', 'submit_meta' => 'Guided launch of the operational workspace', 'light' => 'Light', 'dark' => 'Dark', 'system' => 'System'],
        'fr' => ['title' => 'Installation - CoreSuite Lite', 'aria_locale' => 'Selectionner la langue', 'aria_theme' => 'Selectionner le theme', 'brand' => 'Setup guide', 'eyebrow' => 'First-time setup', 'hero_title' => 'Configurez CoreSuite Lite en quelques etapes', 'hero_lead' => 'Configurez base de donnees, administrateur initial et livraison email depuis une procedure unique prete pour la premiere installation.', 'feature_db' => 'Connexion base de donnees et bootstrap applicatif', 'feature_admin' => 'Creation du compte administrateur initial', 'feature_suite' => 'Base prete pour dashboard, tickets, documents et reset password', 'stat_1_value' => '1', 'stat_1_label' => 'flux setup unifie', 'stat_2_value' => '4', 'stat_2_label' => 'langues interface', 'stat_3_value' => '24/7', 'stat_3_label' => 'base prete pour operations', 'showcase_title' => 'Un demarrage coherent avec toute la suite', 'showcase_lead' => 'La premiere configuration utilise le meme langage visuel que le login et prepare workspace, acces et livraison email des le depart.', 'showcase_card_title' => 'Launch layer', 'showcase_card_text' => 'Base de donnees, compte admin et reglages cles dans une seule etape guidee.', 'trust' => 'Apres le setup vous pouvez desactiver l installateur et continuer depuis l ecran de login.', 'card_title' => 'Installation', 'card_subtitle' => 'Completez les donnees requises pour initialiser le systeme.', 'section_db' => 'Base de donnees', 'section_admin' => 'Administrateur', 'section_mail' => 'Email et reset password', 'section_mail_lead' => 'Configuration optionnelle mais recommandee pour activer tout de suite le reset password.', 'host' => 'Host', 'db_name' => 'Nom base', 'user' => 'Utilisateur', 'password' => 'Mot de passe', 'name' => 'Nom', 'email' => 'Email', 'app_url' => 'App URL', 'app_url_help' => 'Utilisez l URL publique de la suite, par exemple https://suite.example.com.', 'mail_driver' => 'Mail driver', 'mail_driver_disabled' => 'Desactive', 'mail_driver_log' => 'Log uniquement', 'mail_driver_smtp' => 'SMTP', 'mail_driver_resend' => 'Resend', 'mail_from_name' => 'Nom expediteur', 'mail_from_email' => 'Email expediteur', 'mail_reply_to' => 'Reply-to', 'smtp_host' => 'SMTP host', 'smtp_port' => 'SMTP port', 'smtp_username' => 'SMTP username', 'smtp_password' => 'SMTP password', 'smtp_encryption' => 'Encryption SMTP', 'smtp_timeout' => 'SMTP timeout', 'smtp_auth_enabled' => 'Exiger l authentification SMTP', 'resend_api_key' => 'Resend API key', 'secret_hint' => 'Vous pouvez laisser les champs provider vides si le driver choisi ne les utilise pas.', 'submit' => 'Installer CoreSuite Lite', 'submit_meta' => 'Lancement guide du workspace operationnel', 'light' => 'Clair', 'dark' => 'Sombre', 'system' => 'Systeme'],
        'es' => ['title' => 'Instalacion - CoreSuite Lite', 'aria_locale' => 'Selecciona idioma', 'aria_theme' => 'Selecciona tema', 'brand' => 'Setup guiado', 'eyebrow' => 'First-time setup', 'hero_title' => 'Configura CoreSuite Lite en pocos pasos', 'hero_lead' => 'Configura base de datos, administrador inicial y entrega de email desde un unico proceso listo para la primera instalacion.', 'feature_db' => 'Conexion de base de datos y bootstrap de la aplicacion', 'feature_admin' => 'Creacion de la cuenta inicial de administrador', 'feature_suite' => 'Base lista para dashboard, tickets, documentos y reset password', 'stat_1_value' => '1', 'stat_1_label' => 'flujo setup unificado', 'stat_2_value' => '4', 'stat_2_label' => 'idiomas de interfaz', 'stat_3_value' => '24/7', 'stat_3_label' => 'base lista para operaciones', 'showcase_title' => 'Un arranque alineado con toda la suite', 'showcase_lead' => 'La primera configuracion usa el mismo lenguaje visual del login y prepara workspace, accesos y entrega email desde el inicio.', 'showcase_card_title' => 'Launch layer', 'showcase_card_text' => 'Base de datos, cuenta admin y ajustes clave en un solo paso guiado.', 'trust' => 'Despues del setup puedes desactivar el instalador y seguir desde la pantalla de login.', 'card_title' => 'Instalacion', 'card_subtitle' => 'Completa los datos requeridos para inicializar el sistema.', 'section_db' => 'Base de datos', 'section_admin' => 'Administrador', 'section_mail' => 'Email y reset password', 'section_mail_lead' => 'Configuracion opcional pero recomendada para habilitar enseguida el reset password.', 'host' => 'Host', 'db_name' => 'Nombre base', 'user' => 'Usuario', 'password' => 'Contrasena', 'name' => 'Nombre', 'email' => 'Email', 'app_url' => 'App URL', 'app_url_help' => 'Usa la URL publica de la suite, por ejemplo https://suite.example.com.', 'mail_driver' => 'Mail driver', 'mail_driver_disabled' => 'Deshabilitado', 'mail_driver_log' => 'Solo log', 'mail_driver_smtp' => 'SMTP', 'mail_driver_resend' => 'Resend', 'mail_from_name' => 'Nombre remitente', 'mail_from_email' => 'Email remitente', 'mail_reply_to' => 'Reply-to', 'smtp_host' => 'SMTP host', 'smtp_port' => 'SMTP port', 'smtp_username' => 'SMTP username', 'smtp_password' => 'SMTP password', 'smtp_encryption' => 'Cifrado SMTP', 'smtp_timeout' => 'SMTP timeout', 'smtp_auth_enabled' => 'Requerir autenticacion SMTP', 'resend_api_key' => 'Resend API key', 'secret_hint' => 'Puedes dejar vacios los campos del provider si el driver elegido no los usa.', 'submit' => 'Instalar CoreSuite Lite', 'submit_meta' => 'Lanzamiento guiado del workspace operativo', 'light' => 'Claro', 'dark' => 'Oscuro', 'system' => 'Sistema'],
    ];
    $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    $assetBase = (is_string($docRoot) && is_file(rtrim($docRoot, '/') . '/assets/css/bootstrap.css'))
        ? '/assets'
        : '/public/assets';
    $itx = $installText[\Core\Locale::current()] ?? $installText['it'];
    $old = static function (string $key, string $default = ''): string {
        return htmlspecialchars((string)($_POST[$key] ?? $default));
    };
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($itx['title']); ?></title>
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="<?php echo $assetBase; ?>/css/bootstrap.css">
    <?php include __DIR__ . '/partials/fontawesome.php'; ?>
    <link rel="stylesheet" href="<?php echo $assetBase; ?>/css/theme.css">
</head>
<body class="login-page login-page--suite install-page">
    <div class="login-scene" aria-hidden="true">
        <div class="login-scene__orb login-scene__orb--a"></div>
        <div class="login-scene__orb login-scene__orb--b"></div>
        <div class="login-scene__grid"></div>
    </div>
    <div class="auth-theme-toggle" aria-label="Auth utilities">
        <div class="auth-utility-group auth-locale-switch" role="navigation" aria-label="<?php echo htmlspecialchars($itx['aria_locale']); ?>">
            <?php foreach (\Core\Locale::supported() as $localeCode => $localeLabel): ?>
                <a
                    href="<?php echo htmlspecialchars(\Core\Locale::switchUrl($localeCode, $_SERVER['REQUEST_URI'] ?? '/install')); ?>"
                    class="auth-utility-chip <?php echo \Core\Locale::current() === $localeCode ? 'is-active' : ''; ?>"
                    lang="<?php echo htmlspecialchars($localeCode); ?>"
                >
                    <?php echo htmlspecialchars(strtoupper($localeCode)); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="auth-utility-group auth-theme-switch" role="group" aria-label="<?php echo htmlspecialchars($itx['aria_theme']); ?>">
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="light" aria-label="<?php echo htmlspecialchars($itx['light']); ?>" title="<?php echo htmlspecialchars($itx['light']); ?>">
                <i class="fas fa-sun"></i>
            </button>
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="dark" aria-label="<?php echo htmlspecialchars($itx['dark']); ?>" title="<?php echo htmlspecialchars($itx['dark']); ?>">
                <i class="fas fa-moon"></i>
            </button>
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="system" aria-label="<?php echo htmlspecialchars($itx['system']); ?>" title="<?php echo htmlspecialchars($itx['system']); ?>">
                <i class="fas fa-desktop"></i>
            </button>
        </div>
    </div>

    <main class="auth-shell auth-shell--login">
        <section class="auth-panel auth-panel--split login-stage">
            <div class="auth-panel__brand login-showcase">
                <div class="login-showcase__topline"><?php echo htmlspecialchars($itx['eyebrow']); ?></div>
                <div class="auth-brand-mark"><i class="fas fa-rocket"></i><?php echo htmlspecialchars($itx['brand']); ?></div>
                <h1 class="auth-panel__title"><?php echo htmlspecialchars($itx['hero_title']); ?></h1>
                <p class="auth-panel__lead"><?php echo htmlspecialchars($itx['hero_lead']); ?></p>

                <div class="login-showcase__stats">
                    <article class="login-showcase__stat">
                        <strong><?php echo htmlspecialchars($itx['stat_1_value']); ?></strong>
                        <span><?php echo htmlspecialchars($itx['stat_1_label']); ?></span>
                    </article>
                    <article class="login-showcase__stat">
                        <strong><?php echo htmlspecialchars($itx['stat_2_value']); ?></strong>
                        <span><?php echo htmlspecialchars($itx['stat_2_label']); ?></span>
                    </article>
                    <article class="login-showcase__stat">
                        <strong><?php echo htmlspecialchars($itx['stat_3_value']); ?></strong>
                        <span><?php echo htmlspecialchars($itx['stat_3_label']); ?></span>
                    </article>
                </div>

                <div class="login-showcase__body">
                    <p class="login-showcase__card-eyebrow"><?php echo htmlspecialchars($itx['showcase_card_title']); ?></p>
                    <h2><?php echo htmlspecialchars($itx['showcase_title']); ?></h2>
                    <p><?php echo htmlspecialchars($itx['showcase_lead']); ?></p>
                </div>
                <div class="auth-feature-list">
                    <div class="auth-feature-item"><i class="fas fa-database"></i><?php echo htmlspecialchars($itx['feature_db']); ?></div>
                    <div class="auth-feature-item"><i class="fas fa-user-shield"></i><?php echo htmlspecialchars($itx['feature_admin']); ?></div>
                    <div class="auth-feature-item"><i class="fas fa-sliders-h"></i><?php echo htmlspecialchars($itx['feature_suite']); ?></div>
                </div>
                <div class="login-showcase__trust">
                    <i class="fas fa-shield-check"></i>
                    <span><?php echo htmlspecialchars($itx['trust']); ?></span>
                </div>
            </div>
            <div class="auth-panel__form login-access">
                <div class="login-access-shell">
                    <div class="login-access-intro">
                        <span class="login-access-intro__eyebrow"><?php echo htmlspecialchars($itx['brand']); ?></span>
                        <span class="login-access-intro__text"><?php echo htmlspecialchars($itx['showcase_card_text']); ?></span>
                    </div>
                    <div class="login-access-card">
                    <h2 class="auth-card__title"><?php echo htmlspecialchars($itx['card_title']); ?></h2>
                    <p class="auth-card__subtitle"><?php echo htmlspecialchars($itx['card_subtitle']); ?></p>

                    <div class="admin-form-stepper install-wizard-stepper" data-install-stepper>
                        <div class="admin-form-step is-active" data-step-indicator="0">
                            <span class="admin-form-step__index">1</span>
                            <div>
                                <strong><?php echo htmlspecialchars($itx['step_db']); ?></strong>
                                <small><?php echo htmlspecialchars($itx['step_db_lead']); ?></small>
                            </div>
                        </div>
                        <div class="admin-form-step" data-step-indicator="1">
                            <span class="admin-form-step__index">2</span>
                            <div>
                                <strong><?php echo htmlspecialchars($itx['step_admin']); ?></strong>
                                <small><?php echo htmlspecialchars($itx['step_admin_lead']); ?></small>
                            </div>
                        </div>
                        <div class="admin-form-step" data-step-indicator="2">
                            <span class="admin-form-step__index">3</span>
                            <div>
                                <strong><?php echo htmlspecialchars($itx['step_mail']); ?></strong>
                                <small><?php echo htmlspecialchars($itx['step_mail_lead']); ?></small>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="/install" class="row g-3 login-form install-wizard" data-install-wizard>
                        <?php echo CSRF::field(); ?>

                        <div class="col-12 install-wizard__panel" data-step-panel="0">
                            <h3 class="auth-form-section"><?php echo htmlspecialchars($itx['section_db']); ?></h3>
                        </div>
                        <div class="col-md-6 install-wizard__panel" data-step-panel="0">
                            <label class="form-label"><?php echo htmlspecialchars($itx['host']); ?></label>
                            <input class="form-control" type="text" name="db_host" value="<?php echo $old('db_host', 'localhost'); ?>" required data-step-required="0">
                        </div>
                        <div class="col-md-6 install-wizard__panel" data-step-panel="0">
                            <label class="form-label"><?php echo htmlspecialchars($itx['db_name']); ?></label>
                            <input class="form-control" type="text" name="db_name" value="<?php echo $old('db_name', 'coresuite_lite'); ?>" required data-step-required="0">
                        </div>
                        <div class="col-md-6 install-wizard__panel" data-step-panel="0">
                            <label class="form-label"><?php echo htmlspecialchars($itx['user']); ?></label>
                            <input class="form-control" type="text" name="db_user" value="<?php echo $old('db_user'); ?>" required data-step-required="0">
                        </div>
                        <div class="col-md-6 install-wizard__panel" data-step-panel="0">
                            <label class="form-label"><?php echo htmlspecialchars($itx['password']); ?></label>
                            <input class="form-control" type="password" name="db_pass">
                        </div>

                        <div class="col-12 mt-2 install-wizard__panel" data-step-panel="1" hidden><h3 class="auth-form-section"><?php echo htmlspecialchars($itx['section_admin']); ?></h3></div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="1" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['name']); ?></label>
                            <input class="form-control" type="text" name="admin_name" value="<?php echo $old('admin_name'); ?>" required data-step-required="1">
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="1" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['email']); ?></label>
                            <input class="form-control" type="email" name="admin_email" value="<?php echo $old('admin_email'); ?>" required data-step-required="1">
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="1" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['password']); ?></label>
                            <input class="form-control" type="password" name="admin_pass" required data-step-required="1">
                        </div>

                        <div class="col-12 mt-2 install-wizard__panel" data-step-panel="2" hidden><h3 class="auth-form-section"><?php echo htmlspecialchars($itx['section_mail']); ?></h3></div>
                        <div class="col-12 install-wizard__panel" data-step-panel="2" hidden>
                            <p class="form-text mt-0"><?php echo htmlspecialchars($itx['section_mail_lead']); ?></p>
                        </div>
                        <div class="col-md-6 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['app_url']); ?></label>
                            <input class="form-control" type="url" name="app_url" value="<?php echo $old('app_url', 'http://127.0.0.1:8080'); ?>" placeholder="https://suite.example.com">
                            <div class="form-text"><?php echo htmlspecialchars($itx['app_url_help']); ?></div>
                        </div>
                        <div class="col-md-6 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['mail_driver']); ?></label>
                            <select class="form-select" name="mail_driver">
                                <option value="disabled" <?php echo ($old('mail_driver', 'disabled') === 'disabled') ? 'selected' : ''; ?>><?php echo htmlspecialchars($itx['mail_driver_disabled']); ?></option>
                                <option value="log" <?php echo ($old('mail_driver', 'disabled') === 'log') ? 'selected' : ''; ?>><?php echo htmlspecialchars($itx['mail_driver_log']); ?></option>
                                <option value="smtp" <?php echo ($old('mail_driver', 'disabled') === 'smtp') ? 'selected' : ''; ?>><?php echo htmlspecialchars($itx['mail_driver_smtp']); ?></option>
                                <option value="resend" <?php echo ($old('mail_driver', 'disabled') === 'resend') ? 'selected' : ''; ?>><?php echo htmlspecialchars($itx['mail_driver_resend']); ?></option>
                            </select>
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['mail_from_name']); ?></label>
                            <input class="form-control" type="text" name="mail_from_name" value="<?php echo $old('mail_from_name', 'CoreSuite Lite'); ?>">
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['mail_from_email']); ?></label>
                            <input class="form-control" type="email" name="mail_from_email" value="<?php echo $old('mail_from_email'); ?>" placeholder="no-reply@example.com">
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['mail_reply_to']); ?></label>
                            <input class="form-control" type="email" name="mail_reply_to" value="<?php echo $old('mail_reply_to'); ?>" placeholder="support@example.com">
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['smtp_host']); ?></label>
                            <input class="form-control" type="text" name="smtp_host" value="<?php echo $old('smtp_host'); ?>" placeholder="smtp.example.com">
                        </div>
                        <div class="col-md-2 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['smtp_port']); ?></label>
                            <input class="form-control" type="number" name="smtp_port" value="<?php echo $old('smtp_port', '587'); ?>" min="1" max="65535">
                        </div>
                        <div class="col-md-3 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['smtp_username']); ?></label>
                            <input class="form-control" type="text" name="smtp_username" value="<?php echo $old('smtp_username'); ?>">
                        </div>
                        <div class="col-md-3 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['smtp_password']); ?></label>
                            <input class="form-control" type="password" name="smtp_password">
                        </div>
                        <div class="col-md-2 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['smtp_timeout']); ?></label>
                            <input class="form-control" type="number" name="smtp_timeout" value="<?php echo $old('smtp_timeout', '15'); ?>" min="1" max="120">
                        </div>
                        <div class="col-md-3 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['smtp_encryption']); ?></label>
                            <select class="form-select" name="smtp_encryption">
                                <?php $smtpEncryption = $old('smtp_encryption', 'tls'); ?>
                                <option value="none" <?php echo $smtpEncryption === 'none' ? 'selected' : ''; ?>>none</option>
                                <option value="tls" <?php echo $smtpEncryption === 'tls' ? 'selected' : ''; ?>>tls</option>
                                <option value="ssl" <?php echo $smtpEncryption === 'ssl' ? 'selected' : ''; ?>>ssl</option>
                            </select>
                        </div>
                        <div class="col-md-5 d-flex align-items-end install-wizard__panel" data-step-panel="2" hidden>
                            <label class="workspace-settings-toggle w-100 mb-0">
                                <input type="checkbox" name="smtp_auth_enabled" value="1" <?php echo !isset($_POST['mail_driver']) || !empty($_POST['smtp_auth_enabled']) ? 'checked' : ''; ?>>
                                <span><strong><?php echo htmlspecialchars($itx['smtp_auth_enabled']); ?></strong><small><?php echo htmlspecialchars($itx['secret_hint']); ?></small></span>
                            </label>
                        </div>
                        <div class="col-md-4 install-wizard__panel" data-step-panel="2" hidden>
                            <label class="form-label"><?php echo htmlspecialchars($itx['resend_api_key']); ?></label>
                            <input class="form-control" type="password" name="resend_api_key">
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2 install-wizard__actions">
                            <button class="btn btn-outline-secondary" type="button" data-step-back hidden><?php echo htmlspecialchars($itx['back']); ?></button>
                            <button class="btn btn-primary ms-auto" type="button" data-step-next><?php echo htmlspecialchars($itx['next']); ?></button>
                            <button class="btn btn-primary ms-auto login-submit" type="submit" data-step-submit hidden><?php echo htmlspecialchars($itx['submit']); ?></button>
                        </div>
                        <div class="col-12">
                            <p class="login-submit__meta"><?php echo htmlspecialchars($itx['submit_meta']); ?></p>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>window.__uiText = <?php echo json_encode(\Core\Locale::clientStrings()); ?>;</script>
    <script src="<?php echo $assetBase; ?>/js/app.js"></script>
    <script>
        (function () {
            var wizard = document.querySelector('[data-install-wizard]');
            var stepper = document.querySelector('[data-install-stepper]');
            if (!wizard || !stepper) {
                return;
            }

            var currentStep = 0;
            var panels = Array.prototype.slice.call(wizard.querySelectorAll('[data-step-panel]'));
            var indicators = Array.prototype.slice.call(stepper.querySelectorAll('[data-step-indicator]'));
            var backButton = wizard.querySelector('[data-step-back]');
            var nextButton = wizard.querySelector('[data-step-next]');
            var submitButton = wizard.querySelector('[data-step-submit]');

            function syncStep(step) {
                currentStep = step;
                panels.forEach(function (panel) {
                    var panelStep = Number(panel.getAttribute('data-step-panel'));
                    panel.hidden = panelStep !== currentStep;
                });
                indicators.forEach(function (item) {
                    var itemStep = Number(item.getAttribute('data-step-indicator'));
                    item.classList.toggle('is-active', itemStep === currentStep);
                });
                if (backButton) {
                    backButton.hidden = currentStep === 0;
                }
                if (nextButton) {
                    nextButton.hidden = currentStep === 2;
                }
                if (submitButton) {
                    submitButton.hidden = currentStep !== 2;
                }
            }

            function validateStep(step) {
                var fields = wizard.querySelectorAll('[data-step-required="' + step + '"]');
                for (var i = 0; i < fields.length; i += 1) {
                    if (!fields[i].reportValidity()) {
                        return false;
                    }
                }
                return true;
            }

            if (nextButton) {
                nextButton.addEventListener('click', function () {
                    if (!validateStep(currentStep)) {
                        return;
                    }
                    syncStep(Math.min(currentStep + 1, 2));
                });
            }

            if (backButton) {
                backButton.addEventListener('click', function () {
                    syncStep(Math.max(currentStep - 1, 0));
                });
            }

            syncStep(0);
        }());
    </script>
</body>
</html>
