<?php
$pageTitle = 'Gestione Utenti';

$content = '
<div class="flex items-center justify-between mb-4">
    <form method="GET" action="/admin/users" class="flex items-center gap-2">
        <input class="rounded border px-3 py-2" type="text" name="q" placeholder="Cerca utenti..." value="' . htmlspecialchars($search ?? '') . '">
        <button class="px-3 py-2 bg-blue-600 text-white rounded" type="submit"><i class="fas fa-search"></i></button>
    </form>
    <a href="/admin/users/create" class="px-3 py-2 bg-green-600 text-white rounded inline-flex items-center gap-2"><i class="fas fa-plus"></i> Nuovo Utente</a>
</div>

<div class="overflow-x-auto bg-white border rounded">
    <table class="min-w-full divide-y">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nome</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Telefono</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Ruolo</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Stato</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Azioni</th>
            </tr>
        </thead>
        <tbody class="divide-y">';

foreach ($users as $user) {
    $roleTag = $user['role'] === 'admin' ? 'is-danger' : ($user['role'] === 'operator' ? 'is-warning' : 'is-info');
    $statusTag = $user['status'] === 'active' ? 'is-success' : 'is-danger';

    $content .= '
            <tr>
                <td class="px-4 py-2">' . htmlspecialchars($user['name']) . '</td>
                <td class="px-4 py-2">' . htmlspecialchars($user['email']) . '</td>
                <td class="px-4 py-2">' . htmlspecialchars($user['phone'] ?? '-') . '</td>
                <td class="px-4 py-2"><span class="inline-block px-2 py-1 text-sm rounded ' . ($user['role'] === 'admin' ? 'bg-red-100 text-red-800' : ($user['role'] === 'operator' ? 'bg-yellow-100 text-yellow-800' : 'bg-indigo-100 text-indigo-800')) . '">' . ucfirst($user['role']) . '</span></td>
                <td class="px-4 py-2"><span class="inline-block px-2 py-1 text-sm rounded ' . ($user['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') . '">' . ($user['status'] === 'active' ? 'Attivo' : 'Sospeso') . '</span></td>
                <td class="px-4 py-2">
                    <a href="/admin/users/' . $user['id'] . '/edit" class="px-2 py-1 bg-blue-500 text-white rounded mr-2 inline-block"><i class="fas fa-edit"></i></a>
                    <button class="px-2 py-1 bg-red-500 text-white rounded" onclick="confirmDelete(' . $user['id'] . ')"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
';
}

if (empty($users)) {
    $content .= '<tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Nessun utente trovato</td></tr>';
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
    $content .= '<div class="flex items-center justify-center mt-4 gap-2">';
    if ($currentPage > 1) {
        $content .= '<a href="/admin/users?page=' . ($currentPage - 1) . $qs . '" class="px-3 py-1 bg-gray-200 rounded">Precedente</a>';
    }
    for ($p = 1; $p <= $totalPages; $p++) {
        $content .= '<a class="px-3 py-1 ' . ($p == $currentPage ? 'bg-blue-600 text-white rounded' : 'bg-gray-100 rounded') . '" href="/admin/users?page=' . $p . $qs . '">' . $p . '</a>';
    }
    if ($currentPage < $totalPages) {
        $content .= '<a href="/admin/users?page=' . ($currentPage + 1) . $qs . '" class="px-3 py-1 bg-gray-200 rounded">Successiva</a>';
    }
    $content .= '</div>';
}

$content .= '
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">
    <div class="bg-white rounded shadow-lg w-11/12 max-w-md">
        <div class="px-4 py-3 border-b font-medium">Conferma Eliminazione</div>
        <div class="p-4">Sei sicuro di voler eliminare questo utente?</div>
        <div class="px-4 py-3 border-t flex justify-end gap-2">
            <form id="deleteForm" method="POST">' . CSRF::field() . '
                <button class="px-3 py-1 bg-red-600 text-white rounded" type="submit">Elimina</button>
            </form>
            <button class="px-3 py-1 bg-gray-200 rounded" type="button" onclick="closeModal()">Annulla</button>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    document.getElementById("deleteForm").action = "/admin/users/" + id + "/delete";
    document.getElementById("deleteModal").classList.remove("hidden");
}
function closeModal() {
    document.getElementById("deleteModal").classList.add("hidden");
}
</script>
';

include __DIR__ . '/../layout.php';
?>