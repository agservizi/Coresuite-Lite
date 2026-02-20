<?php
$pageTitle = 'Gestione Utenti';

$content = '
<div class="level">
    <div class="level-left">
        <div class="level-item">
            <form method="GET" action="/admin/users">
                <div class="field has-addons">
                    <div class="control">
                        <input class="input" type="text" name="q" placeholder="Cerca utenti..." value="' . htmlspecialchars($search ?? '') . '">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">
                            <span class="icon"><i class="fas fa-search"></i></span>
                        </button>
                    </div>
                </div>
            </form>
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
                <th>Telefono</th>
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
                <td>' . htmlspecialchars($user['phone'] ?? '-') . '</td>
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

if (empty($users)) {
    $content .= '<tr><td colspan="6" class="has-text-centered has-text-grey">Nessun utente trovato</td></tr>';
}

$content .= '
        </tbody>
    </table>
</div>
';

// Paginazione
if (isset($totalPages) && $totalPages > 1) {
    $currentPage = $page ?? 1;
    $qs = !empty($search) ? '&q=' . urlencode($search) : '';
    $content .= '<nav class="pagination is-centered mt-4" role="navigation" aria-label="pagination">';
    $content .= '<a class="pagination-previous" ' . ($currentPage <= 1 ? 'disabled' : 'href="/admin/users?page=' . ($currentPage - 1) . $qs . '"') . '>Precedente</a>';
    $content .= '<a class="pagination-next" ' . ($currentPage >= $totalPages ? 'disabled' : 'href="/admin/users?page=' . ($currentPage + 1) . $qs . '"') . '>Successiva</a>';
    $content .= '<ul class="pagination-list">';
    for ($p = 1; $p <= $totalPages; $p++) {
        $content .= '<li><a class="pagination-link ' . ($p == $currentPage ? 'is-current' : '') . '" href="/admin/users?page=' . $p . $qs . '">' . $p . '</a></li>';
    }
    $content .= '</ul></nav>';
}

$content .= '
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
                ' . CSRF::field() . '
                <button class="button is-danger" type="submit">Elimina</button>
                <button class="button" type="button" onclick="closeModal()">Annulla</button>
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