<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars(\Core\Locale::current()); ?>">
<head>
    <?php
    $resetFormText = [
        'it' => [
            'title' => 'Nuova Password - CoreSuite Lite',
            'aria_locale' => 'Seleziona lingua',
            'aria_theme' => 'Seleziona tema',
            'theme_light' => 'Light',
            'theme_dark' => 'Dark',
            'theme_system' => 'System',
            'brand' => 'Nuova password',
            'eyebrow' => 'Password reset',
            'hero_title' => 'Imposta una nuova password',
            'hero_subtitle' => 'Scegli una password robusta e confermala per completare il recupero dell account.',
            'showcase_title' => 'Chiudi il recupero con un passaggio chiaro e sicuro',
            'showcase_lead' => 'La nuova password viene impostata dentro una schermata coerente con l intero blocco auth, senza rotture visive.',
            'feature_1' => 'Password aggiornata con token temporaneo',
            'feature_2' => 'Esperienza coerente con login e recupero accesso',
            'feature_3' => 'Form essenziale, leggibile e focalizzato',
            'trust' => 'La nuova password viene salvata solo dopo la conferma completa',
            'password' => 'Nuova password',
            'password_confirm' => 'Conferma password',
            'submit' => 'Aggiorna password',
            'submit_meta' => 'Aggiornamento sicuro delle credenziali',
        ],
        'en' => [
            'title' => 'New Password - CoreSuite Lite',
            'aria_locale' => 'Select language',
            'aria_theme' => 'Select theme',
            'theme_light' => 'Light',
            'theme_dark' => 'Dark',
            'theme_system' => 'System',
            'brand' => 'New password',
            'eyebrow' => 'Password reset',
            'hero_title' => 'Set a new password',
            'hero_subtitle' => 'Choose a strong password and confirm it to complete account recovery.',
            'showcase_title' => 'Complete recovery with a clear and secure step',
            'showcase_lead' => 'The new password is set inside a screen aligned with the whole auth flow, without visual breaks.',
            'feature_1' => 'Password updated through a temporary token',
            'feature_2' => 'Experience aligned with login and account recovery',
            'feature_3' => 'Essential, readable, focused form',
            'trust' => 'The new password is saved only after full confirmation',
            'password' => 'New password',
            'password_confirm' => 'Confirm password',
            'submit' => 'Update password',
            'submit_meta' => 'Secure credential update',
        ],
        'fr' => [
            'title' => 'Nouveau mot de passe - CoreSuite Lite',
            'aria_locale' => 'Selectionner la langue',
            'aria_theme' => 'Selectionner le theme',
            'theme_light' => 'Clair',
            'theme_dark' => 'Sombre',
            'theme_system' => 'Systeme',
            'brand' => 'Nouveau mot de passe',
            'eyebrow' => 'Reset mot de passe',
            'hero_title' => 'Definir un nouveau mot de passe',
            'hero_subtitle' => 'Choisissez un mot de passe solide et confirmez-le pour terminer la recuperation du compte.',
            'showcase_title' => 'Finalisez la recuperation avec une etape claire et sure',
            'showcase_lead' => 'Le nouveau mot de passe est defini dans un ecran coherent avec tout le bloc auth, sans rupture visuelle.',
            'feature_1' => 'Mot de passe mis a jour via un token temporaire',
            'feature_2' => 'Experience alignee avec login et recuperation',
            'feature_3' => 'Formulaire essentiel, lisible et focalise',
            'trust' => 'Le mot de passe est enregistre uniquement apres confirmation complete',
            'password' => 'Nouveau mot de passe',
            'password_confirm' => 'Confirmer le mot de passe',
            'submit' => 'Mettre a jour le mot de passe',
            'submit_meta' => 'Mise a jour securisee des identifiants',
        ],
        'es' => [
            'title' => 'Nueva Contrasena - CoreSuite Lite',
            'aria_locale' => 'Selecciona idioma',
            'aria_theme' => 'Selecciona tema',
            'theme_light' => 'Claro',
            'theme_dark' => 'Oscuro',
            'theme_system' => 'Sistema',
            'brand' => 'Nueva contrasena',
            'eyebrow' => 'Reset de contrasena',
            'hero_title' => 'Define una nueva contrasena',
            'hero_subtitle' => 'Elige una contrasena robusta y confirmala para completar la recuperacion de la cuenta.',
            'showcase_title' => 'Cierra la recuperacion con un paso claro y seguro',
            'showcase_lead' => 'La nueva contrasena se define dentro de una pantalla coherente con todo el flujo auth, sin cortes visuales.',
            'feature_1' => 'Contrasena actualizada mediante token temporal',
            'feature_2' => 'Experiencia alineada con login y recuperacion',
            'feature_3' => 'Formulario esencial, legible y enfocado',
            'trust' => 'La nueva contrasena se guarda solo tras la confirmacion completa',
            'password' => 'Nueva contrasena',
            'password_confirm' => 'Confirmar contrasena',
            'submit' => 'Actualizar contrasena',
            'submit_meta' => 'Actualizacion segura de credenciales',
        ],
    ];
    $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    $assetBase = (is_string($docRoot) && is_file(rtrim($docRoot, '/') . '/assets/css/bootstrap.css'))
        ? '/assets'
        : '/public/assets';
    $rft = $resetFormText[\Core\Locale::current()] ?? $resetFormText['it'];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($rft['title']); ?></title>
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
        <div class="auth-utility-group auth-locale-switch" role="navigation" aria-label="<?php echo htmlspecialchars($rft['aria_locale']); ?>">
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
        <div class="auth-utility-group auth-theme-switch" role="group" aria-label="<?php echo htmlspecialchars($rft['aria_theme']); ?>">
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="light" aria-label="<?php echo htmlspecialchars($rft['theme_light']); ?>" title="<?php echo htmlspecialchars($rft['theme_light']); ?>">
                <i class="fas fa-sun"></i>
            </button>
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="dark" aria-label="<?php echo htmlspecialchars($rft['theme_dark']); ?>" title="<?php echo htmlspecialchars($rft['theme_dark']); ?>">
                <i class="fas fa-moon"></i>
            </button>
            <button type="button" class="auth-utility-chip auth-utility-chip--icon" data-theme="system" aria-label="<?php echo htmlspecialchars($rft['theme_system']); ?>" title="<?php echo htmlspecialchars($rft['theme_system']); ?>">
                <i class="fas fa-desktop"></i>
            </button>
        </div>
    </div>

    <main class="auth-shell auth-shell--login">
        <section class="auth-panel auth-panel--split login-stage">
            <div class="auth-panel__brand login-showcase">
                <div class="login-showcase__topline"><?php echo htmlspecialchars($rft['eyebrow']); ?></div>
                <div class="auth-brand-mark"><i class="fas fa-lock"></i><?php echo htmlspecialchars($rft['brand']); ?></div>
                <h1 class="auth-panel__title"><?php echo htmlspecialchars($rft['hero_title']); ?></h1>
                <p class="auth-panel__lead"><?php echo htmlspecialchars($rft['hero_subtitle']); ?></p>
                <div class="login-showcase__body">
                    <p class="login-showcase__card-eyebrow"><?php echo htmlspecialchars($rft['brand']); ?></p>
                    <h2><?php echo htmlspecialchars($rft['showcase_title']); ?></h2>
                    <p><?php echo htmlspecialchars($rft['showcase_lead']); ?></p>
                </div>
                <div class="auth-feature-list">
                    <div class="auth-feature-item"><i class="fas fa-key"></i><?php echo htmlspecialchars($rft['feature_1']); ?></div>
                    <div class="auth-feature-item"><i class="fas fa-layer-group"></i><?php echo htmlspecialchars($rft['feature_2']); ?></div>
                    <div class="auth-feature-item"><i class="fas fa-check-circle"></i><?php echo htmlspecialchars($rft['feature_3']); ?></div>
                </div>
                <div class="login-showcase__trust">
                    <i class="fas fa-shield-check"></i>
                    <span><?php echo htmlspecialchars($rft['trust']); ?></span>
                </div>
            </div>
            <div class="auth-panel__form login-access">
                <div class="login-access-shell">
                    <div class="login-access-intro">
                        <span class="login-access-intro__eyebrow"><?php echo htmlspecialchars($rft['brand']); ?></span>
                        <span class="login-access-intro__text"><?php echo htmlspecialchars($rft['showcase_lead']); ?></span>
                    </div>
                    <section class="login-access-card">
                        <h1 class="auth-card__title"><?php echo htmlspecialchars($rft['hero_title']); ?></h1>
                        <p class="auth-card__subtitle"><?php echo htmlspecialchars($rft['hero_subtitle']); ?></p>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <?php if (isset($message)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="/reset-password/<?php echo urlencode($token ?? ''); ?>" class="row g-3 login-form">
                            <?php echo CSRF::field(); ?>
                            <div class="col-12">
                                <label class="form-label"><?php echo htmlspecialchars($rft['password']); ?></label>
                                <div class="login-input-group">
                                    <span class="login-input-group__icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                                    <input class="form-control" type="password" name="password" placeholder="<?php echo htmlspecialchars($rft['password']); ?>" required minlength="8">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?php echo htmlspecialchars($rft['password_confirm']); ?></label>
                                <div class="login-input-group">
                                    <span class="login-input-group__icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                                    <input class="form-control" type="password" name="confirm" placeholder="<?php echo htmlspecialchars($rft['password_confirm']); ?>" required minlength="8">
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 login-submit" type="submit"><?php echo htmlspecialchars($rft['submit']); ?></button>
                                <p class="login-submit__meta"><?php echo htmlspecialchars($rft['submit_meta']); ?></p>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </main>
    <script>window.__uiText = <?php echo json_encode(\Core\Locale::clientStrings()); ?>;</script>
    <script src="<?php echo $assetBase; ?>/js/app.js"></script>
</body>
</html>
