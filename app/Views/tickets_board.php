<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$ticketBoardText = [
    'it' => [
        'page_title' => 'Ticket Board',
        'eyebrow' => 'Support board',
        'title' => 'Vista kanban dei ticket per stato operativo',
        'lead' => 'Una board rapida per leggere il carico di supporto, aprire i dettagli e capire subito priorita e contesto cliente.',
        'table_view' => 'Vista tabellare',
        'new_ticket' => 'Nuovo ticket',
        'columns' => [
            'open' => 'Aperti',
            'in_progress' => 'In lavorazione',
            'resolved' => 'Risolti',
            'closed' => 'Chiusi',
        ],
        'ticket_fallback' => 'Ticket senza oggetto',
        'open_detail' => 'Apri dettaglio',
        'priority' => [
            'low' => 'Bassa',
            'medium' => 'Media',
            'high' => 'Alta',
        ],
        'empty' => 'Nessun ticket in questa colonna.',
    ],
    'en' => [
        'page_title' => 'Ticket Board',
        'eyebrow' => 'Support board',
        'title' => 'Kanban view of tickets by operational status',
        'lead' => 'A fast board to read support workload, open details, and quickly understand priority and customer context.',
        'table_view' => 'Table view',
        'new_ticket' => 'New ticket',
        'columns' => [
            'open' => 'Open',
            'in_progress' => 'In progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        ],
        'ticket_fallback' => 'Untitled ticket',
        'open_detail' => 'Open detail',
        'priority' => [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
        ],
        'empty' => 'No tickets in this column.',
    ],
    'fr' => [
        'page_title' => 'Board tickets',
        'eyebrow' => 'Board support',
        'title' => 'Vue kanban des tickets par statut operationnel',
        'lead' => 'Une board rapide pour lire la charge support, ouvrir les details et comprendre immediatement priorite et contexte client.',
        'table_view' => 'Vue tableau',
        'new_ticket' => 'Nouveau ticket',
        'columns' => [
            'open' => 'Ouverts',
            'in_progress' => 'En cours',
            'resolved' => 'Resolus',
            'closed' => 'Fermes',
        ],
        'ticket_fallback' => 'Ticket sans objet',
        'open_detail' => 'Ouvrir detail',
        'priority' => [
            'low' => 'Basse',
            'medium' => 'Moyenne',
            'high' => 'Haute',
        ],
        'empty' => 'Aucun ticket dans cette colonne.',
    ],
    'es' => [
        'page_title' => 'Board de tickets',
        'eyebrow' => 'Board de soporte',
        'title' => 'Vista kanban de tickets por estado operativo',
        'lead' => 'Un board rapido para leer la carga de soporte, abrir detalles y entender enseguida prioridad y contexto cliente.',
        'table_view' => 'Vista tabular',
        'new_ticket' => 'Nuevo ticket',
        'columns' => [
            'open' => 'Abiertos',
            'in_progress' => 'En curso',
            'resolved' => 'Resueltos',
            'closed' => 'Cerrados',
        ],
        'ticket_fallback' => 'Ticket sin asunto',
        'open_detail' => 'Abrir detalle',
        'priority' => [
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta',
        ],
        'empty' => 'No hay tickets en esta columna.',
    ],
];

$tbt = $ticketBoardText[Locale::current()] ?? $ticketBoardText['it'];
$pageTitle = $tbt['page_title'];
$ticketBoard = (array)($ticketBoard ?? []);
$showCustomer = !Auth::isCustomer();
$columnIcons = [
    'open' => 'fa-inbox',
    'in_progress' => 'fa-spinner',
    'resolved' => 'fa-circle-check',
    'closed' => 'fa-box-archive',
];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($tbt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($tbt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($tbt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/tickets" class="btn btn-outline-secondary"><?php echo htmlspecialchars($tbt['table_view']); ?></a>
        <?php if (RolePermissions::canCurrent('tickets_create')): ?>
            <a href="/tickets/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i><?php echo htmlspecialchars($tbt['new_ticket']); ?></a>
        <?php endif; ?>
    </div>
</section>

<div class="dashboard-kanban">
    <?php foreach (['open', 'in_progress', 'resolved', 'closed'] as $status): ?>
        <?php $items = (array)($ticketBoard[$status] ?? []); ?>
        <section class="dashboard-kanban-column">
            <header class="dashboard-kanban-column__head">
                <div>
                    <strong><i class="fas <?php echo htmlspecialchars((string)($columnIcons[$status] ?? 'fa-ticket-alt')); ?> me-2"></i><?php echo htmlspecialchars((string)$tbt['columns'][$status]); ?></strong>
                </div>
                <strong><?php echo count($items); ?></strong>
            </header>
            <div class="dashboard-kanban-column__body">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $ticket): ?>
                        <?php $priorityKey = (string)($ticket['priority'] ?? 'medium'); ?>
                        <a class="dashboard-kanban-card" href="/tickets/<?php echo (int)($ticket['id'] ?? 0); ?>">
                            <strong><?php echo htmlspecialchars((string)($ticket['subject'] ?? $tbt['ticket_fallback'])); ?></strong>
                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars((string)($ticket['category'] ?? '-')); ?></span>
                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars((string)($tbt['priority'][$priorityKey] ?? ucfirst($priorityKey))); ?></span>
                            <?php if ($showCustomer && !empty($ticket['customer_name'])): ?>
                                <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars((string)$ticket['customer_name']); ?></span>
                            <?php endif; ?>
                            <small><?php echo htmlspecialchars(Locale::formatDateTime($ticket['created_at'] ?? '')); ?></small>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="dashboard-kanban-empty"><?php echo htmlspecialchars($tbt['empty']); ?></div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';