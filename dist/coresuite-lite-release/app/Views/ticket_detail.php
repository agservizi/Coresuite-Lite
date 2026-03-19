<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$ticketId = (int)($ticket['id'] ?? 0);
$ticketDetailText = [
    'it' => [
        'page_title_prefix' => 'Dettaglio Ticket #',
        'subject_fallback' => '(senza oggetto)',
        'eyebrow' => 'Dettaglio ticket',
        'lead' => 'Monitora stato, assegnazione, allegati e conversazione nello stesso spazio operativo.',
        'back' => 'Torna ai ticket',
        'snapshot_eyebrow' => 'Snapshot',
        'snapshot_title' => 'Informazioni ticket',
        'customer' => 'Cliente',
        'assignee' => 'Assegnato a',
        'unassigned' => 'Non assegnato',
        'created_at' => 'Creato il',
        'ticket' => 'Ticket',
        'workflow_eyebrow' => 'Workflow',
        'workflow_title' => 'Stato attuale',
        'workflow_lead' => 'La scheda ti aiuta a coordinare il supporto senza uscire dalla conversazione.',
        'workflow_status' => 'Stato',
        'workflow_priority' => 'Priorita',
        'workflow_owner' => 'Owner',
        'workflow_owner_fallback' => 'Da assegnare',
        'status_control_eyebrow' => 'Controllo stato',
        'status_control_title' => 'Stato ticket',
        'select_status' => 'Seleziona stato',
        'save_status' => 'Salva stato',
        'ownership_eyebrow' => 'Ownership',
        'ownership_title' => 'Assegnazione operatore',
        'owner' => 'Responsabile',
        'save_assignment' => 'Salva assegnazione',
        'assets_eyebrow' => 'Assets',
        'assets_title' => 'Allegati',
        'open' => 'Apri',
        'no_attachments' => 'Nessun allegato disponibile.',
        'conversation_eyebrow' => 'Conversazione',
        'conversation_title' => 'Commenti',
        'internal' => 'Interno',
        'public' => 'Pubblico',
        'no_comments' => 'Nessun commento ancora.',
        'reply_eyebrow' => 'Risposta',
        'reply_title' => 'Nuovo commento',
        'message' => 'Messaggio',
        'visibility' => 'Visibilita',
        'visibility_public' => 'Pubblico, visibile al cliente',
        'visibility_internal' => 'Interno, solo staff',
        'optional_attachment' => 'Allegato opzionale',
        'add_comment' => 'Aggiungi commento',
        'status_open' => 'Aperto',
        'status_in_progress' => 'In lavorazione',
        'status_resolved' => 'Risolto',
        'status_closed' => 'Chiuso',
        'priority_low' => 'Bassa',
        'priority_medium' => 'Media',
        'priority_high' => 'Alta',
    ],
    'en' => [
        'page_title_prefix' => 'Ticket Detail #',
        'subject_fallback' => '(untitled)',
        'eyebrow' => 'Ticket detail',
        'lead' => 'Monitor status, assignment, attachments, and conversation in the same operational space.',
        'back' => 'Back to tickets',
        'snapshot_eyebrow' => 'Snapshot',
        'snapshot_title' => 'Ticket information',
        'customer' => 'Customer',
        'assignee' => 'Assigned to',
        'unassigned' => 'Unassigned',
        'created_at' => 'Created on',
        'ticket' => 'Ticket',
        'workflow_eyebrow' => 'Workflow',
        'workflow_title' => 'Current status',
        'workflow_lead' => 'This panel helps coordinate support without leaving the conversation.',
        'workflow_status' => 'Status',
        'workflow_priority' => 'Priority',
        'workflow_owner' => 'Owner',
        'workflow_owner_fallback' => 'To be assigned',
        'status_control_eyebrow' => 'Status control',
        'status_control_title' => 'Ticket status',
        'select_status' => 'Select status',
        'save_status' => 'Save status',
        'ownership_eyebrow' => 'Ownership',
        'ownership_title' => 'Operator assignment',
        'owner' => 'Owner',
        'save_assignment' => 'Save assignment',
        'assets_eyebrow' => 'Assets',
        'assets_title' => 'Attachments',
        'open' => 'Open',
        'no_attachments' => 'No attachments available.',
        'conversation_eyebrow' => 'Conversation',
        'conversation_title' => 'Comments',
        'internal' => 'Internal',
        'public' => 'Public',
        'no_comments' => 'No comments yet.',
        'reply_eyebrow' => 'Reply',
        'reply_title' => 'New comment',
        'message' => 'Message',
        'visibility' => 'Visibility',
        'visibility_public' => 'Public, visible to customer',
        'visibility_internal' => 'Internal, staff only',
        'optional_attachment' => 'Optional attachment',
        'add_comment' => 'Add comment',
        'status_open' => 'Open',
        'status_in_progress' => 'In progress',
        'status_resolved' => 'Resolved',
        'status_closed' => 'Closed',
        'priority_low' => 'Low',
        'priority_medium' => 'Medium',
        'priority_high' => 'High',
    ],
    'fr' => [
        'page_title_prefix' => 'Detail du ticket #',
        'subject_fallback' => '(sans objet)',
        'eyebrow' => 'Detail du ticket',
        'lead' => 'Suivez le statut, l attribution, les pieces jointes et la conversation dans le meme espace operationnel.',
        'back' => 'Retour aux tickets',
        'snapshot_eyebrow' => 'Apercu',
        'snapshot_title' => 'Informations du ticket',
        'customer' => 'Client',
        'assignee' => 'Attribue a',
        'unassigned' => 'Non attribue',
        'created_at' => 'Cree le',
        'ticket' => 'Ticket',
        'workflow_eyebrow' => 'Workflow',
        'workflow_title' => 'Statut actuel',
        'workflow_lead' => 'Cette fiche aide a coordonner le support sans quitter la conversation.',
        'workflow_status' => 'Statut',
        'workflow_priority' => 'Priorite',
        'workflow_owner' => 'Responsable',
        'workflow_owner_fallback' => 'A attribuer',
        'status_control_eyebrow' => 'Controle du statut',
        'status_control_title' => 'Statut du ticket',
        'select_status' => 'Selectionner le statut',
        'save_status' => 'Enregistrer le statut',
        'ownership_eyebrow' => 'Attribution',
        'ownership_title' => 'Attribution operateur',
        'owner' => 'Responsable',
        'save_assignment' => 'Enregistrer l attribution',
        'assets_eyebrow' => 'Ressources',
        'assets_title' => 'Pieces jointes',
        'open' => 'Ouvrir',
        'no_attachments' => 'Aucune piece jointe disponible.',
        'conversation_eyebrow' => 'Conversation',
        'conversation_title' => 'Commentaires',
        'internal' => 'Interne',
        'public' => 'Public',
        'no_comments' => 'Aucun commentaire pour le moment.',
        'reply_eyebrow' => 'Reponse',
        'reply_title' => 'Nouveau commentaire',
        'message' => 'Message',
        'visibility' => 'Visibilite',
        'visibility_public' => 'Public, visible par le client',
        'visibility_internal' => 'Interne, equipe uniquement',
        'optional_attachment' => 'Piece jointe optionnelle',
        'add_comment' => 'Ajouter un commentaire',
        'status_open' => 'Ouvert',
        'status_in_progress' => 'En cours',
        'status_resolved' => 'Resolue',
        'status_closed' => 'Ferme',
        'priority_low' => 'Basse',
        'priority_medium' => 'Moyenne',
        'priority_high' => 'Haute',
    ],
    'es' => [
        'page_title_prefix' => 'Detalle del ticket #',
        'subject_fallback' => '(sin asunto)',
        'eyebrow' => 'Detalle del ticket',
        'lead' => 'Supervisa estado, asignacion, adjuntos y conversacion en el mismo espacio operativo.',
        'back' => 'Volver a tickets',
        'snapshot_eyebrow' => 'Resumen',
        'snapshot_title' => 'Informacion del ticket',
        'customer' => 'Cliente',
        'assignee' => 'Asignado a',
        'unassigned' => 'Sin asignar',
        'created_at' => 'Creado el',
        'ticket' => 'Ticket',
        'workflow_eyebrow' => 'Workflow',
        'workflow_title' => 'Estado actual',
        'workflow_lead' => 'Esta ficha te ayuda a coordinar el soporte sin salir de la conversacion.',
        'workflow_status' => 'Estado',
        'workflow_priority' => 'Prioridad',
        'workflow_owner' => 'Responsable',
        'workflow_owner_fallback' => 'Por asignar',
        'status_control_eyebrow' => 'Control de estado',
        'status_control_title' => 'Estado del ticket',
        'select_status' => 'Selecciona estado',
        'save_status' => 'Guardar estado',
        'ownership_eyebrow' => 'Asignacion',
        'ownership_title' => 'Asignacion de operador',
        'owner' => 'Responsable',
        'save_assignment' => 'Guardar asignacion',
        'assets_eyebrow' => 'Recursos',
        'assets_title' => 'Adjuntos',
        'open' => 'Abrir',
        'no_attachments' => 'No hay adjuntos disponibles.',
        'conversation_eyebrow' => 'Conversacion',
        'conversation_title' => 'Comentarios',
        'internal' => 'Interno',
        'public' => 'Publico',
        'no_comments' => 'Todavia no hay comentarios.',
        'reply_eyebrow' => 'Respuesta',
        'reply_title' => 'Nuevo comentario',
        'message' => 'Mensaje',
        'visibility' => 'Visibilidad',
        'visibility_public' => 'Publico, visible para el cliente',
        'visibility_internal' => 'Interno, solo staff',
        'optional_attachment' => 'Adjunto opcional',
        'add_comment' => 'Agregar comentario',
        'status_open' => 'Abierto',
        'status_in_progress' => 'En progreso',
        'status_resolved' => 'Resuelto',
        'status_closed' => 'Cerrado',
        'priority_low' => 'Baja',
        'priority_medium' => 'Media',
        'priority_high' => 'Alta',
    ],
];

$td = $ticketDetailText[Locale::current()] ?? $ticketDetailText['it'];
$pageTitle = $td['page_title_prefix'] . $ticketId;

$status = (string)($ticket['status'] ?? 'open');
$priority = (string)($ticket['priority'] ?? 'medium');
$canManageStatus = Auth::isOperator() && RolePermissions::canCurrent('tickets_manage');

$statusLabels = [
    'open' => $td['status_open'],
    'in_progress' => $td['status_in_progress'],
    'resolved' => $td['status_resolved'],
    'closed' => $td['status_closed'],
];

$priorityLabels = [
    'low' => $td['priority_low'],
    'medium' => $td['priority_medium'],
    'high' => $td['priority_high'],
];

$statusClass = $status === 'closed' ? 'bg-success' : ($status === 'in_progress' ? 'bg-warning text-dark' : ($status === 'resolved' ? 'bg-primary' : 'bg-info text-dark'));
$priorityClass = $priority === 'high' ? 'bg-danger' : ($priority === 'low' ? 'bg-secondary' : 'bg-warning text-dark');

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($td['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars((string)($ticket['subject'] ?? $td['subject_fallback'])); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($td['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <span class="admin-section-chip"><i class="fas fa-hashtag"></i><?php echo $ticketId; ?></span>
        <a href="/tickets" class="btn btn-outline-secondary"><?php echo htmlspecialchars($td['back']); ?></a>
    </div>
</section>

<div class="row g-3 mb-4">
    <div class="col-12 col-xl-8">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($td['snapshot_eyebrow']); ?></p>
                    <span><?php echo htmlspecialchars($td['snapshot_title']); ?></span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark border"><?php echo htmlspecialchars((string)($ticket['category'] ?? '-')); ?></span>
                    <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status))); ?></span>
                    <span class="badge <?php echo $priorityClass; ?>"><?php echo htmlspecialchars($priorityLabels[$priority] ?? ucfirst($priority)); ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="admin-detail-block">
                            <span class="admin-detail-block__label"><?php echo htmlspecialchars($td['customer']); ?></span>
                            <strong class="admin-detail-block__value"><?php echo htmlspecialchars((string)($ticket['customer_name'] ?? '-')); ?></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-detail-block">
                            <span class="admin-detail-block__label"><?php echo htmlspecialchars($td['assignee']); ?></span>
                            <strong class="admin-detail-block__value"><?php echo htmlspecialchars((string)($ticket['assigned_name'] ?? $td['unassigned'])); ?></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-detail-block">
                            <span class="admin-detail-block__label"><?php echo htmlspecialchars($td['created_at']); ?></span>
                            <strong class="admin-detail-block__value"><?php echo htmlspecialchars(Locale::formatDateTime($ticket['created_at'] ?? '', '-')); ?></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-detail-block">
                            <span class="admin-detail-block__label"><?php echo htmlspecialchars($td['ticket']); ?></span>
                            <strong class="admin-detail-block__value">#<?php echo $ticketId; ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card admin-data-card h-100">
            <div class="card-body">
                <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($td['workflow_eyebrow']); ?></p>
                <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($td['workflow_title']); ?></h3>
                <p class="dashboard-spotlight-card__lead"><?php echo htmlspecialchars($td['workflow_lead']); ?></p>
                <ul class="dashboard-insights mt-0">
                    <li><i class="fas fa-life-ring"></i><?php echo htmlspecialchars($td['workflow_status']); ?>: <?php echo htmlspecialchars($statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status))); ?></li>
                    <li><i class="fas fa-bolt"></i><?php echo htmlspecialchars($td['workflow_priority']); ?>: <?php echo htmlspecialchars($priorityLabels[$priority] ?? ucfirst($priority)); ?></li>
                    <li><i class="fas fa-user-check"></i><?php echo htmlspecialchars($td['workflow_owner']); ?>: <?php echo htmlspecialchars((string)($ticket['assigned_name'] ?? $td['workflow_owner_fallback'])); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if ($canManageStatus): ?>
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card admin-form-card h-100">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($td['status_control_eyebrow']); ?></p>
                        <span><?php echo htmlspecialchars($td['status_control_title']); ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="/tickets/<?php echo $ticketId; ?>/status" class="row g-3">
                        <?php echo CSRF::field(); ?>
                        <div class="col-sm-8">
                            <label class="form-label"><?php echo htmlspecialchars($td['select_status']); ?></label>
                            <select name="status" class="form-select">
                                <option value="open" <?php echo $status === 'open' ? 'selected' : ''; ?>><?php echo htmlspecialchars($td['status_open']); ?></option>
                                <option value="in_progress" <?php echo $status === 'in_progress' ? 'selected' : ''; ?>><?php echo htmlspecialchars($td['status_in_progress']); ?></option>
                                <option value="resolved" <?php echo $status === 'resolved' ? 'selected' : ''; ?>><?php echo htmlspecialchars($td['status_resolved']); ?></option>
                                <option value="closed" <?php echo $status === 'closed' ? 'selected' : ''; ?>><?php echo htmlspecialchars($td['status_closed']); ?></option>
                            </select>
                        </div>
                        <div class="col-sm-4 d-flex align-items-end">
                            <button class="btn btn-outline-secondary w-100" type="submit"><?php echo htmlspecialchars($td['save_status']); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card admin-form-card h-100">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($td['ownership_eyebrow']); ?></p>
                        <span><?php echo htmlspecialchars($td['ownership_title']); ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="/tickets/<?php echo $ticketId; ?>/assign" class="row g-3">
                        <?php echo CSRF::field(); ?>
                        <div class="col-sm-8">
                            <label class="form-label"><?php echo htmlspecialchars($td['owner']); ?></label>
                            <select name="assigned_to" class="form-select">
                                <option value=""><?php echo htmlspecialchars($td['unassigned']); ?></option>
                                <?php foreach (($operators ?? []) as $op): ?>
                                    <option value="<?php echo (int)$op['id']; ?>" <?php echo isset($ticket['assigned_to']) && $ticket['assigned_to'] == $op['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars((string)$op['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4 d-flex align-items-end">
                            <button class="btn btn-outline-secondary w-100" type="submit"><?php echo htmlspecialchars($td['save_assignment']); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-xl-4">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($td['assets_eyebrow']); ?></p>
                    <span><?php echo htmlspecialchars($td['assets_title']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($attachments)): ?>
                    <div class="dashboard-feed">
                        <?php foreach ($attachments as $att): ?>
                            <?php $link = '/storage/tickets/' . htmlspecialchars((string)$att['stored_name']); ?>
                            <a class="dashboard-feed-item" href="<?php echo $link; ?>" target="_blank">
                                <div class="dashboard-feed-item__icon dashboard-feed-item__icon--document"><i class="fas fa-paperclip"></i></div>
                                <div class="dashboard-feed-item__content">
                                    <div class="dashboard-feed-item__top">
                                        <strong><?php echo htmlspecialchars((string)$att['original_name']); ?></strong>
                                        <span class="dashboard-link-pill"><?php echo htmlspecialchars($td['open']); ?></span>
                                    </div>
                                    <span class="dashboard-feed-item__meta"><?php echo htmlspecialchars(Locale::formatDateTime($att['uploaded_at'] ?? '')); ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-paperclip"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($td['no_attachments']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($td['conversation_eyebrow']); ?></p>
                    <span><?php echo htmlspecialchars($td['conversation_title']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($comments)): ?>
                    <div class="admin-comment-list">
                        <?php foreach (($comments ?? []) as $comment): ?>
                            <?php
                            $isInternal = (($comment['visibility'] ?? 'public') === 'internal');
                            $internalBadge = $isInternal ? '<span class="badge bg-warning text-dark">' . htmlspecialchars($td['internal']) . '</span>' : '<span class="badge bg-light text-dark border">' . htmlspecialchars($td['public']) . '</span>';
                            ?>
                            <article class="admin-comment-card <?php echo $isInternal ? 'is-internal' : ''; ?>">
                                <div class="admin-comment-card__meta">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <strong><?php echo htmlspecialchars((string)($comment['author_name'] ?? '-')); ?></strong>
                                        <?php echo $internalBadge; ?>
                                    </div>
                                    <span class="small text-muted"><?php echo htmlspecialchars(Locale::formatDateTime($comment['created_at'] ?? '', '-')); ?></span>
                                </div>
                                <div class="admin-comment-card__body"><?php echo nl2br(htmlspecialchars((string)($comment['body'] ?? ''))); ?></div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-comments"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($td['no_comments']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card admin-form-card">
    <div class="card-header border-0">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($td['reply_eyebrow']); ?></p>
            <span><?php echo htmlspecialchars($td['reply_title']); ?></span>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="/tickets/<?php echo $ticketId; ?>/comment" enctype="multipart/form-data" class="row g-3">
            <?php echo CSRF::field(); ?>
            <div class="col-12">
                <label class="form-label"><?php echo htmlspecialchars($td['message']); ?></label>
                <textarea class="form-control" name="body" rows="5" required></textarea>
            </div>
            <?php if ($canManageStatus): ?>
                <div class="col-md-6">
                    <label class="form-label"><?php echo htmlspecialchars($td['visibility']); ?></label>
                    <select name="visibility" class="form-select">
                        <option value="public"><?php echo htmlspecialchars($td['visibility_public']); ?></option>
                        <option value="internal"><?php echo htmlspecialchars($td['visibility_internal']); ?></option>
                    </select>
                </div>
            <?php endif; ?>
            <div class="col-md-6">
                <label class="form-label"><?php echo htmlspecialchars($td['optional_attachment']); ?></label>
                <input class="form-control" type="file" name="attachment">
            </div>
            <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-primary" type="submit"><i class="fas fa-comment-dots me-1"></i><?php echo htmlspecialchars($td['add_comment']); ?></button>
                <a href="/tickets" class="btn btn-outline-secondary"><?php echo htmlspecialchars($td['back']); ?></a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
