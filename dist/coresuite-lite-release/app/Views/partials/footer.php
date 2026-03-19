<?php use Core\Auth; ?>
<?php use Core\Locale; ?>
<?php use Core\WorkspaceSettings; ?>
<?php
$workspaceSettings = WorkspaceSettings::all();
$footerText = [
    'it' => ['admin_meta' => 'Controllo completo del workspace', 'operator_meta' => 'Supporto e follow-up in tempo reale', 'customer_meta' => 'Area cliente sempre a portata di mano', 'member_meta' => 'Workspace operativo attivo', 'workspace_control' => 'Cabina di regia', 'admin_console' => 'Console di controllo', 'operations_focus' => 'Operativita live', 'support_workflow' => 'Supporto attivo', 'customer_workspace' => 'Area cliente', 'requests_docs' => 'Documenti e richieste', 'suite_workspace' => 'Workspace condiviso', 'operational_shell' => 'Operativita attiva', 'workspace_ready' => 'Workspace pronto', 'role_admin' => 'Admin', 'role_operator' => 'Operatore', 'role_customer' => 'Cliente', 'role_member' => 'Membro'],
    'en' => ['admin_meta' => 'Complete workspace control', 'operator_meta' => 'Support and follow-up in real time', 'customer_meta' => 'Customer area always within reach', 'member_meta' => 'Operational workspace active', 'workspace_control' => 'Control room', 'admin_console' => 'Control console', 'operations_focus' => 'Live operations', 'support_workflow' => 'Active support', 'customer_workspace' => 'Customer area', 'requests_docs' => 'Docs & requests', 'suite_workspace' => 'Shared workspace', 'operational_shell' => 'Active operations', 'workspace_ready' => 'Workspace ready', 'role_admin' => 'Admin', 'role_operator' => 'Operator', 'role_customer' => 'Customer', 'role_member' => 'Member'],
    'fr' => ['admin_meta' => 'Controle complet du workspace', 'operator_meta' => 'Support et suivi en temps reel', 'customer_meta' => 'Espace client toujours a portee de main', 'member_meta' => 'Workspace operationnel actif', 'workspace_control' => 'Poste de pilotage', 'admin_console' => 'Console de controle', 'operations_focus' => 'Operations live', 'support_workflow' => 'Support actif', 'customer_workspace' => 'Espace client', 'requests_docs' => 'Documents et demandes', 'suite_workspace' => 'Workspace partage', 'operational_shell' => 'Operations actives', 'workspace_ready' => 'Workspace pret', 'role_admin' => 'Admin', 'role_operator' => 'Operateur', 'role_customer' => 'Client', 'role_member' => 'Membre'],
    'es' => ['admin_meta' => 'Control completo del workspace', 'operator_meta' => 'Soporte y seguimiento en tiempo real', 'customer_meta' => 'Area cliente sempre a mano', 'member_meta' => 'Workspace operativo activo', 'workspace_control' => 'Centro de control', 'admin_console' => 'Consola de control', 'operations_focus' => 'Operativa live', 'support_workflow' => 'Soporte activo', 'customer_workspace' => 'Area cliente', 'requests_docs' => 'Documentos y solicitudes', 'suite_workspace' => 'Workspace compartido', 'operational_shell' => 'Operativa activa', 'workspace_ready' => 'Workspace listo', 'role_admin' => 'Admin', 'role_operator' => 'Operador', 'role_customer' => 'Cliente', 'role_member' => 'Miembro'],
];
$ft = $footerText[Locale::current()] ?? $footerText['it'];
$role = 'member';
try {
    $role = (string)(Auth::user()['role'] ?? 'member');
} catch (\Throwable $e) {
    $role = 'member';
}

$roleMeta = [
    'admin' => [
        'pills' => [
            ['icon' => 'fa-user-shield', 'label' => $ft['workspace_control']],
            ['icon' => 'fa-sliders', 'label' => $ft['admin_console']],
        ],
        'meta' => $ft['admin_meta'],
    ],
    'operator' => [
        'pills' => [
            ['icon' => 'fa-life-ring', 'label' => $ft['operations_focus']],
            ['icon' => 'fa-bolt', 'label' => $ft['support_workflow']],
        ],
        'meta' => $ft['operator_meta'],
    ],
    'customer' => [
        'pills' => [
            ['icon' => 'fa-folder-open', 'label' => $ft['customer_workspace']],
            ['icon' => 'fa-ticket-alt', 'label' => $ft['requests_docs']],
        ],
        'meta' => $ft['customer_meta'],
    ],
    'member' => [
        'pills' => [
            ['icon' => 'fa-layer-group', 'label' => $ft['suite_workspace']],
            ['icon' => 'fa-circle-notch', 'label' => $ft['operational_shell']],
        ],
        'meta' => $ft['member_meta'],
    ],
];

$footerRole = $roleMeta[$role] ?? $roleMeta['member'];
$roleLabels = [
    'admin' => $ft['role_admin'],
    'operator' => $ft['role_operator'],
    'customer' => $ft['role_customer'],
    'member' => $ft['role_member'],
];
$footerRoleLabel = $roleLabels[$role] ?? $roleLabels['member'];
?>
<footer class="global-footer">
    <div class="global-footer__inner">
        <div class="global-footer__brand">
            <strong><?php echo htmlspecialchars((string)($workspaceSettings['workspace_name'] ?? 'CoreSuite Lite')); ?></strong>
            <span class="global-footer__brand-meta"><?php echo htmlspecialchars((string)($footerRole['meta'] ?? ($workspaceSettings['environment_label'] ?? $ft['workspace_ready']))); ?></span>
        </div>
        <div class="global-footer__status">
            <?php foreach ((array)($footerRole['pills'] ?? []) as $pill): ?>
                <span class="global-footer__pill"><i class="fas <?php echo htmlspecialchars((string)$pill['icon']); ?>"></i><?php echo htmlspecialchars((string)$pill['label']); ?></span>
            <?php endforeach; ?>
        </div>
        <div class="global-footer__meta">
            <span>&copy; <?php echo date('Y'); ?></span>
            <span class="global-footer__dot"></span>
            <span class="global-footer__role"><?php echo htmlspecialchars($footerRoleLabel); ?></span>
            <span class="global-footer__dot"></span>
            <a href="mailto:<?php echo htmlspecialchars((string)($workspaceSettings['support_email'] ?? 'support@example.com')); ?>"><?php echo htmlspecialchars((string)($workspaceSettings['support_email'] ?? 'support@example.com')); ?></a>
        </div>
    </div>
</footer>
