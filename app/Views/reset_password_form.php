<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuova Password - CoreSuite Lite</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/theme.css">
</head>
<body class="login-page">
<div class="auth-theme-toggle">
    <div class="select is-small theme-mode-select">
        <select id="themeModeToggle" aria-label="Seleziona tema">
            <option value="light">Light</option>
            <option value="dark">Dark</option>
            <option value="system">System</option>
        </select>
    </div>
</div>

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <div class="box">
                    <h1 class="title">Imposta nuova password</h1>

                    <?php if (isset($error)): ?>
                        <div class="notification is-danger is-light"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <?php if (isset($message)): ?>
                        <div class="notification is-success is-light"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/reset-password/<?php echo urlencode($token ?? ''); ?>">
                        <?php echo CSRF::field(); ?>
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" type="password" name="password" placeholder="Nuova password" required minlength="8">
                                <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" type="password" name="confirm" placeholder="Conferma password" required minlength="8">
                                <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        <button class="button is-primary is-fullwidth" type="submit">Aggiorna password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/js/app.js"></script>
</body>
</html>
