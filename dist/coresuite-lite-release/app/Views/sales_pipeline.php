<?php
use Core\Locale;

$pageTitle = Locale::current() === 'en' ? 'Sales Pipeline' : (Locale::current() === 'fr' ? 'Pipeline commercial' : (Locale::current() === 'es' ? 'Pipeline comercial' : 'Pipeline vendite'));
$pipelineText = [
    'it' => ['eyebrow' => 'Deal board', 'title' => 'Pipeline vendite per stage reale', 'lead' => 'Ogni colonna rappresenta una fase commerciale reale: lead in, qualificazione, proposta, negoziazione, commit e chiusura.', 'dashboard' => 'Torna al CRM', 'calendar' => 'Apri agenda', 'empty' => 'Nessun deal in questa colonna.', 'amount' => 'Valore', 'probability' => 'Prob.', 'close' => 'Close', 'owner' => 'Owner', 'move' => 'Aggiorna stage'],
    'en' => ['eyebrow' => 'Deal board', 'title' => 'Sales pipeline by real stage', 'lead' => 'Each column represents a real sales phase: lead in, qualification, proposal, negotiation, commit, and close.', 'dashboard' => 'Back to CRM', 'calendar' => 'Open agenda', 'empty' => 'No deals in this column.', 'amount' => 'Value', 'probability' => 'Prob.', 'close' => 'Close', 'owner' => 'Owner', 'move' => 'Update stage'],
    'fr' => ['eyebrow' => 'Board deals', 'title' => 'Pipeline commercial par etape reelle', 'lead' => 'Chaque colonne represente une vraie phase commerciale: lead in, qualification, proposition, negociation, commit et cloture.', 'dashboard' => 'Retour au CRM', 'calendar' => 'Ouvrir agenda', 'empty' => 'Aucun deal dans cette colonne.', 'amount' => 'Valeur', 'probability' => 'Prob.', 'close' => 'Cloture', 'owner' => 'Responsable', 'move' => 'Mettre a jour etape'],
    'es' => ['eyebrow' => 'Board de deals', 'title' => 'Pipeline comercial por etapa real', 'lead' => 'Cada columna representa una fase comercial real: lead in, cualificacion, propuesta, negociacion, commit y cierre.', 'dashboard' => 'Volver al CRM', 'calendar' => 'Abrir agenda', 'empty' => 'No hay deals en esta columna.', 'amount' => 'Valor', 'probability' => 'Prob.', 'close' => 'Cierre', 'owner' => 'Responsable', 'move' => 'Actualizar etapa'],
];
$pt = $pipelineText[Locale::current()] ?? $pipelineText['it'];
$renderLabel = static function ($group, $key) {
    static $controller = null;
    if ($controller === null) {
        $controller = new SalesController();
    }
    return $controller->translateLabel($group, $key);
};
$formatMoney = static function ($value, $currency = 'EUR') {
    return number_format((float)$value, 2, ',', '.') . ' ' . htmlspecialchars((string)$currency);
};
ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($pt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($pt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($pt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/sales" class="btn btn-outline-secondary"><?php echo htmlspecialchars($pt['dashboard']); ?></a>
        <a href="/sales/calendar" class="btn btn-primary"><?php echo htmlspecialchars($pt['calendar']); ?></a>
    </div>
</section>

<div class="dashboard-kanban">
    <?php foreach ($dealStages as $stage): ?>
        <?php $items = (array)($pipelineGroups[$stage] ?? []); ?>
        <section class="dashboard-kanban-column">
            <header class="dashboard-kanban-column__head">
                <strong><?php echo htmlspecialchars($renderLabel('deal_stage', $stage)); ?></strong>
                <strong><?php echo count($items); ?></strong>
            </header>
            <div class="dashboard-kanban-column__body">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $deal): ?>
                        <article class="dashboard-kanban-card">
                            <strong><?php echo htmlspecialchars((string)$deal['title']); ?></strong>
                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars((string)($deal['company_name'] ?? '-')); ?></span>
                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars($pt['amount']); ?>: <?php echo $formatMoney($deal['amount'] ?? 0, $deal['currency'] ?? 'EUR'); ?></span>
                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars($pt['probability']); ?> <?php echo (int)($deal['probability'] ?? 0); ?>%</span>
                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars($pt['close']); ?>: <?php echo htmlspecialchars(Locale::formatDate($deal['expected_close_date'] ?? '')); ?></span>
                            <small><?php echo htmlspecialchars($pt['owner']); ?>: <?php echo htmlspecialchars((string)($deal['owner_name'] ?? '-')); ?></small>
                            <form method="POST" action="/sales/deals/<?php echo (int)$deal['id']; ?>/stage" class="mt-2">
                                <?php echo CSRF::field(); ?>
                                <div class="d-flex gap-2">
                                    <select class="form-select form-select-sm" name="stage">
                                        <?php foreach ($dealStages as $option): ?>
                                            <option value="<?php echo htmlspecialchars($option); ?>" <?php echo $option === (string)$deal['stage'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($renderLabel('deal_stage', $option)); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn btn-sm btn-primary" type="submit"><?php echo htmlspecialchars($pt['move']); ?></button>
                                </div>
                            </form>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="dashboard-kanban-empty"><?php echo htmlspecialchars($pt['empty']); ?></div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
