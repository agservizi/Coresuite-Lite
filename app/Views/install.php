<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione - CoreSuite Lite</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
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
                <div class="column is-6 is-offset-3">
                    <div class="box">
                        <h1 class="title">Installazione CoreSuite Lite</h1>
                        <p class="subtitle">Configura il database e crea l'amministratore</p>

                        <form method="POST" action="/install">
                            <h2 class="subtitle">Database</h2>
                            <div class="field">
                                <label class="label">Host</label>
                                <div class="control">
                                    <input class="input" type="text" name="db_host" value="localhost" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Nome Database</label>
                                <div class="control">
                                    <input class="input" type="text" name="db_name" value="coresuite_lite" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Utente</label>
                                <div class="control">
                                    <input class="input" type="text" name="db_user" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" type="password" name="db_pass">
                                </div>
                            </div>

                            <h2 class="subtitle">Amministratore</h2>
                            <div class="field">
                                <label class="label">Nome</label>
                                <div class="control">
                                    <input class="input" type="text" name="admin_name" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control">
                                    <input class="input" type="email" name="admin_email" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" type="password" name="admin_pass" required>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <button class="button is-primary is-fullwidth" type="submit">
                                        Installa
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/assets/js/app.js"></script>
</body>
</html>