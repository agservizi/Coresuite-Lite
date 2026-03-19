<?php
use Core\Locale;
use Core\RolePermissions;

$workspaceText = [
    'it' => ['page_title' => 'Project Workspace', 'eyebrow' => 'Project workspace', 'lead' => 'Una vista unica per controllare delivery, rischio, assets e contesto cliente del progetto.', 'back' => 'Torna ai progetti', 'edit' => 'Modifica progetto', 'delete' => 'Elimina progetto', 'delete_confirm' => 'Vuoi eliminare questo progetto?', 'progress' => 'Avanzamento', 'health' => 'Salute', 'owner' => 'Owner', 'customer' => 'Cliente', 'budget' => 'Budget', 'due_date' => 'Due date', 'description' => 'Contesto progetto', 'tickets' => 'Ticket collegati', 'open_tickets' => 'Ticket aperti', 'documents' => 'Documenti cliente', 'activity' => 'Activity center', 'activity_empty' => 'Nessuna attivita registrata sul progetto.', 'recent_tickets' => 'Ultimi ticket cliente', 'recent_documents' => 'Ultimi documenti cliente', 'empty_tickets' => 'Nessun ticket disponibile.', 'empty_documents' => 'Nessun documento disponibile.', 'milestones' => 'Milestone', 'tasks' => 'Task', 'task_total' => 'Task totali', 'task_done' => 'Task chiuse', 'task_doing' => 'Task in corso', 'task_todo' => 'Task da fare', 'task_overdue' => 'Task in ritardo', 'milestone_done' => 'Milestone chiuse', 'milestone_empty' => 'Nessuna milestone definita per questo progetto.', 'task_empty' => 'Nessun task definito per questo progetto.', 'milestone_title' => 'Titolo milestone', 'task_title' => 'Titolo task', 'status' => 'Stato', 'priority' => 'Priorita', 'link_milestone' => 'Milestone collegata', 'none' => 'Nessuna', 'save_milestone' => 'Aggiungi milestone', 'save_task' => 'Aggiungi task', 'code' => 'Codice', 'delivery_hub' => 'Delivery hub', 'delivery_lead' => 'Controlla la roadmap operativa del progetto, allinea milestone e apri task esecutivi senza uscire dal workspace.', 'timeline' => 'Timeline delivery', 'upcoming' => 'In scadenza', 'task_queue' => 'Task queue', 'assignee' => 'Assegnato a', 'due' => 'Scadenza', 'update_milestone' => 'Aggiorna milestone', 'update_task' => 'Aggiorna task', 'remove' => 'Rimuovi', 'quick_status' => 'Cambia stato', 'open_board' => 'Apri board progetto'],
    'en' => ['page_title' => 'Project Workspace', 'eyebrow' => 'Project workspace', 'lead' => 'A single view to control delivery, risk, assets, and customer context for the project.', 'back' => 'Back to projects', 'edit' => 'Edit project', 'delete' => 'Delete project', 'delete_confirm' => 'Delete this project?', 'progress' => 'Progress', 'health' => 'Health', 'owner' => 'Owner', 'customer' => 'Customer', 'budget' => 'Budget', 'due_date' => 'Due date', 'description' => 'Project context', 'tickets' => 'Related tickets', 'open_tickets' => 'Open tickets', 'documents' => 'Customer documents', 'activity' => 'Activity center', 'activity_empty' => 'No activity logged for this project.', 'recent_tickets' => 'Latest customer tickets', 'recent_documents' => 'Latest customer documents', 'empty_tickets' => 'No tickets available.', 'empty_documents' => 'No documents available.', 'milestones' => 'Milestones', 'tasks' => 'Tasks', 'task_total' => 'Total tasks', 'task_done' => 'Closed tasks', 'task_doing' => 'Tasks in progress', 'task_todo' => 'Tasks to do', 'task_overdue' => 'Overdue tasks', 'milestone_done' => 'Closed milestones', 'milestone_empty' => 'No milestones defined for this project.', 'task_empty' => 'No tasks defined for this project.', 'milestone_title' => 'Milestone title', 'task_title' => 'Task title', 'status' => 'Status', 'priority' => 'Priority', 'link_milestone' => 'Linked milestone', 'none' => 'None', 'save_milestone' => 'Add milestone', 'save_task' => 'Add task', 'code' => 'Code', 'delivery_hub' => 'Delivery hub', 'delivery_lead' => 'Control the project roadmap, align milestones, and open execution tasks without leaving the workspace.', 'timeline' => 'Delivery timeline', 'upcoming' => 'Upcoming', 'task_queue' => 'Task queue', 'assignee' => 'Assignee', 'due' => 'Due', 'update_milestone' => 'Update milestone', 'update_task' => 'Update task', 'remove' => 'Remove', 'quick_status' => 'Change status', 'open_board' => 'Open project board'],
    'fr' => ['page_title' => 'Project Workspace', 'eyebrow' => 'Project workspace', 'lead' => 'Une vue unique pour controler delivery, risque, assets et contexte client du projet.', 'back' => 'Retour aux projets', 'edit' => 'Modifier projet', 'delete' => 'Supprimer projet', 'delete_confirm' => 'Supprimer ce projet ?', 'progress' => 'Progression', 'health' => 'Sante', 'owner' => 'Responsable', 'customer' => 'Client', 'budget' => 'Budget', 'due_date' => 'Echeance', 'description' => 'Contexte projet', 'tickets' => 'Tickets lies', 'open_tickets' => 'Tickets ouverts', 'documents' => 'Documents client', 'activity' => 'Centre d activite', 'activity_empty' => 'Aucune activite enregistree pour ce projet.', 'recent_tickets' => 'Derniers tickets client', 'recent_documents' => 'Derniers documents client', 'empty_tickets' => 'Aucun ticket disponible.', 'empty_documents' => 'Aucun document disponible.', 'milestones' => 'Jalons', 'tasks' => 'Taches', 'task_total' => 'Taches totales', 'task_done' => 'Taches fermees', 'task_doing' => 'Taches en cours', 'task_todo' => 'Taches a faire', 'task_overdue' => 'Taches en retard', 'milestone_done' => 'Jalons clotures', 'milestone_empty' => 'Aucun jalon defini pour ce projet.', 'task_empty' => 'Aucune tache definie pour ce projet.', 'milestone_title' => 'Titre du jalon', 'task_title' => 'Titre de la tache', 'status' => 'Statut', 'priority' => 'Priorite', 'link_milestone' => 'Jalon lie', 'none' => 'Aucun', 'save_milestone' => 'Ajouter un jalon', 'save_task' => 'Ajouter une tache', 'code' => 'Code', 'delivery_hub' => 'Hub delivery', 'delivery_lead' => 'Pilotez la roadmap du projet, alignez les jalons et ouvrez les taches d execution sans quitter le workspace.', 'timeline' => 'Timeline delivery', 'upcoming' => 'A venir', 'task_queue' => 'File de taches', 'assignee' => 'Assigne a', 'due' => 'Echeance', 'update_milestone' => 'Mettre a jour jalon', 'update_task' => 'Mettre a jour tache', 'remove' => 'Retirer', 'quick_status' => 'Changer statut', 'open_board' => 'Ouvrir board projet'],
    'es' => ['page_title' => 'Project Workspace', 'eyebrow' => 'Project workspace', 'lead' => 'Una vista unica para controlar delivery, riesgo, assets y contexto cliente del proyecto.', 'back' => 'Volver a proyectos', 'edit' => 'Editar proyecto', 'delete' => 'Eliminar proyecto', 'delete_confirm' => 'Eliminar este proyecto?', 'progress' => 'Progreso', 'health' => 'Salud', 'owner' => 'Responsable', 'customer' => 'Cliente', 'budget' => 'Presupuesto', 'due_date' => 'Vencimiento', 'description' => 'Contexto del proyecto', 'tickets' => 'Tickets relacionados', 'open_tickets' => 'Tickets abiertos', 'documents' => 'Documentos del cliente', 'activity' => 'Centro de actividad', 'activity_empty' => 'No hay actividad registrada para este proyecto.', 'recent_tickets' => 'Ultimos tickets del cliente', 'recent_documents' => 'Ultimos documentos del cliente', 'empty_tickets' => 'No hay tickets disponibles.', 'empty_documents' => 'No hay documentos disponibles.', 'milestones' => 'Hitos', 'tasks' => 'Tareas', 'task_total' => 'Tareas totales', 'task_done' => 'Tareas cerradas', 'task_doing' => 'Tareas en curso', 'task_todo' => 'Tareas por hacer', 'task_overdue' => 'Tareas vencidas', 'milestone_done' => 'Hitos cerrados', 'milestone_empty' => 'No hay hitos definidos para este proyecto.', 'task_empty' => 'No hay tareas definidas para este proyecto.', 'milestone_title' => 'Titulo del hito', 'task_title' => 'Titulo de la tarea', 'status' => 'Estado', 'priority' => 'Prioridad', 'link_milestone' => 'Hito vinculado', 'none' => 'Ninguno', 'save_milestone' => 'Agregar hito', 'save_task' => 'Agregar tarea', 'code' => 'Codigo', 'delivery_hub' => 'Hub de delivery', 'delivery_lead' => 'Controla la hoja de ruta del proyecto, alinea hitos y abre tareas de ejecucion sin salir del workspace.', 'timeline' => 'Timeline delivery', 'upcoming' => 'Proximo', 'task_queue' => 'Cola de tareas', 'assignee' => 'Asignado a', 'due' => 'Vence', 'update_milestone' => 'Actualizar hito', 'update_task' => 'Actualizar tarea', 'remove' => 'Eliminar', 'quick_status' => 'Cambiar estado', 'open_board' => 'Abrir board proyecto'],
];
$wt = $workspaceText[Locale::current()] ?? $workspaceText['it'];
$pageTitle = $wt['page_title'];
$upcomingMilestones = count(array_filter((array)$milestones, static fn ($milestone) => !empty($milestone['due_date'])));

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($wt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars((string)($project['name'] ?? 'Project')); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($wt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/projects" class="btn btn-outline-secondary"><?php echo htmlspecialchars($wt['back']); ?></a>
        <a href="/projects/board" class="btn btn-outline-secondary"><?php echo htmlspecialchars($wt['open_board']); ?></a>
        <?php if (RolePermissions::canCurrent('projects_manage')): ?>
            <a href="/projects/<?php echo (int)$project['id']; ?>/edit" class="btn btn-primary">
                <i class="fas fa-pen me-2"></i><?php echo htmlspecialchars($wt['edit']); ?>
            </a>
            <form method="POST" action="/projects/<?php echo (int)$project['id']; ?>/delete" class="d-inline">
                <?php echo CSRF::field(); ?>
                <button class="btn btn-outline-danger" type="submit" onclick="return confirm('<?php echo htmlspecialchars($wt['delete_confirm']); ?>')"><?php echo htmlspecialchars($wt['delete']); ?></button>
            </form>
        <?php endif; ?>
    </div>
</section>

<div class="row g-3 mb-4 admin-kpi-grid">
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--customers h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($wt['progress']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)($project['progress'] ?? 0); ?>%</p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars((string)($project['status_label'] ?? '')); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--tickets h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($wt['health']); ?></div>
                <p class="admin-kpi-value"><?php echo htmlspecialchars((string)($project['health_label'] ?? '')); ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars((string)($project['priority_label'] ?? '')); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--open h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($wt['tickets']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)$ticketsTotal; ?></p>
                <p class="admin-kpi-label"><?php echo (int)$ticketsOpen; ?> <?php echo htmlspecialchars($wt['open_tickets']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--documents h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($wt['documents']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)$documentsTotal; ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars(Locale::formatDate($project['due_date'] ?? '', '-')); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-4">
        <div class="card admin-data-card h-100">
            <div class="card-body">
                <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($wt['description']); ?></p>
                <div class="admin-summary-stack">
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($wt['owner']); ?></span><strong><?php echo htmlspecialchars((string)($project['owner_name'] ?? 'Core team')); ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($wt['customer']); ?></span><strong><?php echo htmlspecialchars((string)($project['customer_name'] ?? '-')); ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($wt['budget']); ?></span><strong><?php echo $project['budget'] !== null ? htmlspecialchars(number_format((float)$project['budget'], 2, ',', '.')) : '-'; ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($wt['due_date']); ?></span><strong><?php echo htmlspecialchars(Locale::formatDate($project['due_date'] ?? '', '-')); ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($wt['code']); ?></span><strong><?php echo htmlspecialchars((string)($project['code'] ?? '-')); ?></strong></div>
                </div>
                <?php if (!empty($project['description'])): ?>
                    <div class="project-workspace-note mt-3"><?php echo nl2br(htmlspecialchars((string)$project['description'])); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wt['activity']); ?></p>
                    <span><?php echo htmlspecialchars((string)($project['code'] ?? '')); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($activity)): ?>
                    <div class="project-timeline">
                        <?php foreach ($activity as $item): ?>
                            <div class="project-timeline__item">
                                <strong><?php echo htmlspecialchars((string)($item['action'] ?? 'update')); ?></strong>
                                <span><?php echo htmlspecialchars((string)($item['entity'] ?? 'project')); ?> • <?php echo htmlspecialchars((string)($item['actor_name'] ?? 'System')); ?></span>
                                <small><?php echo htmlspecialchars(Locale::formatDateTime($item['created_at'] ?? '')); ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state"><i class="fas fa-clock-rotate-left"></i><p class="mb-0"><?php echo htmlspecialchars($wt['activity_empty']); ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<section class="project-delivery-shell mb-4">
    <div class="project-delivery-shell__head">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wt['delivery_hub']); ?></p>
            <h3 class="project-delivery-shell__title"><?php echo htmlspecialchars($wt['timeline']); ?></h3>
        </div>
        <p class="project-delivery-shell__lead"><?php echo htmlspecialchars($wt['delivery_lead']); ?></p>
    </div>
    <div class="project-summary-strip">
        <div class="project-summary-chip">
            <span><?php echo htmlspecialchars($wt['milestones']); ?></span>
            <strong><?php echo count((array)$milestones); ?></strong>
        </div>
        <div class="project-summary-chip">
            <span><?php echo htmlspecialchars($wt['upcoming']); ?></span>
            <strong><?php echo $upcomingMilestones; ?></strong>
        </div>
        <div class="project-summary-chip">
            <span><?php echo htmlspecialchars($wt['task_queue']); ?></span>
            <strong><?php echo (int)($taskSummary['total'] ?? 0); ?></strong>
        </div>
        <div class="project-summary-chip">
            <span><?php echo htmlspecialchars($wt['task_done']); ?></span>
            <strong><?php echo (int)($taskSummary['done'] ?? 0); ?></strong>
        </div>
        <div class="project-summary-chip">
            <span><?php echo htmlspecialchars($wt['milestone_done']); ?></span>
            <strong><?php echo (int)($milestoneCompleted ?? 0); ?></strong>
        </div>
        <div class="project-summary-chip">
            <span><?php echo htmlspecialchars($wt['task_overdue']); ?></span>
            <strong><?php echo (int)($taskSummary['overdue'] ?? 0); ?></strong>
        </div>
    </div>
</section>

<div class="row g-3 mb-4 project-delivery-grid">
    <div class="col-xl-5">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wt['milestones']); ?></p>
                    <span><?php echo count((array)$milestones); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (RolePermissions::canCurrent('projects_manage')): ?>
                    <form method="POST" action="/projects/<?php echo (int)$project['id']; ?>/milestones" class="project-inline-form mb-3">
                        <?php echo CSRF::field(); ?>
                        <div class="project-inline-form__grid project-inline-form__grid--milestone">
                            <input class="form-control" type="text" name="title" placeholder="<?php echo htmlspecialchars($wt['milestone_title']); ?>" required>
                            <select class="form-select" name="status">
                                <?php foreach (['planned','active','done'] as $status): ?>
                                    <option value="<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($this->labelFor('milestone_status', $status)); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="date-input-shell">
                                <span class="date-input-shell__icon" aria-hidden="true"><i class="fas fa-calendar-day"></i></span>
                                <input class="form-control date-input-shell__control" type="date" name="due_date">
                            </label>
                        </div>
                        <button class="btn btn-outline-secondary w-100" type="submit"><?php echo htmlspecialchars($wt['save_milestone']); ?></button>
                    </form>
                <?php endif; ?>

                <?php if (!empty($milestones)): ?>
                    <div class="project-milestone-list">
                        <?php foreach ($milestones as $milestone): ?>
                            <div class="project-milestone-card">
                                <div class="project-milestone-card__top">
                                    <div>
                                        <p class="project-milestone-card__eyebrow"><?php echo htmlspecialchars($wt['milestones']); ?></p>
                                        <strong><?php echo htmlspecialchars((string)$milestone['title']); ?></strong>
                                    </div>
                                    <span class="project-status-badge project-status-badge--milestone"><?php echo htmlspecialchars((string)$milestone['status_label']); ?></span>
                                </div>
                                <div class="project-milestone-card__meta">
                                    <span><?php echo htmlspecialchars($wt['due']); ?></span>
                                    <strong><?php echo htmlspecialchars(Locale::formatDate($milestone['due_date'] ?? '', '-')); ?></strong>
                                </div>
                                <?php if (RolePermissions::canCurrent('projects_manage')): ?>
                                    <form method="POST" action="/projects/<?php echo (int)$project['id']; ?>/milestones/<?php echo (int)$milestone['id']; ?>/update" class="project-card-form">
                                        <?php echo CSRF::field(); ?>
                                        <input class="form-control" type="text" name="title" value="<?php echo htmlspecialchars((string)$milestone['title']); ?>" required>
                                        <div class="project-card-form__grid">
                                            <select class="form-select" name="status">
                                                <?php foreach (['planned','active','done'] as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($milestone['status'] ?? 'planned') === $status ? 'selected' : ''; ?>><?php echo htmlspecialchars($this->labelFor('milestone_status', $status)); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label class="date-input-shell">
                                                <span class="date-input-shell__icon" aria-hidden="true"><i class="fas fa-calendar-day"></i></span>
                                                <input class="form-control date-input-shell__control" type="date" name="due_date" value="<?php echo htmlspecialchars((string)($milestone['due_date'] ?? '')); ?>">
                                            </label>
                                        </div>
                                        <div class="project-card-form__actions">
                                            <button class="btn btn-outline-secondary btn-sm" type="submit"><?php echo htmlspecialchars($wt['update_milestone']); ?></button>
                                            <button class="btn btn-outline-danger btn-sm" formaction="/projects/<?php echo (int)$project['id']; ?>/milestones/<?php echo (int)$milestone['id']; ?>/delete" onclick="return confirm('<?php echo htmlspecialchars($wt['delete_confirm']); ?>')" type="submit"><?php echo htmlspecialchars($wt['remove']); ?></button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state"><i class="fas fa-flag-checkered"></i><p class="mb-0"><?php echo htmlspecialchars($wt['milestone_empty']); ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wt['tasks']); ?></p>
                    <span><?php echo (int)($taskSummary['total'] ?? 0); ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="project-task-kpis mb-3">
                    <div class="project-task-kpi"><span><?php echo htmlspecialchars($wt['task_total']); ?></span><strong><?php echo (int)($taskSummary['total'] ?? 0); ?></strong></div>
                    <div class="project-task-kpi"><span><?php echo htmlspecialchars($wt['task_doing']); ?></span><strong><?php echo (int)($taskSummary['doing'] ?? 0); ?></strong></div>
                    <div class="project-task-kpi"><span><?php echo htmlspecialchars($wt['task_todo']); ?></span><strong><?php echo (int)($taskSummary['todo'] ?? 0); ?></strong></div>
                    <div class="project-task-kpi"><span><?php echo htmlspecialchars($wt['task_done']); ?></span><strong><?php echo (int)($taskSummary['done'] ?? 0); ?></strong></div>
                </div>

                <?php if (RolePermissions::canCurrent('projects_manage')): ?>
                    <form method="POST" action="/projects/<?php echo (int)$project['id']; ?>/tasks" class="project-inline-form mb-3">
                        <?php echo CSRF::field(); ?>
                        <div class="project-inline-form__grid project-inline-form__grid--task">
                            <input class="form-control" type="text" name="title" placeholder="<?php echo htmlspecialchars($wt['task_title']); ?>" required>
                            <select class="form-select" name="status">
                                <?php foreach (['todo','doing','done'] as $status): ?>
                                    <option value="<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($this->labelFor('task_status', $status)); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-select" name="priority">
                                <?php foreach (['low','medium','high'] as $priority): ?>
                                    <option value="<?php echo htmlspecialchars($priority); ?>"><?php echo htmlspecialchars($this->labelFor('priority', $priority)); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="date-input-shell">
                                <span class="date-input-shell__icon" aria-hidden="true"><i class="fas fa-calendar-day"></i></span>
                                <input class="form-control date-input-shell__control" type="date" name="due_date">
                            </label>
                            <select class="form-select" name="milestone_id">
                                <option value=""><?php echo htmlspecialchars($wt['link_milestone']); ?>: <?php echo htmlspecialchars($wt['none']); ?></option>
                                <?php foreach ((array)$milestones as $milestone): ?>
                                    <option value="<?php echo (int)$milestone['id']; ?>"><?php echo htmlspecialchars((string)$milestone['title']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-select" name="assignee_id">
                                <option value=""><?php echo htmlspecialchars($wt['assignee']); ?>: <?php echo htmlspecialchars($wt['none']); ?></option>
                                <?php foreach ((array)$assignableUsers as $member): ?>
                                    <option value="<?php echo (int)$member['id']; ?>"><?php echo htmlspecialchars((string)$member['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-primary w-100" type="submit"><?php echo htmlspecialchars($wt['save_task']); ?></button>
                    </form>
                <?php endif; ?>

                <?php if (!empty($tasks)): ?>
                    <div class="project-task-list">
                        <?php foreach ($tasks as $task): ?>
                            <div class="project-task-card">
                                <div class="project-task-card__top">
                                    <div>
                                        <p class="project-task-card__eyebrow"><?php echo htmlspecialchars($wt['tasks']); ?></p>
                                        <strong><?php echo htmlspecialchars((string)$task['title']); ?></strong>
                                    </div>
                                    <span class="project-status-badge project-status-badge--task"><?php echo htmlspecialchars((string)$task['status_label']); ?></span>
                                </div>
                                <div class="project-task-card__meta">
                                    <span><?php echo htmlspecialchars((string)$task['priority_label']); ?></span>
                                    <?php if (!empty($task['assignee_name'])): ?><span><?php echo htmlspecialchars($wt['assignee']); ?>: <?php echo htmlspecialchars((string)$task['assignee_name']); ?></span><?php endif; ?>
                                    <?php if (!empty($task['due_date'])): ?><span><?php echo htmlspecialchars($wt['due']); ?>: <?php echo htmlspecialchars(Locale::formatDate($task['due_date'])); ?></span><?php endif; ?>
                                    <?php if (!empty($task['milestone_title'])): ?><span><?php echo htmlspecialchars((string)$task['milestone_title']); ?></span><?php endif; ?>
                                </div>
                                <?php if (RolePermissions::canCurrent('projects_manage')): ?>
                                    <div class="project-task-status-row">
                                        <span><?php echo htmlspecialchars($wt['quick_status']); ?></span>
                                        <form method="POST" action="/projects/<?php echo (int)$project['id']; ?>/tasks/<?php echo (int)$task['id']; ?>/status" class="project-status-inline">
                                            <?php echo CSRF::field(); ?>
                                            <?php foreach (['todo','doing','done'] as $status): ?>
                                                <button class="admin-pill <?php echo ($task['status'] ?? 'todo') === $status ? 'is-active' : ''; ?>" type="submit" name="status" value="<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($this->labelFor('task_status', $status)); ?></button>
                                            <?php endforeach; ?>
                                        </form>
                                    </div>
                                    <form method="POST" action="/projects/<?php echo (int)$project['id']; ?>/tasks/<?php echo (int)$task['id']; ?>/update" class="project-card-form">
                                        <?php echo CSRF::field(); ?>
                                        <input class="form-control" type="text" name="title" value="<?php echo htmlspecialchars((string)$task['title']); ?>" required>
                                        <div class="project-card-form__grid project-card-form__grid--task">
                                            <select class="form-select" name="status">
                                                <?php foreach (['todo','doing','done'] as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status); ?>" <?php echo ($task['status'] ?? 'todo') === $status ? 'selected' : ''; ?>><?php echo htmlspecialchars($this->labelFor('task_status', $status)); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select class="form-select" name="priority">
                                                <?php foreach (['low','medium','high'] as $priority): ?>
                                                    <option value="<?php echo htmlspecialchars($priority); ?>" <?php echo ($task['priority'] ?? 'medium') === $priority ? 'selected' : ''; ?>><?php echo htmlspecialchars($this->labelFor('priority', $priority)); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label class="date-input-shell">
                                                <span class="date-input-shell__icon" aria-hidden="true"><i class="fas fa-calendar-day"></i></span>
                                                <input class="form-control date-input-shell__control" type="date" name="due_date" value="<?php echo htmlspecialchars((string)($task['due_date'] ?? '')); ?>">
                                            </label>
                                            <select class="form-select" name="milestone_id">
                                                <option value=""><?php echo htmlspecialchars($wt['link_milestone']); ?>: <?php echo htmlspecialchars($wt['none']); ?></option>
                                                <?php foreach ((array)$milestones as $milestone): ?>
                                                    <option value="<?php echo (int)$milestone['id']; ?>" <?php echo (int)($task['milestone_id'] ?? 0) === (int)$milestone['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars((string)$milestone['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select class="form-select" name="assignee_id">
                                                <option value=""><?php echo htmlspecialchars($wt['assignee']); ?>: <?php echo htmlspecialchars($wt['none']); ?></option>
                                                <?php foreach ((array)$assignableUsers as $member): ?>
                                                    <option value="<?php echo (int)$member['id']; ?>" <?php echo (int)($task['assignee_id'] ?? 0) === (int)$member['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars((string)$member['name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="project-card-form__actions">
                                            <button class="btn btn-outline-secondary btn-sm" type="submit"><?php echo htmlspecialchars($wt['update_task']); ?></button>
                                            <button class="btn btn-outline-danger btn-sm" formaction="/projects/<?php echo (int)$project['id']; ?>/tasks/<?php echo (int)$task['id']; ?>/delete" onclick="return confirm('<?php echo htmlspecialchars($wt['delete_confirm']); ?>')" type="submit"><?php echo htmlspecialchars($wt['remove']); ?></button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state"><i class="fas fa-list-check"></i><p class="mb-0"><?php echo htmlspecialchars($wt['task_empty']); ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-6">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wt['recent_tickets']); ?></p>
                    <span><?php echo htmlspecialchars($wt['tickets']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($recentTickets)): ?>
                    <div class="search-result-list">
                        <?php foreach ($recentTickets as $ticket): ?>
                            <a class="search-result-item dashboard-hoverlift" href="/tickets/<?php echo (int)$ticket['id']; ?>">
                                <div class="search-result-item__top"><strong><?php echo htmlspecialchars((string)$ticket['subject']); ?></strong><span class="search-result-item__meta"><?php echo htmlspecialchars((string)$ticket['priority']); ?></span></div>
                                <div class="search-result-item__sub"><span><?php echo htmlspecialchars((string)$ticket['category']); ?></span><span><?php echo htmlspecialchars((string)$ticket['status']); ?></span></div>
                                <small><?php echo htmlspecialchars(Locale::formatDateTime($ticket['created_at'] ?? '')); ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state"><i class="fas fa-ticket-alt"></i><p class="mb-0"><?php echo htmlspecialchars($wt['empty_tickets']); ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card admin-data-card h-100">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($wt['recent_documents']); ?></p>
                    <span><?php echo htmlspecialchars($wt['documents']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($recentDocuments)): ?>
                    <div class="search-result-list">
                        <?php foreach ($recentDocuments as $document): ?>
                            <a class="search-result-item dashboard-hoverlift" href="/documents/<?php echo (int)$document['id']; ?>/download">
                                <div class="search-result-item__top"><strong><?php echo htmlspecialchars((string)$document['filename_original']); ?></strong><span class="search-result-item__meta"><?php echo round(((int)$document['size']) / 1024, 1); ?> KB</span></div>
                                <div class="search-result-item__sub"><span><?php echo htmlspecialchars((string)$document['mime']); ?></span></div>
                                <small><?php echo htmlspecialchars(Locale::formatDateTime($document['created_at'] ?? '')); ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state"><i class="fas fa-file-lines"></i><p class="mb-0"><?php echo htmlspecialchars($wt['empty_documents']); ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
