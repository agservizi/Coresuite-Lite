<?php
use Core\Locale;

$pageTitle = Locale::current() === 'en' ? 'Sales Calendar' : (Locale::current() === 'fr' ? 'Agenda commercial' : (Locale::current() === 'es' ? 'Agenda comercial' : 'Calendario vendite'));
$calendarText = [
    'it' => ['eyebrow' => 'Commercial agenda', 'title' => 'Appuntamenti, follow-up e reminder in ordine temporale', 'lead' => 'Una vista unica su call, meeting e reminder automatici o manuali per non perdere nessuna azione commerciale.', 'dashboard' => 'Torna al CRM', 'pipeline' => 'Vai alla pipeline', 'empty' => 'Nessun elemento pianificato nel periodo corrente.', 'complete' => 'Completa reminder', 'reminder' => 'Reminder', 'activity' => 'Attivita'],
    'en' => ['eyebrow' => 'Commercial agenda', 'title' => 'Appointments, follow-ups, and reminders in time order', 'lead' => 'A single view of calls, meetings, and automatic or manual reminders so no sales action is missed.', 'dashboard' => 'Back to CRM', 'pipeline' => 'Go to pipeline', 'empty' => 'No items scheduled in the current period.', 'complete' => 'Complete reminder', 'reminder' => 'Reminder', 'activity' => 'Activity'],
    'fr' => ['eyebrow' => 'Agenda commercial', 'title' => 'Rendez-vous, suivis et rappels par ordre chronologique', 'lead' => 'Une vue unique sur appels, reunions et rappels automatiques ou manuels pour ne manquer aucune action commerciale.', 'dashboard' => 'Retour au CRM', 'pipeline' => 'Aller au pipeline', 'empty' => 'Aucun element planifie sur la periode courante.', 'complete' => 'Completer rappel', 'reminder' => 'Rappel', 'activity' => 'Activite'],
    'es' => ['eyebrow' => 'Agenda comercial', 'title' => 'Citas, seguimientos y recordatorios en orden temporal', 'lead' => 'Una vista unica de llamadas, reuniones y recordatorios automaticos o manuales para no perder ninguna accion comercial.', 'dashboard' => 'Volver al CRM', 'pipeline' => 'Ir al pipeline', 'empty' => 'No hay elementos programados en el periodo actual.', 'complete' => 'Completar recordatorio', 'reminder' => 'Recordatorio', 'activity' => 'Actividad'],
];
$ct = $calendarText[Locale::current()] ?? $calendarText['it'];
ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($ct['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($ct['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($ct['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/sales" class="btn btn-outline-secondary"><?php echo htmlspecialchars($ct['dashboard']); ?></a>
        <a href="/sales/pipeline" class="btn btn-primary"><?php echo htmlspecialchars($ct['pipeline']); ?></a>
    </div>
</section>

<?php if (!empty($agendaGroups)): ?>
    <div class="row g-3">
        <?php foreach ($agendaGroups as $day => $items): ?>
            <div class="col-12 col-xl-6">
                <div class="card admin-data-card h-100">
                    <div class="card-header border-0"><span><?php echo htmlspecialchars(Locale::formatDate($day)); ?></span></div>
                    <div class="card-body">
                        <div class="search-result-list">
                            <?php foreach ($items as $item): ?>
                                <div class="search-result-item">
                                    <div class="search-result-item__top">
                                        <strong><?php echo htmlspecialchars((string)$item['subject']); ?></strong>
                                        <span class="search-result-item__meta"><?php echo htmlspecialchars($item['item_type'] === 'reminder' ? $ct['reminder'] : $ct['activity']); ?></span>
                                    </div>
                                    <div class="search-result-item__sub">
                                        <span><?php echo htmlspecialchars(Locale::formatDateTime($item['event_at'] ?? '')); ?></span>
                                        <span><?php echo htmlspecialchars((string)($item['status'] ?? '-')); ?></span>
                                    </div>
                                    <?php if ($item['item_type'] === 'reminder' && (string)($item['status'] ?? '') !== 'done'): ?>
                                        <form method="POST" action="/sales/reminders/<?php echo (int)$item['id']; ?>/complete" class="mt-2">
                                            <?php echo CSRF::field(); ?>
                                            <button class="btn btn-sm btn-outline-primary" type="submit"><?php echo htmlspecialchars($ct['complete']); ?></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="dashboard-empty-state"><i class="fas fa-calendar-xmark"></i><p class="mb-0"><?php echo htmlspecialchars($ct['empty']); ?></p></div>
<?php endif; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
