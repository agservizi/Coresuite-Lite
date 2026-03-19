<?php
use Core\Auth;
use Core\Locale;

$formText = [
    'it' => ['page_title_create' => 'Nuovo progetto', 'page_title_edit' => 'Modifica progetto', 'eyebrow' => 'Project workflow', 'title_create' => 'Imposta struttura, owner e milestone del progetto', 'title_edit' => 'Aggiorna stato, contesto e controllo delivery del progetto', 'lead' => 'Un form guidato per configurare commessa, salute, scadenze e relazione cliente in un solo passaggio.', 'back' => 'Torna ai progetti', 'save' => 'Salva progetto', 'update' => 'Aggiorna progetto', 'name' => 'Nome progetto', 'code' => 'Codice', 'customer' => 'Cliente', 'owner' => 'Responsabile', 'status' => 'Stato', 'priority' => 'Priorita', 'health' => 'Salute', 'progress' => 'Avanzamento %', 'budget' => 'Budget', 'start_date' => 'Data inizio', 'due_date' => 'Data consegna', 'tags' => 'Tag', 'description' => 'Descrizione', 'summary_title' => 'Delivery summary', 'summary_text' => 'Definisci un progetto leggibile subito da board, workspace e ricerca globale.', 'tips_title' => 'Best practice', 'tip_1' => 'Usa un codice breve e unico per velocizzare la ricerca.', 'tip_2' => 'Aggiorna salute e progress per rendere affidabile il portfolio.', 'tip_3' => 'Associa un cliente quando il progetto impatta ticket e documenti.', 'placeholder_name' => 'Migrazione workspace retail', 'placeholder_code' => 'PRJ-2401', 'placeholder_tags' => 'retail, migration, q2', 'placeholder_description' => 'Contesto, milestone, note operative e output attesi.', 'step_identity' => 'Identita progetto', 'step_control' => 'Controllo delivery', 'step_notes' => 'Contesto e note', 'identity_lead' => 'Definisci naming, codice e relazione cliente.', 'control_lead' => 'Imposta il livello di presidio per portfolio e board.', 'notes_lead' => 'Raccogli contesto operativo, tag e tempi di delivery.', 'preview_title' => 'Live preview', 'preview_empty' => 'Il nome progetto apparira qui in tempo reale.', 'preview_customer' => 'Cliente collegato', 'preview_owner' => 'Responsabile', 'preview_dates' => 'Timeline', 'preview_code' => 'Codice operativo', 'preview_budget' => 'Budget attuale', 'preview_health' => 'Health pulse', 'assist_title' => 'Assistente setup', 'assist_ready' => 'Pronto per il delivery board', 'assist_watch' => 'Serve ancora contesto operativo', 'assist_risk' => 'Rischio alto, serve presidio', 'progress_hint' => 'Muovi il cursore per aggiornare l avanzamento percepito del progetto.', 'generate_code' => 'Genera codice', 'days_label' => 'giorni pianificati', 'dates_pending' => 'Date da definire', 'completion_copy' => 'compilazione del setup', 'customer_none' => 'Nessun cliente collegato', 'owner_none' => 'Responsabile da assegnare', 'label_required' => 'Campo chiave'],
    'en' => ['page_title_create' => 'New project', 'page_title_edit' => 'Edit project', 'eyebrow' => 'Project workflow', 'title_create' => 'Set structure, owner, and milestones for the project', 'title_edit' => 'Update status, context, and delivery control for the project', 'lead' => 'A guided form to configure workstream, health, deadlines, and customer relation in one flow.', 'back' => 'Back to projects', 'save' => 'Save project', 'update' => 'Update project', 'name' => 'Project name', 'code' => 'Code', 'customer' => 'Customer', 'owner' => 'Owner', 'status' => 'Status', 'priority' => 'Priority', 'health' => 'Health', 'progress' => 'Progress %', 'budget' => 'Budget', 'start_date' => 'Start date', 'due_date' => 'Due date', 'tags' => 'Tags', 'description' => 'Description', 'summary_title' => 'Delivery summary', 'summary_text' => 'Define a project that is immediately readable from board, workspace, and global search.', 'tips_title' => 'Best practices', 'tip_1' => 'Use a short unique code to speed up search.', 'tip_2' => 'Update health and progress to keep the portfolio reliable.', 'tip_3' => 'Attach a customer whenever the project impacts tickets and documents.', 'placeholder_name' => 'Retail workspace migration', 'placeholder_code' => 'PRJ-2401', 'placeholder_tags' => 'retail, migration, q2', 'placeholder_description' => 'Context, milestones, operational notes, and expected outputs.', 'step_identity' => 'Project identity', 'step_control' => 'Delivery control', 'step_notes' => 'Context and notes', 'identity_lead' => 'Define naming, code, and customer relation.', 'control_lead' => 'Set the level of control for portfolio and board.', 'notes_lead' => 'Collect delivery context, tags, and timing.', 'preview_title' => 'Live preview', 'preview_empty' => 'The project name will appear here in real time.', 'preview_customer' => 'Linked customer', 'preview_owner' => 'Owner', 'preview_dates' => 'Timeline', 'preview_code' => 'Operating code', 'preview_budget' => 'Current budget', 'preview_health' => 'Health pulse', 'assist_title' => 'Setup assistant', 'assist_ready' => 'Ready for the delivery board', 'assist_watch' => 'Operational context still needed', 'assist_risk' => 'High risk, needs attention', 'progress_hint' => 'Move the slider to update perceived project progress.', 'generate_code' => 'Generate code', 'days_label' => 'planned days', 'dates_pending' => 'Dates to define', 'completion_copy' => 'setup completion', 'customer_none' => 'No linked customer', 'owner_none' => 'Assign an owner', 'label_required' => 'Key field'],
    'fr' => ['page_title_create' => 'Nouveau projet', 'page_title_edit' => 'Modifier projet', 'eyebrow' => 'Project workflow', 'title_create' => 'Definir structure, owner et milestones du projet', 'title_edit' => 'Mettre a jour statut, contexte et controle delivery du projet', 'lead' => 'Un formulaire guide pour configurer chantier, sante, echeances et relation client dans un seul flux.', 'back' => 'Retour aux projets', 'save' => 'Enregistrer projet', 'update' => 'Mettre a jour projet', 'name' => 'Nom projet', 'code' => 'Code', 'customer' => 'Client', 'owner' => 'Responsable', 'status' => 'Statut', 'priority' => 'Priorite', 'health' => 'Sante', 'progress' => 'Avancement %', 'budget' => 'Budget', 'start_date' => 'Date debut', 'due_date' => 'Date livraison', 'tags' => 'Tags', 'description' => 'Description', 'summary_title' => 'Delivery summary', 'summary_text' => 'Definissez un projet lisible immediatement depuis board, workspace et recherche globale.', 'tips_title' => 'Bonnes pratiques', 'tip_1' => 'Utilisez un code court et unique pour accelerer la recherche.', 'tip_2' => 'Mettez a jour sante et progression pour garder un portefeuille fiable.', 'tip_3' => 'Associez un client quand le projet impacte tickets et documents.', 'placeholder_name' => 'Migration workspace retail', 'placeholder_code' => 'PRJ-2401', 'placeholder_tags' => 'retail, migration, q2', 'placeholder_description' => 'Contexte, milestones, notes operationnelles et livrables attendus.', 'step_identity' => 'Identite projet', 'step_control' => 'Controle delivery', 'step_notes' => 'Contexte et notes', 'identity_lead' => 'Definissez naming, code et relation client.', 'control_lead' => 'Reglez le niveau de pilotage pour portefeuille et board.', 'notes_lead' => 'Rassemblez contexte, tags et timing de delivery.', 'preview_title' => 'Live preview', 'preview_empty' => 'Le nom du projet apparaitra ici en temps reel.', 'preview_customer' => 'Client lie', 'preview_owner' => 'Responsable', 'preview_dates' => 'Timeline', 'preview_code' => 'Code operationnel', 'preview_budget' => 'Budget actuel', 'preview_health' => 'Health pulse', 'assist_title' => 'Assistant setup', 'assist_ready' => 'Pret pour la delivery board', 'assist_watch' => 'Le contexte operationnel manque encore', 'assist_risk' => 'Risque eleve, surveillance requise', 'progress_hint' => 'Deplacez le curseur pour mettre a jour l avancement percu du projet.', 'generate_code' => 'Generer code', 'days_label' => 'jours planifies', 'dates_pending' => 'Dates a definir', 'completion_copy' => 'completion du setup', 'customer_none' => 'Aucun client lie', 'owner_none' => 'Responsable a definir', 'label_required' => 'Champ cle'],
    'es' => ['page_title_create' => 'Nuevo proyecto', 'page_title_edit' => 'Editar proyecto', 'eyebrow' => 'Project workflow', 'title_create' => 'Define estructura, owner y milestones del proyecto', 'title_edit' => 'Actualiza estado, contexto y control delivery del proyecto', 'lead' => 'Un formulario guiado para configurar linea de trabajo, salud, vencimientos y relacion cliente en un solo flujo.', 'back' => 'Volver a proyectos', 'save' => 'Guardar proyecto', 'update' => 'Actualizar proyecto', 'name' => 'Nombre del proyecto', 'code' => 'Codigo', 'customer' => 'Cliente', 'owner' => 'Responsable', 'status' => 'Estado', 'priority' => 'Prioridad', 'health' => 'Salud', 'progress' => 'Avance %', 'budget' => 'Presupuesto', 'start_date' => 'Fecha inicio', 'due_date' => 'Fecha entrega', 'tags' => 'Tags', 'description' => 'Descripcion', 'summary_title' => 'Delivery summary', 'summary_text' => 'Define un proyecto legible desde board, workspace y busqueda global.', 'tips_title' => 'Buenas practicas', 'tip_1' => 'Usa un codigo corto y unico para acelerar la busqueda.', 'tip_2' => 'Actualiza salud y avance para mantener fiable el portfolio.', 'tip_3' => 'Asocia un cliente cuando el proyecto impacta tickets y documentos.', 'placeholder_name' => 'Migracion workspace retail', 'placeholder_code' => 'PRJ-2401', 'placeholder_tags' => 'retail, migration, q2', 'placeholder_description' => 'Contexto, milestones, notas operativas y entregables esperados.', 'step_identity' => 'Identidad del proyecto', 'step_control' => 'Control delivery', 'step_notes' => 'Contexto y notas', 'identity_lead' => 'Define naming, codigo y relacion cliente.', 'control_lead' => 'Ajusta el nivel de control para portfolio y board.', 'notes_lead' => 'Recoge contexto, tags y tiempos de delivery.', 'preview_title' => 'Live preview', 'preview_empty' => 'El nombre del proyecto aparecera aqui en tiempo real.', 'preview_customer' => 'Cliente vinculado', 'preview_owner' => 'Responsable', 'preview_dates' => 'Timeline', 'preview_code' => 'Codigo operativo', 'preview_budget' => 'Presupuesto actual', 'preview_health' => 'Health pulse', 'assist_title' => 'Asistente setup', 'assist_ready' => 'Listo para el delivery board', 'assist_watch' => 'Todavia falta contexto operativo', 'assist_risk' => 'Riesgo alto, requiere seguimiento', 'progress_hint' => 'Mueve el control para actualizar el avance percibido del proyecto.', 'generate_code' => 'Generar codigo', 'days_label' => 'dias planificados', 'dates_pending' => 'Fechas por definir', 'completion_copy' => 'completado del setup', 'customer_none' => 'Sin cliente vinculado', 'owner_none' => 'Responsable por definir', 'label_required' => 'Campo clave'],
];
$ft = $formText[Locale::current()] ?? $formText['it'];
$isEdit = !empty($project['id']);
$pageTitle = $isEdit ? $ft['page_title_edit'] : $ft['page_title_create'];
$action = $isEdit ? '/projects/' . (int)$project['id'] : '/projects';
$completionFields = [
    !empty($project['name']),
    !empty($project['code']),
    !empty($project['status']),
    !empty($project['health']),
    !empty($project['priority']),
    !empty($project['description']),
];
$completionPercent = (int)round((array_sum(array_map(fn($value) => $value ? 1 : 0, $completionFields)) / count($completionFields)) * 100);

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($ft['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($isEdit ? $ft['title_edit'] : $ft['title_create']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($ft['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/projects" class="btn btn-outline-secondary"><?php echo htmlspecialchars($ft['back']); ?></a>
    </div>
</section>

<div class="admin-form-shell project-form-shell mb-4">
    <div class="admin-form-stepper">
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">1</span>
            <div><strong><?php echo htmlspecialchars($ft['step_identity']); ?></strong><small><?php echo htmlspecialchars($ft['identity_lead']); ?></small></div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">2</span>
            <div><strong><?php echo htmlspecialchars($ft['step_control']); ?></strong><small><?php echo htmlspecialchars($ft['control_lead']); ?></small></div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">3</span>
            <div><strong><?php echo htmlspecialchars($ft['step_notes']); ?></strong><small><?php echo htmlspecialchars($ft['notes_lead']); ?></small></div>
        </div>
    </div>
</div>

<div class="admin-form-layout project-form-layout">
    <form
        method="POST"
        action="<?php echo htmlspecialchars($action); ?>"
        class="admin-form-main"
        data-project-form
        data-project-empty-name="<?php echo htmlspecialchars($ft['preview_empty']); ?>"
        data-project-empty-customer="<?php echo htmlspecialchars($ft['customer_none']); ?>"
        data-project-empty-owner="<?php echo htmlspecialchars($ft['owner_none']); ?>"
        data-project-empty-dates="<?php echo htmlspecialchars($ft['dates_pending']); ?>"
        data-project-days-label="<?php echo htmlspecialchars($ft['days_label']); ?>"
        data-project-assist-ready="<?php echo htmlspecialchars($ft['assist_ready']); ?>"
        data-project-assist-watch="<?php echo htmlspecialchars($ft['assist_watch']); ?>"
        data-project-assist-risk="<?php echo htmlspecialchars($ft['assist_risk']); ?>"
        data-project-code-placeholder="<?php echo htmlspecialchars($ft['placeholder_code']); ?>"
    >
        <?php echo CSRF::field(); ?>
        <div class="card admin-data-card admin-form-card">
            <div class="card-body">
                <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo htmlspecialchars((string)$error); ?></div><?php endif; ?>
                <div class="admin-form-section admin-form-section--boxed mb-3">
                    <p class="admin-form-section__eyebrow"><?php echo htmlspecialchars($ft['step_identity']); ?></p>
                    <h3 class="admin-form-section__title"><?php echo htmlspecialchars($ft['identity_lead']); ?></h3>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-lg-8">
                        <label class="form-label"><?php echo htmlspecialchars($ft['name']); ?> <span class="admin-label-hint"><?php echo htmlspecialchars($ft['label_required']); ?></span></label>
                        <input class="form-control" name="name" value="<?php echo htmlspecialchars((string)($project['name'] ?? '')); ?>" placeholder="<?php echo htmlspecialchars($ft['placeholder_name']); ?>" required data-project-sync="name">
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label"><?php echo htmlspecialchars($ft['code']); ?> <span class="admin-label-hint"><?php echo htmlspecialchars($ft['label_required']); ?></span></label>
                        <div class="project-code-field">
                            <input class="form-control" name="code" value="<?php echo htmlspecialchars((string)($project['code'] ?? '')); ?>" placeholder="<?php echo htmlspecialchars($ft['placeholder_code']); ?>" required data-project-sync="code">
                            <button class="btn btn-outline-secondary" type="button" data-project-generate><?php echo htmlspecialchars($ft['generate_code']); ?></button>
                        </div>
                    </div>
                    <?php if (!Auth::isCustomer()): ?>
                        <div class="col-lg-4">
                            <label class="form-label"><?php echo htmlspecialchars($ft['customer']); ?></label>
                            <select class="form-select" name="customer_id" data-project-sync="customer">
                                <option value="">-</option>
                                <?php foreach ((array)$customers as $customer): ?>
                                    <option value="<?php echo (int)$customer['id']; ?>" <?php echo (int)($project['customer_id'] ?? 0) === (int)$customer['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars((string)$customer['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label"><?php echo htmlspecialchars($ft['owner']); ?></label>
                            <select class="form-select" name="owner_id" data-project-sync="owner">
                                <?php foreach ((array)$assignableUsers as $member): ?>
                                    <option value="<?php echo (int)$member['id']; ?>" <?php echo (int)($project['owner_id'] ?? (Auth::user()['id'] ?? 0)) === (int)$member['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars((string)$member['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="admin-form-section admin-form-section--boxed mb-3">
                    <p class="admin-form-section__eyebrow"><?php echo htmlspecialchars($ft['step_control']); ?></p>
                    <h3 class="admin-form-section__title"><?php echo htmlspecialchars($ft['control_lead']); ?></h3>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($ft['status']); ?></label>
                        <div class="project-pill-grid" data-project-pill-group>
                            <?php foreach (['planning','active','review','completed','blocked'] as $status): ?>
                                <button type="button" class="project-pill <?php echo ($project['status'] ?? 'planning') === $status ? 'is-active' : ''; ?>" data-project-pill-target="status" data-project-pill-value="<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($this->labelFor('status', $status)); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="status" value="<?php echo htmlspecialchars((string)($project['status'] ?? 'planning')); ?>" data-project-hidden="status">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($ft['priority']); ?></label>
                        <div class="project-pill-grid" data-project-pill-group>
                            <?php foreach (['low','medium','high'] as $priority): ?>
                                <button type="button" class="project-pill <?php echo ($project['priority'] ?? 'medium') === $priority ? 'is-active' : ''; ?>" data-project-pill-target="priority" data-project-pill-value="<?php echo htmlspecialchars($priority); ?>"><?php echo htmlspecialchars($this->labelFor('priority', $priority)); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="priority" value="<?php echo htmlspecialchars((string)($project['priority'] ?? 'medium')); ?>" data-project-hidden="priority">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($ft['health']); ?></label>
                        <div class="project-pill-grid" data-project-pill-group>
                            <?php foreach (['on_track','watch','at_risk'] as $health): ?>
                                <button type="button" class="project-pill <?php echo ($project['health'] ?? 'on_track') === $health ? 'is-active' : ''; ?>" data-project-pill-target="health" data-project-pill-value="<?php echo htmlspecialchars($health); ?>"><?php echo htmlspecialchars($this->labelFor('health', $health)); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="health" value="<?php echo htmlspecialchars((string)($project['health'] ?? 'on_track')); ?>" data-project-hidden="health">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo htmlspecialchars($ft['progress']); ?></label>
                        <div class="project-range-wrap">
                            <input class="form-range project-range" type="range" min="0" max="100" step="1" name="progress" value="<?php echo htmlspecialchars((string)($project['progress'] ?? 0)); ?>" data-project-sync="progress">
                            <div class="project-range-meta">
                                <strong data-project-progress-label><?php echo (int)($project['progress'] ?? 0); ?>%</strong>
                                <span><?php echo htmlspecialchars($ft['progress_hint']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo htmlspecialchars($ft['budget']); ?></label>
                        <input class="form-control" type="number" min="0" step="0.01" name="budget" value="<?php echo htmlspecialchars((string)($project['budget'] ?? '')); ?>" data-project-sync="budget">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo htmlspecialchars($ft['start_date']); ?></label>
                        <label class="date-input-shell">
                            <span class="date-input-shell__icon" aria-hidden="true"><i class="fas fa-calendar-day"></i></span>
                            <input class="form-control date-input-shell__control" type="date" name="start_date" value="<?php echo htmlspecialchars((string)($project['start_date'] ?? '')); ?>" data-project-sync="start_date">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo htmlspecialchars($ft['due_date']); ?></label>
                        <label class="date-input-shell">
                            <span class="date-input-shell__icon" aria-hidden="true"><i class="fas fa-calendar-check"></i></span>
                            <input class="form-control date-input-shell__control" type="date" name="due_date" value="<?php echo htmlspecialchars((string)($project['due_date'] ?? '')); ?>" data-project-sync="due_date">
                        </label>
                    </div>
                </div>

                <div class="admin-form-section admin-form-section--boxed mb-3">
                    <p class="admin-form-section__eyebrow"><?php echo htmlspecialchars($ft['step_notes']); ?></p>
                    <h3 class="admin-form-section__title"><?php echo htmlspecialchars($ft['notes_lead']); ?></h3>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($ft['tags']); ?></label>
                        <input class="form-control" name="tags" value="<?php echo htmlspecialchars((string)($project['tags'] ?? '')); ?>" placeholder="<?php echo htmlspecialchars($ft['placeholder_tags']); ?>" data-project-sync="tags">
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($ft['description']); ?></label>
                        <textarea class="form-control" rows="6" name="description" placeholder="<?php echo htmlspecialchars($ft['placeholder_description']); ?>" data-project-sync="description"><?php echo htmlspecialchars((string)($project['description'] ?? '')); ?></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit"><?php echo htmlspecialchars($isEdit ? $ft['update'] : $ft['save']); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <aside class="admin-form-side">
        <div class="card admin-data-card admin-form-aside-card project-preview-card" data-project-preview-root>
            <div class="card-body">
                <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($ft['preview_title']); ?></p>
                <div class="project-preview-hero">
                    <div>
                        <span class="project-preview-hero__eyebrow" data-project-preview="code"><?php echo htmlspecialchars((string)($project['code'] ?? $ft['placeholder_code'])); ?></span>
                        <h3 data-project-preview="name"><?php echo !empty($project['name']) ? htmlspecialchars((string)$project['name']) : htmlspecialchars($ft['preview_empty']); ?></h3>
                    </div>
                    <span class="project-health-pill project-health-pill--<?php echo htmlspecialchars((string)($project['health'] ?? 'on_track')); ?>" data-project-preview-health-pill><?php echo htmlspecialchars($this->labelFor('health', (string)($project['health'] ?? 'on_track'))); ?></span>
                </div>
                <div class="project-progress mt-3">
                    <div class="project-progress__bar"><span data-project-preview-progress-bar style="width: <?php echo max(0, min(100, (int)($project['progress'] ?? 0))); ?>%"></span></div>
                    <small><span data-project-preview-progress><?php echo (int)($project['progress'] ?? 0); ?>%</span> <?php echo htmlspecialchars($ft['completion_copy']); ?></small>
                </div>
                <div class="project-preview-stats mt-3">
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($ft['preview_customer']); ?></span><strong data-project-preview="customer"><?php echo !empty($project['customer_name']) ? htmlspecialchars((string)$project['customer_name']) : htmlspecialchars($ft['customer_none']); ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($ft['preview_owner']); ?></span><strong data-project-preview="owner"><?php echo !empty($project['owner_name']) ? htmlspecialchars((string)$project['owner_name']) : htmlspecialchars($ft['owner_none']); ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($ft['preview_dates']); ?></span><strong data-project-preview="dates"><?php echo htmlspecialchars($ft['dates_pending']); ?></strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($ft['preview_budget']); ?></span><strong data-project-preview="budget">-</strong></div>
                    <div class="admin-summary-item"><span><?php echo htmlspecialchars($ft['preview_health']); ?></span><strong data-project-preview="health"><?php echo htmlspecialchars($this->labelFor('health', (string)($project['health'] ?? 'on_track'))); ?></strong></div>
                </div>
            </div>
        </div>
        <div class="card admin-data-card admin-form-aside-card">
            <div class="card-body">
                <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($ft['summary_title']); ?></p>
                <p class="admin-form-aside-copy"><?php echo htmlspecialchars($ft['summary_text']); ?></p>
                <div class="project-setup-meter mt-3">
                    <div class="project-progress__bar"><span data-project-completion-bar style="width: <?php echo $completionPercent; ?>%"></span></div>
                    <small><strong data-project-completion-value><?php echo $completionPercent; ?>%</strong> <?php echo htmlspecialchars($ft['completion_copy']); ?></small>
                </div>
                <p class="admin-panel-eyebrow mt-4 mb-2"><?php echo htmlspecialchars($ft['assist_title']); ?></p>
                <div class="project-assist-card" data-project-assist>
                    <?php echo htmlspecialchars(($project['health'] ?? 'on_track') === 'at_risk' ? $ft['assist_risk'] : (($project['health'] ?? 'on_track') === 'watch' ? $ft['assist_watch'] : $ft['assist_ready'])); ?>
                </div>
                <p class="admin-panel-eyebrow mt-4 mb-2"><?php echo htmlspecialchars($ft['tips_title']); ?></p>
                <div class="admin-summary-stack">
                    <div class="admin-summary-item"><strong><?php echo htmlspecialchars($ft['tip_1']); ?></strong></div>
                    <div class="admin-summary-item"><strong><?php echo htmlspecialchars($ft['tip_2']); ?></strong></div>
                    <div class="admin-summary-item"><strong><?php echo htmlspecialchars($ft['tip_3']); ?></strong></div>
                </div>
            </div>
        </div>
    </aside>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
