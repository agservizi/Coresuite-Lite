<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuova Password - CoreSuite Lite</title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    <div class="w-full max-w-md px-6">
        <div class="bg-white border rounded-lg p-6 shadow">
            <h1 class="text-2xl font-bold">Imposta nuova password</h1>

            <?php if (isset($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-800 p-3 rounded mb-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if (isset($message)): ?>
                <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded mb-3"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" action="/reset-password/<?php echo urlencode($token ?? ''); ?>" class="space-y-4">
                <?php echo CSRF::field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nuova password</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-gray-400"><i class="fas fa-lock"></i></span>
                        <input class="flex-1 rounded border px-3 py-2" type="password" name="password" placeholder="Nuova password" required minlength="8">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Conferma password</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-gray-400"><i class="fas fa-lock"></i></span>
                        <input class="flex-1 rounded border px-3 py-2" type="password" name="confirm" placeholder="Conferma password" required minlength="8">
                    </div>
                </div>
                <div>
                    <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" type="submit">Aggiorna password</button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="/assets/js/app.js"></script>
</body>
</html>
