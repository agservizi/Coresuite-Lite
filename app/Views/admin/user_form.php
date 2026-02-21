<?php
$isEdit = isset($user) && !empty($user['id']);
$pageTitle = $isEdit ? 'Modifica Utente' : 'Nuovo Utente';
$action = $isEdit ? '/admin/users/' . (int)$user['id'] : '/admin/users';

$content = '
<form method="POST" action="' . $action . '">
    ' . CSRF::field() . '
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nome</label>
            <input class="mt-1 block w-full rounded border px-3 py-2" type="text" name="name" value="' . htmlspecialchars($user['name'] ?? '') . '" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input class="mt-1 block w-full rounded border px-3 py-2" type="email" name="email" value="' . htmlspecialchars($user['email'] ?? '') . '" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password' . ($isEdit ? ' (lascia vuoto per non modificare)' : '') . '</label>
            <input class="mt-1 block w-full rounded border px-3 py-2" type="password" name="password" ' . (!$isEdit ? 'required' : '') . ' minlength="6">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Telefono</label>
            <input class="mt-1 block w-full rounded border px-3 py-2" type="text" name="phone" value="' . htmlspecialchars($user['phone'] ?? '') . '" placeholder="+39 ...">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Ruolo</label>
            <select name="role" class="mt-1 block w-full rounded border px-3 py-2">
                <option value="admin" ' . (($user['role'] ?? '') === 'admin' ? 'selected' : '') . '>Admin</option>
                <option value="operator" ' . (($user['role'] ?? '') === 'operator' ? 'selected' : '') . '>Operator</option>
                <option value="customer" ' . (($user['role'] ?? 'customer') === 'customer' ? 'selected' : '') . '>Customer</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Stato</label>
            <select name="status" class="mt-1 block w-full rounded border px-3 py-2">
                <option value="active" ' . (($user['status'] ?? 'active') === 'active' ? 'selected' : '') . '>Attivo</option>
                <option value="suspended" ' . (($user['status'] ?? '') === 'suspended' ? 'selected' : '') . '>Sospeso</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex gap-2">
        <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Salva</button>
        <a class="px-4 py-2 bg-gray-100 text-gray-800 rounded" href="/admin/users">Annulla</a>
    </div>
</form>
';

include __DIR__ . '/../layout.php';
