<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione - CoreSuite Lite</title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="stylesheet" href="/assets/css/theme.css">
</head>
<body class="login-page">
    <div class="auth-theme-toggle">
        <div class="theme-mode-select">
            <select id="themeModeToggle" aria-label="Seleziona tema">
                <option value="light">Light</option>
                <option value="dark">Dark</option>
                <option value="system">System</option>
            </select>
        </div>
    </div>

    <main class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-2xl px-6">
            <div class="bg-white border rounded-lg p-6 shadow">
                <h1 class="text-2xl font-bold">Installazione CoreSuite Lite</h1>
                <p class="text-sm text-gray-600 mb-4">Configura il database e crea l'amministratore</p>

                <form method="POST" action="/install" class="space-y-4">
                    <?php echo CSRF::field(); ?>
                    <h2 class="text-lg font-semibold">Database</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Host</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="text" name="db_host" value="localhost" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome Database</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="text" name="db_name" value="coresuite_lite" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Utente</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="text" name="db_user" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="password" name="db_pass">
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold mt-4">Amministratore</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="text" name="admin_name" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="email" name="admin_email" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input class="w-full rounded border px-3 py-2" type="password" name="admin_pass" required>
                        </div>
                    </div>

                    <div>
                        <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" type="submit">Installa</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="/assets/js/app.js"></script>
</body>
</html>