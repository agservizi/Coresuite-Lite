<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - CoreSuite Lite</title>
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
                    <h1 class="title">Recupero Password</h1>
                    <p class="subtitle">Inserisci la tua email</p>

                    <?php if (isset($error)): ?>
                        <div class="notification is-danger is-light"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <?php if (isset($message)): ?>
                        <div class="notification is-success is-light"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/reset-password">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" type="email" name="email" placeholder="Email" required>
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                        </div>
                        <button class="button is-primary is-fullwidth" type="submit">Invia link di reset</button>
                    </form>

                    <div class="mt-4">
                        <a href="/login">Torna al login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/js/app.js"></script>
</body>
</html>
