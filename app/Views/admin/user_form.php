<?php
$isEdit = isset($user) && !empty($user['id']);
$pageTitle = $isEdit ? 'Modifica Utente' : 'Nuovo Utente';
$action = $isEdit ? '/admin/users/' . (int)$user['id'] : '/admin/users';

$content = '
<form method="POST" action="' . $action . '">
    ' . CSRF::field() . '
    <div class="columns is-multiline">
        <div class="column is-6">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input class="input" type="text" name="name" value="' . htmlspecialchars($user['name'] ?? '') . '" required>
                </div>
            </div>
        </div>
        <div class="column is-6">
            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" type="email" name="email" value="' . htmlspecialchars($user['email'] ?? '') . '" required>
                </div>
            </div>
        </div>

        <div class="column is-6">
            <div class="field">
                <label class="label">Password' . ($isEdit ? ' (lascia vuoto per non modificare)' : '') . '</label>
                <div class="control">
                    <input class="input" type="password" name="password" ' . (!$isEdit ? 'required' : '') . ' minlength="6">
                </div>
            </div>
        </div>

        <div class="column is-6">
            <div class="field">
                <label class="label">Telefono</label>
                <div class="control">
                    <input class="input" type="text" name="phone" value="' . htmlspecialchars($user['phone'] ?? '') . '" placeholder="+39 ...">
                </div>
            </div>
        </div>

        <div class="column is-3">
            <div class="field">
                <label class="label">Ruolo</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="role">
                            <option value="admin" ' . (($user['role'] ?? '') === 'admin' ? 'selected' : '') . '>Admin</option>
                            <option value="operator" ' . (($user['role'] ?? '') === 'operator' ? 'selected' : '') . '>Operator</option>
                            <option value="customer" ' . (($user['role'] ?? 'customer') === 'customer' ? 'selected' : '') . '>Customer</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="column is-3">
            <div class="field">
                <label class="label">Stato</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="status">
                            <option value="active" ' . (($user['status'] ?? 'active') === 'active' ? 'selected' : '') . '>Attivo</option>
                            <option value="suspended" ' . (($user['status'] ?? '') === 'suspended' ? 'selected' : '') . '>Sospeso</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control"><button class="button is-primary" type="submit">Salva</button></div>
        <div class="control"><a class="button is-light" href="/admin/users">Annulla</a></div>
    </div>
</form>
';

include __DIR__ . '/../layout.php';
