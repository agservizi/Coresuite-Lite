<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars(\Core\Locale::current()); ?>">
<head>
    <?php
    $workspaceDefaults = \Core\WorkspaceSettings::all();
    $clientStrings = \Core\Locale::clientStrings();
    $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    $assetBase = (is_string($docRoot) && is_file(rtrim($docRoot, '/') . '/assets/css/bootstrap.css'))
        ? '/assets'
        : '/public/assets';
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'CoreSuite Lite'; ?></title>
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="<?php echo $assetBase; ?>/css/bootstrap.css">
    <?php include __DIR__ . '/partials/fontawesome.php'; ?>
    <link rel="stylesheet" href="<?php echo $assetBase; ?>/css/theme.css">
    <meta name="csrf-token" content="<?php echo htmlspecialchars(\CSRF::generateToken()); ?>">
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/partials/topbar.php'; ?>

    <div class="admin-app">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <main class="admin-main" id="adminMain">
            <div class="admin-page-head">
                <h1 class="admin-page-title"><?php echo htmlspecialchars($pageTitle ?? 'Dashboard'); ?></h1>
            </div>

            <div class="admin-content">
                <?php include __DIR__ . '/partials/flash.php'; ?>
                <?php echo $content ?? ''; ?>
            </div>

            <?php include __DIR__ . '/partials/footer.php'; ?>
        </main>
    </div>

    <button
        type="button"
        class="back-to-top"
        id="backToTop"
        aria-label="<?php echo htmlspecialchars((string)($clientStrings['back_to_top'] ?? 'Back to top')); ?>"
        title="<?php echo htmlspecialchars((string)($clientStrings['back_to_top'] ?? 'Back to top')); ?>"
        hidden
    >
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="<?php echo $assetBase; ?>/js/bootstrap.bundle.min.js"></script>
    <script>
        window.__assetBase = <?php echo json_encode($assetBase); ?>;
        window.__uiText = <?php echo json_encode($clientStrings); ?>;
        window.__workspaceDefaults = <?php echo json_encode([
            'defaultTheme' => (string)($workspaceDefaults['default_theme'] ?? 'system'),
            'sidebarCollapsedDefault' => !empty($workspaceDefaults['sidebar_collapsed_default']),
            'spotlightHintsEnabled' => !empty($workspaceDefaults['spotlight_hints_enabled']),
        ]); ?>;
    </script>
    <script src="<?php echo $assetBase; ?>/js/highcharts.js"></script>
    <script src="<?php echo $assetBase; ?>/js/app.js"></script>
</body>
</html>
