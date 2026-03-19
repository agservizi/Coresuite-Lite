<?php
use Core\Locale;
use Core\RolePermissions;

$boardText = [
    'it' => ['page_title' => 'Projects Board', 'eyebrow' => 'Portfolio board', 'title' => 'Vista kanban dei progetti per stato e salute delivery', 'lead' => 'Una board rapida per leggere il carico di progetto in termini di avanzamento, rischio e contesto cliente.', 'back' => 'Torna ai progetti', 'new' => 'Nuovo progetto', 'progress' => 'Progress', 'open' => 'Apri workspace', 'edit' => 'Modifica'],
    'en' => ['page_title' => 'Projects Board', 'eyebrow' => 'Portfolio board', 'title' => 'Kanban view of projects by status and delivery health', 'lead' => 'A fast board to read project load in terms of progress, risk, and customer context.', 'back' => 'Back to projects', 'new' => 'New project', 'progress' => 'Progress', 'open' => 'Open workspace', 'edit' => 'Edit'],
    'fr' => ['page_title' => 'Projects Board', 'eyebrow' => 'Portfolio board', 'title' => 'Vue kanban des projets par statut et sante delivery', 'lead' => 'Une board rapide pour lire la charge projet en termes d avancement, risque et contexte client.', 'back' => 'Retour aux projets', 'new' => 'Nouveau projet', 'progress' => 'Progression', 'open' => 'Ouvrir workspace', 'edit' => 'Modifier'],
    'es' => ['page_title' => 'Projects Board', 'eyebrow' => 'Portfolio board', 'title' => 'Vista kanban de proyectos por estado y salud delivery', 'lead' => 'Un board rapido para leer la carga de proyectos en avance, riesgo y contexto cliente.', 'back' => 'Volver a proyectos', 'new' => 'Nuevo proyecto', 'progress' => 'Progreso', 'open' => 'Abrir workspace', 'edit' => 'Editar'],
];
$bt = $boardText[Locale::current()] ?? $boardText['it'];
$pageTitle = $bt['page_title'];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($bt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($bt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($bt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/projects" class="btn btn-outline-secondary"><?php echo htmlspecialchars($bt['back']); ?></a>
        <?php if (RolePermissions::canCurrent('projects_manage')): ?>
            <a href="/projects/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i><?php echo htmlspecialchars($bt['new']); ?></a>
        <?php endif; ?>
    </div>
</section>

<div class="projects-board">
    <?php foreach (['planning','active','review','completed','blocked'] as $status): ?>
        <?php $items = (array)($boardProjects[$status] ?? []); ?>
        <section class="projects-board__lane">
            <div class="projects-board__head">
                <strong><?php echo htmlspecialchars($this->labelFor('status', $status)); ?></strong>
                <span><?php echo count($items); ?></span>
            </div>
            <div class="projects-board__stack">
                <?php foreach ($items as $project): ?>
                    <a href="/projects/<?php echo (int)$project['id']; ?>" class="projects-board-card dashboard-hoverlift">
                        <div class="projects-board-card__top">
                            <span class="projects-board-card__code"><?php echo htmlspecialchars((string)$project['code']); ?></span>
                            <span class="project-health-pill project-health-pill--<?php echo htmlspecialchars((string)$project['health']); ?>"><?php echo htmlspecialchars((string)$project['health_label']); ?></span>
                        </div>
                        <strong><?php echo htmlspecialchars((string)$project['name']); ?></strong>
                        <?php if (!empty($project['customer_name'])): ?><small><?php echo htmlspecialchars((string)$project['customer_name']); ?></small><?php endif; ?>
                        <div class="project-progress mt-2">
                            <div class="project-progress__bar"><span style="width: <?php echo max(0, min(100, (int)$project['progress'])); ?>%"></span></div>
                            <small><?php echo htmlspecialchars($bt['progress']); ?> <?php echo (int)$project['progress']; ?>%</small>
                        </div>
                        <div class="project-board-actions">
                            <span><?php echo htmlspecialchars($bt['open']); ?></span>
                            <?php if (RolePermissions::canCurrent('projects_manage')): ?><span><?php echo htmlspecialchars($bt['edit']); ?></span><?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
