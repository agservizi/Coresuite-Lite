<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'CoreSuite Lite'; ?></title>
    <!-- Bulma removed: using Tailwind-only styles now -->
    <!-- Tailwind compiled CSS (build with npm run build:css) -->
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <!-- Font icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Legacy theme / overrides -->
    <link rel="stylesheet" href="/assets/css/theme.css">
    <meta name="csrf-token" content="<?php echo htmlspecialchars(\CSRF::generateToken()); ?>">
</head>
<body class="app-layout">
    <?php include __DIR__ . '/partials/topbar.php'; ?>

    <div class="main-content">
        <section class="section">
            <div class="container">
                <?php include __DIR__ . '/partials/flash.php'; ?>
                <h1 class="title"><?php echo $pageTitle ?? 'Dashboard'; ?></h1>
                <?php echo $content ?? ''; ?>
            </div>
        </section>
    </div>

    <?php include __DIR__ . '/partials/footer.php'; ?>

    <script src="/assets/js/app.js"></script>
</body>
</html>