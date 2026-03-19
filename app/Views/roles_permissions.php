<?php
use Core\Locale;

$rolesPermissionsText = [
    'it' => [
        'page_title' => 'Ruoli e Permessi',
        'eyebrow' => 'Access governance',
        'title' => 'Definisci chi puo vedere, aprire e amministrare ogni area',
        'lead' => 'Una matrice centrale per governare ruoli applicativi e permessi reali della suite, con un setup leggibile e coerente con il resto dell area admin.',
        'workspace_settings' => 'Workspace settings',
        'admin_only' => 'Admin only',
        'roles' => ['admin' => 'Admin', 'operator' => 'Operator', 'customer' => 'Customer'],
        'active_permissions' => 'permessi attivi in questa configurazione',
        'matrix_eyebrow' => 'Permission matrix',
        'matrix_title' => 'Ruoli e capability applicative',
        'table_permission' => 'Permission',
        'pagination' => 'Paginazione',
        'previous' => 'Precedente',
        'next' => 'Successiva',
        'save' => 'Salva matrice',
        'back_users' => 'Torna agli utenti',
    ],
    'en' => [
        'page_title' => 'Roles & Permissions',
        'eyebrow' => 'Access governance',
        'title' => 'Define who can view, open, and manage each area',
        'lead' => 'A central matrix to govern application roles and real suite permissions, with a readable setup aligned with the rest of the admin area.',
        'workspace_settings' => 'Workspace settings',
        'admin_only' => 'Admin only',
        'roles' => ['admin' => 'Admin', 'operator' => 'Operator', 'customer' => 'Customer'],
        'active_permissions' => 'active permissions in this configuration',
        'matrix_eyebrow' => 'Permission matrix',
        'matrix_title' => 'Roles and application capabilities',
        'table_permission' => 'Permission',
        'pagination' => 'Pagination',
        'previous' => 'Previous',
        'next' => 'Next',
        'save' => 'Save matrix',
        'back_users' => 'Back to users',
    ],
    'fr' => [
        'page_title' => 'Roles et permissions',
        'eyebrow' => 'Gouvernance acces',
        'title' => 'Definir qui peut voir, ouvrir et administrer chaque zone',
        'lead' => 'Une matrice centrale pour gouverner les roles applicatifs et les permissions reelles de la suite, avec une configuration lisible et coherente avec le reste de l admin.',
        'workspace_settings' => 'Workspace settings',
        'admin_only' => 'Admin only',
        'roles' => ['admin' => 'Admin', 'operator' => 'Operateur', 'customer' => 'Client'],
        'active_permissions' => 'permissions actives dans cette configuration',
        'matrix_eyebrow' => 'Matrice permissions',
        'matrix_title' => 'Roles et capacites applicatives',
        'table_permission' => 'Permission',
        'pagination' => 'Pagination',
        'previous' => 'Precedente',
        'next' => 'Suivante',
        'save' => 'Enregistrer la matrice',
        'back_users' => 'Retour aux utilisateurs',
    ],
    'es' => [
        'page_title' => 'Roles y permisos',
        'eyebrow' => 'Gobernanza de acceso',
        'title' => 'Define quien puede ver, abrir y administrar cada area',
        'lead' => 'Una matriz central para gobernar roles aplicativos y permisos reales de la suite, con una configuracion legible y coherente con el resto del area admin.',
        'workspace_settings' => 'Workspace settings',
        'admin_only' => 'Admin only',
        'roles' => ['admin' => 'Admin', 'operator' => 'Operador', 'customer' => 'Cliente'],
        'active_permissions' => 'permisos activos en esta configuracion',
        'matrix_eyebrow' => 'Matriz de permisos',
        'matrix_title' => 'Roles y capacidades aplicativas',
        'table_permission' => 'Permiso',
        'pagination' => 'Paginacion',
        'previous' => 'Anterior',
        'next' => 'Siguiente',
        'save' => 'Guardar matriz',
        'back_users' => 'Volver a usuarios',
    ],
];

$rpt = $rolesPermissionsText[Locale::current()] ?? $rolesPermissionsText['it'];
$pageTitle = $rpt['page_title'];
$permissions = (array)($permissions ?? []);
$permissionLabels = (array)($permissionLabels ?? []);
$roles = $rpt['roles'];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($rpt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($rpt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($rpt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/workspace/settings" class="btn btn-outline-secondary"><?php echo htmlspecialchars($rpt['workspace_settings']); ?></a>
        <span class="admin-section-chip"><i class="fas fa-user-shield"></i><?php echo htmlspecialchars($rpt['admin_only']); ?></span>
    </div>
</section>

<div class="row g-3 mb-4">
    <?php foreach ($roles as $roleKey => $roleLabel): ?>
        <?php $enabled = array_sum(array_map(static fn($value) => !empty($value) ? 1 : 0, (array)($permissions[$roleKey] ?? []))); ?>
        <div class="col-12 col-sm-6 col-xxl-4">
            <div class="card admin-stat-card h-100">
                <div class="card-body">
                    <span class="admin-stat-card__label"><?php echo htmlspecialchars($roleLabel); ?></span>
                    <strong class="admin-stat-card__value"><?php echo $enabled; ?></strong>
                    <span class="admin-stat-card__meta"><?php echo htmlspecialchars($rpt['active_permissions']); ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card admin-data-card">
    <div class="card-header border-0">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($rpt['matrix_eyebrow']); ?></p>
            <span><?php echo htmlspecialchars($rpt['matrix_title']); ?></span>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="/admin/roles-permissions">
            <?php echo CSRF::field(); ?>
            <div class="table-responsive admin-table-wrap">
                <table class="table align-middle mb-0 admin-enhanced-table roles-permissions-table">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo htmlspecialchars($rpt['table_permission']); ?></th>
                            <?php foreach ($roles as $roleLabel): ?>
                                <th class="text-center"><?php echo htmlspecialchars($roleLabel); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permissionLabels as $permissionKey => $permissionMeta): ?>
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <span class="fw-semibold"><?php echo htmlspecialchars((string)$permissionMeta['label']); ?></span>
                                        <span class="admin-table-subtitle"><?php echo htmlspecialchars((string)$permissionMeta['meta']); ?></span>
                                    </div>
                                </td>
                                <?php foreach ($roles as $roleKey => $roleLabel): ?>
                                    <td class="text-center">
                                        <label class="roles-permissions-check">
                                            <input type="checkbox" name="permissions[<?php echo htmlspecialchars($roleKey); ?>][<?php echo htmlspecialchars($permissionKey); ?>]" value="1" <?php echo !empty($permissions[$roleKey][$permissionKey]) ? 'checked' : ''; ?>>
                                            <span></span>
                                        </label>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (($totalPages ?? 1) > 1): ?>
                <nav aria-label="<?php echo htmlspecialchars($rpt['pagination']); ?>" class="mt-4">
                    <ul class="pagination mb-0">
                        <li class="page-item<?php echo ($page ?? 1) <= 1 ? ' disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page ?? 1) <= 1 ? '#' : '/admin/roles-permissions?page=' . (($page ?? 1) - 1); ?>"><?php echo htmlspecialchars($rpt['previous']); ?></a>
                        </li>
                        <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                            <li class="page-item<?php echo $i === ($page ?? 1) ? ' active' : ''; ?>">
                                <a class="page-link" href="/admin/roles-permissions?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item<?php echo ($page ?? 1) >= ($totalPages ?? 1) ? ' disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page ?? 1) >= ($totalPages ?? 1) ? '#' : '/admin/roles-permissions?page=' . (($page ?? 1) + 1); ?>"><?php echo htmlspecialchars($rpt['next']); ?></a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            <div class="d-flex gap-2 flex-wrap mt-4">
                <button class="btn btn-primary" type="submit"><i class="fas fa-save me-1"></i><?php echo htmlspecialchars($rpt['save']); ?></button>
                <a class="btn btn-outline-secondary" href="/admin/users"><?php echo htmlspecialchars($rpt['back_users']); ?></a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
