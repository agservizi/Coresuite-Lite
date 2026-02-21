<?php
use Core\Auth;

$pageTitle = 'Il mio profilo';

// layout: left = profile form, right = activity feed
$content = '
<div class="columns">
    <div class="column is-three-quarters">
        <form method="POST" action="/profile">
            ' . CSRF::field() . '
            <div class="columns is-multiline">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Nome</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" name="name" value="' . htmlspecialchars($user['name'] ?? '') . '" required>
                            <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input class="input" type="email" name="email" value="' . htmlspecialchars($user['email'] ?? '') . '" required>
                            <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Telefono</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" name="phone" value="' . htmlspecialchars($user['phone'] ?? '') . '" placeholder="+39 ...">
                            <span class="icon is-small is-left"><i class="fas fa-phone"></i></span>
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Ruolo</label>
                        <div class="control">
                            <input class="input" type="text" value="' . htmlspecialchars(ucfirst($user['role'] ?? '')) . '" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <p class="subtitle is-6"><span class="icon"><i class="fas fa-lock"></i></span> Cambia password <small class="has-text-grey">(opzionale)</small></p>

            <div class="columns is-multiline">
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Password attuale</label>
                        <div class="control">
                            <input class="input" type="password" name="current_password" autocomplete="current-password">
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Nuova password</label>
                        <div class="control">
                            <input class="input" type="password" name="new_password" minlength="6" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Conferma nuova password</label>
                        <div class="control">
                            <input class="input" type="password" name="confirm_password" autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Salva modifiche</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="column">
        <div class="box">
            <p class="title is-6">Attività recenti</p>
            <div class="content" style="max-height:48vh; overflow:auto;">
                ' . (empty($activity) ? '<p class="has-text-grey">Nessuna attività recente.</p>' : '') . '
                <ul>
';

if (!empty($activity)) {
    foreach ($activity as $act) {
        $time = htmlspecialchars($act['created_at']);
        $action = htmlspecialchars($act['action']);
        $entity = htmlspecialchars($act['entity']);
        $entityId = htmlspecialchars($act['entity_id']);
        $by = $act['actor_id'] ? ('ID ' . intval($act['actor_id'])) : 'Sistema';
        $content .= "<li><small class=\"has-text-grey\">{$time}</small><br><strong>{$action}</strong> on <em>{$entity}</em> #{$entityId} — <span class=\"is-size-7\">{$by}</span></li>";
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
