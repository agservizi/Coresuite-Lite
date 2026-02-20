<?php
$pageTitle = 'Gestione Utenti';

$content = '
<div class="level">
    <div class="level-left">
        <div class="level-item">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" placeholder="Cerca utenti...">
                </div>
            </div>
        </div>
    </div>
    <div class="level-right">
        <div class="level-item">
            <a href="/admin/users/create" class="button is-primary">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Nuovo Utente</span>
            </a>
        </div>
    </div>
</div>

<div class="table-container">
    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ruolo</th>
                <th>Stato</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
';

foreach ($users as $user) {
    $roleTag = $user['role'] === 'admin' ? 'is-danger' : ($user['role'] === 'operator' ? 'is-warning' : 'is-info');
    $statusTag = $user['status'] === 'active' ? 'is-success' : 'is-danger';

    $content .= '
            <tr>
                <td>' . htmlspecialchars($user['name']) . '</td>
                <td>' . htmlspecialchars($user['email']) . '</td>
                <td><span class="tag ' . $roleTag . '">' . ucfirst($user['role']) . '</span></td>
                <td><span class="tag ' . $statusTag . '">' . ($user['status'] === 'active' ? 'Attivo' : 'Sospeso') . '</span></td>
                <td>
                    <div class="buttons are-small">
                        <a href="/admin/users/' . $user['id'] . '/edit" class="button is-info">
                            <span class="icon"><i class="fas fa-edit"></i></span>
                        </a>
                        <button class="button is-danger" onclick="confirmDelete(' . $user['id'] . ')">
                            <span class="icon"><i class="fas fa-trash"></i></span>
                        </button>
                    </div>
                </td>
            </tr>
';
}

$content .= '
        </tbody>
    </table>
</div>

<div class="modal" id="deleteModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Conferma Eliminazione</p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <section class="modal-card-body">
            Sei sicuro di voler eliminare questo utente?
        </section>
        <footer class="modal-card-foot">
            <form id="deleteForm" method="POST">
                <button class="button is-danger" type="submit">Elimina</button>
                <button class="button" onclick="closeModal()">Annulla</button>
            </form>
        </footer>
    </div>
</div>

<script>
function confirmDelete(id) {
    document.getElementById("deleteForm").action = "/admin/users/" + id + "/delete";
    document.getElementById("deleteModal").classList.add("is-active");
}

function closeModal() {
    document.getElementById("deleteModal").classList.remove("is-active");
}
</script>
';

include __DIR__ . '/../layout.php';
?>