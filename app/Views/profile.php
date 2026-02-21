<?php
use Core\Auth;

$pageTitle = 'Il mio profilo';

$content = '
<div class="lg:flex lg:gap-6">
    <div class="lg:w-3/4">
        <form method="POST" action="/profile">
            ' . CSRF::field() . '
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                    <div class="mt-1 flex items-center gap-3">
                        <span class="text-gray-500"><i class="fas fa-user"></i></span>
                        <input class="flex-1 rounded border px-3 py-2 bg-white" type="text" name="name" value="' . htmlspecialchars($user['name'] ?? '') . '" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 flex items-center gap-3">
                        <span class="text-gray-500"><i class="fas fa-envelope"></i></span>
                        <input class="flex-1 rounded border px-3 py-2 bg-white" type="email" name="email" value="' . htmlspecialchars($user['email'] ?? '') . '" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telefono</label>
                    <div class="mt-1 flex items-center gap-3">
                        <span class="text-gray-500"><i class="fas fa-phone"></i></span>
                        <input class="flex-1 rounded border px-3 py-2 bg-white" type="text" name="phone" value="' . htmlspecialchars($user['phone'] ?? '') . '" placeholder="+39 ...">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ruolo</label>
                    <div class="mt-1">
                        <input class="w-full rounded border px-3 py-2 bg-gray-100 text-gray-600" type="text" value="' . htmlspecialchars(ucfirst($user['role'] ?? '')) . '" disabled>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <p class="text-sm font-semibold"><span class="text-gray-500"><i class="fas fa-lock"></i></span> Cambia password <small class="text-gray-500">(opzionale)</small></p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password attuale</label>
                    <div class="mt-1">
                        <input class="w-full rounded border px-3 py-2 bg-white" type="password" name="current_password" autocomplete="current-password">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nuova password</label>
                    <div class="mt-1">
                        <input class="w-full rounded border px-3 py-2 bg-white" type="password" name="new_password" minlength="6" autocomplete="new-password">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Conferma nuova password</label>
                    <div class="mt-1">
                        <input class="w-full rounded border px-3 py-2 bg-white" type="password" name="confirm_password" autocomplete="new-password">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" type="submit">
                    <span class="text-white"><i class="fas fa-save"></i></span>
                    <span>Salva modifiche</span>
                </button>
            </div>
        </form>
    </div>

    <div class="lg:w-1/4 mt-6 lg:mt-0">
        <div class="bg-white border rounded p-4 shadow">
            <p class="text-lg font-semibold mb-2">Attività recenti</p>
            <div class="max-h-[48vh] overflow-auto text-sm text-gray-700">
                ' . (empty($activity) ? '<p class="text-gray-500">Nessuna attività recente.</p>' : '') . '
                <ul class="space-y-3">
';

if (!empty($activity)) {
        foreach ($activity as $act) {
                $time = htmlspecialchars($act['created_at']);
                $action = htmlspecialchars($act['action']);
                $entity = htmlspecialchars($act['entity']);
                $entityId = htmlspecialchars($act['entity_id']);
                $by = $act['actor_id'] ? ('ID ' . intval($act['actor_id'])) : 'Sistema';
                $content .= "<li><div class=\"text-xs text-gray-500\">{$time}</div><div><strong>{$action}</strong> on <em>{$entity}</em> #{$entityId}<div class=\"text-xs text-gray-500\">{$by}</div></div></li>";
        }
}

$content .= '
                </ul>
            </div>
        </div>
    </div>

</div>
';

include __DIR__ . '/layout.php';
