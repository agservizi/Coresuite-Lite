<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars(\Core\Locale::current()); ?>">
<head>
    <?php
    $resetText = [
        'it' => [
            'title' => 'Reset Password - CoreSuite Lite',
            'aria_locale' => 'Seleziona lingua',
            'aria_theme' => 'Seleziona tema',
            'theme_light' => 'Light',
            'theme_dark' => 'Dark',
            'theme_system' => 'System',
            'brand' => 'Recupero accesso',
            'eyebrow' => 'Account recovery',
            'hero_title' => 'Recupera la tua password',
            'hero_subtitle' => 'Inserisci l indirizzo email associato all account. Se presente, riceverai le istruzioni per il reset.',
            'showcase_title' => 'Riprendi l accesso senza uscire dall ecosistema',
            'showcase_lead' => 'Il recupero mantiene lo stesso linguaggio operativo della suite e riduce la frizione nei passaggi sensibili.',
            'feature_1' => 'Reset guidato e messaggi di sicurezza coerenti',
            'feature_2' => 'Stessa esperienza visuale di login e workspace',
            'feature_3' => 'Protezione anti-enumerazione e token temporanei',
            'trust' => 'Il link di recupero viene generato solo per account attivi e validi',
            'email' => 'Email',
            'submit' => 'Invia link di reset',
            'back_login' => 'Torna al login',
            'submit_meta' => 'Invio sicuro del link di recupero',
        ],
        'en' => [
            'title' => 'Reset Password - CoreSuite Lite',
            'aria_locale' => 'Select language',
            'aria_theme' => 'Select theme',
            'theme_light' => 'Light',
            'theme_dark' => 'Dark',
            'theme_system' => 'System',
            'brand' => 'Access recovery',
            'eyebrow' => 'Account recovery',
            'hero_title' => 'Recover your password',
            'hero_subtitle' => 'Enter the email address associated with the account. If it exists, you will receive reset instructions.',
            'showcase_title' => 'Regain access without leaving the ecosystem',
            'showcase_lead' => 'Recovery keeps the same operational language as the suite and reduces friction in sensitive flows.',
            'feature_1' => 'Guided reset and consistent security messaging',
            'feature_2' => 'Same visual experience as login and workspace',
            'feature_3' => 'Anti-enumeration protection and temporary tokens',
            'trust' => 'Recovery links are generated only for valid active accounts',
            'email' => 'Email',
            'submit' => 'Send reset link',
            'back_login' => 'Back to login',
            'submit_meta' => 'Secure recovery link delivery',
        ],
        'fr' => [
            'title' => 'Reinitialisation mot de passe - CoreSuite Lite',
            'aria_locale' => 'Selectionner la langue',
            'aria_theme' => 'Selectionner le theme',
            'theme_light' => 'Clair',
            'theme_dark' => 'Sombre',
            'theme_system' => 'Systeme',
            'brand' => 'Recuperation acces',
            'eyebrow' => 'Recuperation compte',
            'hero_title' => 'Recuperez votre mot de passe',
            'hero_subtitle' => 'Saisissez l adresse email associee au compte. Si elle existe, vous recevrez les instructions de reinitialisation.',
            'showcase_title' => 'Retrouvez l acces sans quitter l ecosysteme',
            'showcase_lead' => 'La recuperation garde le meme langage operationnel que la suite et reduit la friction dans les etapes sensibles.',
            'feature_1' => 'Reset guide et messages de securite coherents',
            'feature_2' => 'Meme experience visuelle que le login et le workspace',
            'feature_3' => 'Protection anti-enumeration et tokens temporaires',
            'trust' => 'Le lien est genere uniquement pour des comptes actifs et valides',
            'email' => 'Email',
            'submit' => 'Envoyer le lien de reset',
            'back_login' => 'Retour au login',
            'submit_meta' => 'Envoi securise du lien de recuperation',
        ],
        'es' => [
            'title' => 'Reset Password - CoreSuite Lite',
            'aria_locale' => 'Selecciona idioma',
            'aria_theme' => 'Selecciona tema',
            'theme_light' => 'Claro',
            'theme_dark' => 'Oscuro',
            'theme_system' => 'Sistema',
            'brand' => 'Recuperacion de acceso',
            'eyebrow' => 'Recuperacion de cuenta',
            'hero_title' => 'Recupera tu contrasena',
            'hero_subtitle' => 'Introduce el email asociado a la cuenta. Si existe, recibiras las instrucciones para el reset.',
            'showcase_title' => 'Recupera el acceso sin salir del ecosistema',
            'showcase_lead' => 'La recuperacion mantiene el mismo lenguaje operativo de la suite y reduce friccion en los flujos sensibles.',
            'feature_1' => 'Reset guiado y mensajes de seguridad coherentes',
            'feature_2' => 'La misma experiencia visual que login y workspace',
            'feature_3' => 'Proteccion anti-enumeracion y tokens temporales',
            'trust' => 'El enlace se genera solo para cuentas activas y validas',
            'email' => 'Email',
            'submit' => 'Enviar enlace de reset',
            'back_login' => 'Volver al login',
            'submit_meta' => 'Envio seguro del enlace de recuperacion',
        ],
    ];
    $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    $assetBase = (is_string($docRoot) && is_file(rtrim($docRoot, '/') . '/assets/css/bootstrap.css'))
        ? '/assets'
        : '/public/assets';
    $rt = $resetText[\Core\Locale::current()] ?? $resetText['it'];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($rt['title']); ?></title>
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="<?php echo $assetBase; ?>/css/bootstrap.css">
    <?php include __DIR__ . '/partials/fontawesome.php'; ?>
    <link rel="stylesheet" href="<?php echo $assetBase; ?>/css/theme.css">
</head>
<body class="login-page login-page--suite">
    <div class="login-scene" aria-hidden="true">
        <div class="login-scene__orb login-scene__orb--a"></div>
        <div class="login-scene__orb login-scene__orb--b"></div>
        <div class="login-scene__grid"></div>
    </div>
    <div class="auth-theme-toggle" aria-label="Auth utilities">
        <div class="auth-utility-group auth-locale-switch" role="navigation" aria-label="<?php echo htmlspecialchars($rt['aria_locale']); ?>">
            <?php foreach (\Core\Locale::supported() as $localeCode => $localeLabel): ?>
                <a
                    href="<?php echo htmlspecialchars(\Core\Locale::switchUrl($localeCode, $_SERVER['REQUEST_URI'] ?? '/reset-password')); ?>"
                    class="auth-utility-chip <?php echo \Core\Locale::current() === $localeCode ? 'is-active' : ''; ?>"
                    lang="<?php echo htmlspecialchars($localeCode); ?>"
                >
                    <?php echo htmlspecialchars(strtoupper($localeCode)); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="auth-utility-group auth-theme-switch" role="group" aria-label="<?php echo htmlspecialchars($rt['aria_theme']); ?>">
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="light" aria-label="<?php echo htmlspecialchars($rt['theme_light']); ?>" title="<?php echo htmlspecialchars($rt['theme_light']); ?>">
                <i class="fas fa-sun"></i>
            </button>
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="dark" aria-label="<?php echo htmlspecialchars($rt['theme_dark']); ?>" title="<?php echo htmlspecialchars($rt['theme_dark']); ?>">
                <i class="fas fa-moon"></i>
            </button>
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="system" aria-label="<?php echo htmlspecialchars($rt['theme_system']); ?>" title="<?php echo htmlspecialchars($rt['theme_system']); ?>">
                <i class="fas fa-desktop"></i>
            </button>
        </div>
    </div>

    <main class="auth-shell auth-shell--login">
        <section class="auth-panel auth-panel--split login-stage">
            <div class="auth-panel__brand login-showcase">
                <div class="login-showcase__topline"><?php echo htmlspecialchars($rt['eyebrow']); ?></div>
                <div class="auth-brand-mark"><i class="fas fa-key"></i><?php echo htmlspecialchars($rt['brand']); ?></div>
                <h1 class="auth-panel__title"><?php echo htmlspecialchars($rt['hero_title']); ?></h1>
                <p class="auth-panel__lead"><?php echo htmlspecialchars($rt['hero_subtitle']); ?></p>
                <div class="login-showcase__body">
                    <p class="login-showcase__card-eyebrow"><?php echo htmlspecialchars($rt['brand']); ?></p>
                    <h2><?php echo htmlspecialchars($rt['showcase_title']); ?></h2>
                    <p><?php echo htmlspecialchars($rt['showcase_lead']); ?></p>
                </div>
                <div class="auth-feature-list">
                    <div class="auth-feature-item"><i class="fas fa-envelope-open-text"></i><?php echo htmlspecialchars($rt['feature_1']); ?></div>
                    <div class="auth-feature-item"><i class="fas fa-layer-group"></i><?php echo htmlspecialchars($rt['feature_2']); ?></div>
                    <div class="auth-feature-item"><i class="fas fa-shield-alt"></i><?php echo htmlspecialchars($rt['feature_3']); ?></div>
                </div>
                <div class="login-showcase__trust">
                    <i class="fas fa-shield-check"></i>
                    <span><?php echo htmlspecialchars($rt['trust']); ?></span>
                </div>
            </div>
            <div class="auth-panel__form login-access">
                <div class="login-access-shell">
                    <div class="login-access-intro">
                        <span class="login-access-intro__eyebrow"><?php echo htmlspecialchars($rt['brand']); ?></span>
                        <span class="login-access-intro__text"><?php echo htmlspecialchars($rt['showcase_lead']); ?></span>
                    </div>
                    <section class="login-access-card">
                        <h1 class="auth-card__title"><?php echo htmlspecialchars($rt['hero_title']); ?></h1>
                        <p class="auth-card__subtitle"><?php echo htmlspecialchars($rt['hero_subtitle']); ?></p>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <?php if (isset($message)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="/reset-password" class="row g-3 login-form">
                            <?php echo CSRF::field(); ?>
                            <div class="col-12">
                                <label class="form-label"><?php echo htmlspecialchars($rt['email']); ?></label>
                                <div class="login-input-group">
                                    <span class="login-input-group__icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                                    <input class="form-control" type="email" name="email" placeholder="<?php echo htmlspecialchars($rt['email']); ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 login-submit" type="submit"><?php echo htmlspecialchars($rt['submit']); ?></button>
                                <p class="login-submit__meta"><?php echo htmlspecialchars($rt['submit_meta']); ?></p>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="/login" class="text-decoration-none"><?php echo htmlspecialchars($rt['back_login']); ?></a>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
    <script>window.__uiText = <?php echo json_encode(\Core\Locale::clientStrings()); ?>;</script>
    <script src="<?php echo $assetBase; ?>/js/app.js"></script>
</body>
</html>
