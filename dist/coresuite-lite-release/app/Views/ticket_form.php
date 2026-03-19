<?php
use Core\Locale;

$ticketFormText = [
    'it' => [
        'page_title' => 'Nuovo Ticket',
        'eyebrow' => 'Nuova richiesta',
        'title' => 'Apri una richiesta ben contestualizzata',
        'lead' => 'Descrivi il problema con chiarezza, scegli la priorita giusta e allega materiali utili per velocizzare la presa in carico.',
        'back' => 'Torna ai ticket',
        'meta_setup' => '2 min setup',
        'meta_workflow' => 'Support workflow',
        'meta_context' => 'Context first',
        'step_1_title' => 'Contesto',
        'step_1_subtitle' => 'Categoria e priorita',
        'step_2_title' => 'Dettaglio',
        'step_2_subtitle' => 'Oggetto e descrizione',
        'step_3_title' => 'Supporto',
        'step_3_subtitle' => 'Allegati e invio',
        'card_eyebrow' => 'Modulo richiesta',
        'card_title' => 'Dati ticket',
        'status_new' => 'Nuova richiesta',
        'status_customer' => 'Cliente-facing',
        'section_1_title' => 'Definisci il contesto della richiesta',
        'section_1_lead' => 'Imposta il tipo di ticket e il livello di urgenza per orientare correttamente il team.',
        'category' => 'Categoria',
        'category_placeholder' => 'Seleziona categoria',
        'category_technical' => 'Tecnico',
        'category_admin' => 'Amministrativo',
        'category_sales' => 'Commerciale',
        'priority' => 'Priorita',
        'priority_low' => 'Bassa',
        'priority_medium' => 'Media',
        'priority_high' => 'Alta',
        'section_2_title' => 'Racconta il problema con precisione',
        'section_2_lead' => 'Un oggetto chiaro e una descrizione utile riducono i tempi di presa in carico.',
        'subject' => 'Oggetto',
        'subject_placeholder' => 'Breve descrizione del problema',
        'description' => 'Descrizione',
        'description_placeholder' => 'Spiega cosa sta succedendo, quando si verifica e che impatto ha.',
        'section_3_title' => 'Aggiungi materiali utili',
        'section_3_lead' => 'Allegati e prove visive aiutano il team a rispondere con piu velocita.',
        'attachment' => 'Allega file opzionale',
        'attachment_help' => 'Screenshot, PDF o documenti possono aiutare il team a prendere in carico il ticket piu rapidamente.',
        'submit' => 'Invia richiesta',
        'cancel' => 'Annulla',
        'summary_eyebrow' => 'Riepilogo richiesta',
        'summary_title' => 'Come verra letto il ticket',
        'routing' => 'Routing',
        'routing_value' => 'Smart',
        'sla' => 'SLA',
        'sla_value' => 'Basato sulla priorita',
        'summary_category' => 'Categoria',
        'summary_category_value' => 'Classifica il tipo di richiesta',
        'summary_priority' => 'Priorita',
        'summary_priority_value' => 'Orienta la velocita di presa in carico',
        'summary_description' => 'Descrizione',
        'summary_description_value' => 'Aiuta il team a intervenire senza chiedere contesto extra',
        'best_practice_eyebrow' => 'Best practice',
        'best_practice_title' => 'Prima di inviare',
        'tip_subject' => 'Usa un oggetto breve ma specifico.',
        'tip_context' => 'Descrivi il contesto e i passaggi per replicare il problema.',
        'tip_attachment' => 'Allega prove visive se il problema e tecnico.',
        'note_eyebrow' => 'Nota operativa',
        'note_title' => 'Cosa succede dopo l invio',
        'triage' => 'Triage',
        'triage_value' => 'Il ticket entra subito nella coda operativa con priorita e categoria.',
        'followup' => 'Follow-up',
        'followup_value' => 'Riceverai aggiornamenti e richieste di dettaglio nello stesso thread.',
    ],
    'en' => [
        'page_title' => 'New Ticket',
        'eyebrow' => 'New request',
        'title' => 'Open a well-contextualized request',
        'lead' => 'Describe the issue clearly, choose the right priority, and attach useful material to speed up handling.',
        'back' => 'Back to tickets',
        'meta_setup' => '2 min setup',
        'meta_workflow' => 'Support workflow',
        'meta_context' => 'Context first',
        'step_1_title' => 'Context',
        'step_1_subtitle' => 'Category and priority',
        'step_2_title' => 'Detail',
        'step_2_subtitle' => 'Subject and description',
        'step_3_title' => 'Support',
        'step_3_subtitle' => 'Attachments and submission',
        'card_eyebrow' => 'Request form',
        'card_title' => 'Ticket details',
        'status_new' => 'New request',
        'status_customer' => 'Customer-facing',
        'section_1_title' => 'Define the request context',
        'section_1_lead' => 'Set the ticket type and urgency level to route the team correctly.',
        'category' => 'Category',
        'category_placeholder' => 'Select category',
        'category_technical' => 'Technical',
        'category_admin' => 'Administrative',
        'category_sales' => 'Sales',
        'priority' => 'Priority',
        'priority_low' => 'Low',
        'priority_medium' => 'Medium',
        'priority_high' => 'High',
        'section_2_title' => 'Describe the issue precisely',
        'section_2_lead' => 'A clear subject and useful description reduce handling time.',
        'subject' => 'Subject',
        'subject_placeholder' => 'Short description of the issue',
        'description' => 'Description',
        'description_placeholder' => 'Explain what is happening, when it occurs, and the impact.',
        'section_3_title' => 'Add useful materials',
        'section_3_lead' => 'Attachments and visual proof help the team respond faster.',
        'attachment' => 'Attach optional file',
        'attachment_help' => 'Screenshots, PDFs, or documents can help the team take over the ticket faster.',
        'submit' => 'Submit request',
        'cancel' => 'Cancel',
        'summary_eyebrow' => 'Request summary',
        'summary_title' => 'How the ticket will be read',
        'routing' => 'Routing',
        'routing_value' => 'Smart',
        'sla' => 'SLA',
        'sla_value' => 'Priority based',
        'summary_category' => 'Category',
        'summary_category_value' => 'Classifies the type of request',
        'summary_priority' => 'Priority',
        'summary_priority_value' => 'Guides the handling speed',
        'summary_description' => 'Description',
        'summary_description_value' => 'Helps the team act without asking for extra context',
        'best_practice_eyebrow' => 'Best practice',
        'best_practice_title' => 'Before sending',
        'tip_subject' => 'Use a short but specific subject.',
        'tip_context' => 'Describe the context and steps to reproduce the issue.',
        'tip_attachment' => 'Attach visual proof if the issue is technical.',
        'note_eyebrow' => 'Operational note',
        'note_title' => 'What happens after submission',
        'triage' => 'Triage',
        'triage_value' => 'The ticket immediately enters the operational queue with priority and category.',
        'followup' => 'Follow-up',
        'followup_value' => 'You will receive updates and clarification requests in the same thread.',
    ],
    'fr' => [
        'page_title' => 'Nouveau ticket',
        'eyebrow' => 'Nouvelle demande',
        'title' => 'Ouvrir une demande bien contextualisee',
        'lead' => 'Decrivez clairement le probleme, choisissez la bonne priorite et joignez des elements utiles pour accelerer la prise en charge.',
        'back' => 'Retour aux tickets',
        'meta_setup' => 'Configuration 2 min',
        'meta_workflow' => 'Flux support',
        'meta_context' => 'Contexte d abord',
        'step_1_title' => 'Contexte',
        'step_1_subtitle' => 'Categorie et priorite',
        'step_2_title' => 'Detail',
        'step_2_subtitle' => 'Sujet et description',
        'step_3_title' => 'Support',
        'step_3_subtitle' => 'Pieces jointes et envoi',
        'card_eyebrow' => 'Formulaire',
        'card_title' => 'Details du ticket',
        'status_new' => 'Nouvelle demande',
        'status_customer' => 'Visible client',
        'section_1_title' => 'Definir le contexte de la demande',
        'section_1_lead' => 'Definissez le type de ticket et le niveau d urgence pour orienter correctement l equipe.',
        'category' => 'Categorie',
        'category_placeholder' => 'Selectionnez une categorie',
        'category_technical' => 'Technique',
        'category_admin' => 'Administratif',
        'category_sales' => 'Commercial',
        'priority' => 'Priorite',
        'priority_low' => 'Basse',
        'priority_medium' => 'Moyenne',
        'priority_high' => 'Haute',
        'section_2_title' => 'Decrivez le probleme avec precision',
        'section_2_lead' => 'Un sujet clair et une description utile reduisent les delais de prise en charge.',
        'subject' => 'Sujet',
        'subject_placeholder' => 'Courte description du probleme',
        'description' => 'Description',
        'description_placeholder' => 'Expliquez ce qui se passe, quand cela se produit et quel est l impact.',
        'section_3_title' => 'Ajouter des elements utiles',
        'section_3_lead' => 'Les pieces jointes et preuves visuelles aident l equipe a repondre plus vite.',
        'attachment' => 'Joindre un fichier optionnel',
        'attachment_help' => 'Captures d ecran, PDF ou documents peuvent aider l equipe a prendre le ticket en charge plus rapidement.',
        'submit' => 'Envoyer la demande',
        'cancel' => 'Annuler',
        'summary_eyebrow' => 'Resume de la demande',
        'summary_title' => 'Comment le ticket sera lu',
        'routing' => 'Routage',
        'routing_value' => 'Intelligent',
        'sla' => 'SLA',
        'sla_value' => 'Base sur la priorite',
        'summary_category' => 'Categorie',
        'summary_category_value' => 'Classe le type de demande',
        'summary_priority' => 'Priorite',
        'summary_priority_value' => 'Oriente la vitesse de prise en charge',
        'summary_description' => 'Description',
        'summary_description_value' => 'Aide l equipe a intervenir sans demander de contexte supplementaire',
        'best_practice_eyebrow' => 'Bonnes pratiques',
        'best_practice_title' => 'Avant l envoi',
        'tip_subject' => 'Utilisez un sujet court mais precis.',
        'tip_context' => 'Decrivez le contexte et les etapes pour reproduire le probleme.',
        'tip_attachment' => 'Ajoutez des preuves visuelles si le probleme est technique.',
        'note_eyebrow' => 'Note operationnelle',
        'note_title' => 'Que se passe-t-il apres l envoi',
        'triage' => 'Triage',
        'triage_value' => 'Le ticket entre immediatement dans la file operationnelle avec priorite et categorie.',
        'followup' => 'Suivi',
        'followup_value' => 'Vous recevrez les mises a jour et demandes de precision dans le meme fil.',
    ],
    'es' => [
        'page_title' => 'Nuevo ticket',
        'eyebrow' => 'Nueva solicitud',
        'title' => 'Abrir una solicitud bien contextualizada',
        'lead' => 'Describe el problema con claridad, elige la prioridad correcta y adjunta material util para acelerar la gestion.',
        'back' => 'Volver a tickets',
        'meta_setup' => 'Configuracion 2 min',
        'meta_workflow' => 'Flujo de soporte',
        'meta_context' => 'Contexto primero',
        'step_1_title' => 'Contexto',
        'step_1_subtitle' => 'Categoria y prioridad',
        'step_2_title' => 'Detalle',
        'step_2_subtitle' => 'Asunto y descripcion',
        'step_3_title' => 'Soporte',
        'step_3_subtitle' => 'Adjuntos y envio',
        'card_eyebrow' => 'Formulario',
        'card_title' => 'Datos del ticket',
        'status_new' => 'Nueva solicitud',
        'status_customer' => 'Visible al cliente',
        'section_1_title' => 'Definir el contexto de la solicitud',
        'section_1_lead' => 'Configura el tipo de ticket y el nivel de urgencia para orientar correctamente al equipo.',
        'category' => 'Categoria',
        'category_placeholder' => 'Selecciona categoria',
        'category_technical' => 'Tecnico',
        'category_admin' => 'Administrativo',
        'category_sales' => 'Comercial',
        'priority' => 'Prioridad',
        'priority_low' => 'Baja',
        'priority_medium' => 'Media',
        'priority_high' => 'Alta',
        'section_2_title' => 'Describe el problema con precision',
        'section_2_lead' => 'Un asunto claro y una descripcion util reducen los tiempos de gestion.',
        'subject' => 'Asunto',
        'subject_placeholder' => 'Breve descripcion del problema',
        'description' => 'Descripcion',
        'description_placeholder' => 'Explica que esta pasando, cuando ocurre y cual es el impacto.',
        'section_3_title' => 'Agregar materiales utiles',
        'section_3_lead' => 'Los adjuntos y pruebas visuales ayudan al equipo a responder mas rapido.',
        'attachment' => 'Adjuntar archivo opcional',
        'attachment_help' => 'Capturas, PDF o documentos pueden ayudar al equipo a gestionar el ticket mas rapidamente.',
        'submit' => 'Enviar solicitud',
        'cancel' => 'Cancelar',
        'summary_eyebrow' => 'Resumen de solicitud',
        'summary_title' => 'Como se leera el ticket',
        'routing' => 'Enrutamiento',
        'routing_value' => 'Inteligente',
        'sla' => 'SLA',
        'sla_value' => 'Basado en prioridad',
        'summary_category' => 'Categoria',
        'summary_category_value' => 'Clasifica el tipo de solicitud',
        'summary_priority' => 'Prioridad',
        'summary_priority_value' => 'Orienta la velocidad de gestion',
        'summary_description' => 'Descripcion',
        'summary_description_value' => 'Ayuda al equipo a actuar sin pedir contexto extra',
        'best_practice_eyebrow' => 'Buenas practicas',
        'best_practice_title' => 'Antes de enviar',
        'tip_subject' => 'Usa un asunto breve pero especifico.',
        'tip_context' => 'Describe el contexto y los pasos para reproducir el problema.',
        'tip_attachment' => 'Adjunta pruebas visuales si el problema es tecnico.',
        'note_eyebrow' => 'Nota operativa',
        'note_title' => 'Que sucede despues del envio',
        'triage' => 'Triage',
        'triage_value' => 'El ticket entra de inmediato en la cola operativa con prioridad y categoria.',
        'followup' => 'Seguimiento',
        'followup_value' => 'Recibiras actualizaciones y solicitudes de detalle en el mismo hilo.',
    ],
];

$tf = $ticketFormText[Locale::current()] ?? $ticketFormText['it'];
$pageTitle = $tf['page_title'];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($tf['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($tf['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($tf['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/tickets" class="btn btn-outline-secondary"><?php echo htmlspecialchars($tf['back']); ?></a>
    </div>
</section>

<div class="admin-form-shell">
    <div class="admin-form-meta mb-3">
        <span class="admin-form-meta__pill"><i class="fas fa-stopwatch"></i><?php echo htmlspecialchars($tf['meta_setup']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-layer-group"></i><?php echo htmlspecialchars($tf['meta_workflow']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-shield-check"></i><?php echo htmlspecialchars($tf['meta_context']); ?></span>
    </div>

    <div class="admin-form-stepper mb-4">
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">1</span>
            <div>
                <strong><?php echo htmlspecialchars($tf['step_1_title']); ?></strong>
                <small><?php echo htmlspecialchars($tf['step_1_subtitle']); ?></small>
            </div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">2</span>
            <div>
                <strong><?php echo htmlspecialchars($tf['step_2_title']); ?></strong>
                <small><?php echo htmlspecialchars($tf['step_2_subtitle']); ?></small>
            </div>
        </div>
        <div class="admin-form-step">
            <span class="admin-form-step__index">3</span>
            <div>
                <strong><?php echo htmlspecialchars($tf['step_3_title']); ?></strong>
                <small><?php echo htmlspecialchars($tf['step_3_subtitle']); ?></small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
        <div class="card admin-form-card">
                <div class="card-header border-0">
                    <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($tf['card_eyebrow']); ?></p>
                    <span><?php echo htmlspecialchars($tf['card_title']); ?></span>
                </div>
                <div class="admin-form-card__status">
                    <span class="admin-form-card__status-pill"><?php echo htmlspecialchars($tf['status_new']); ?></span>
                    <span class="admin-form-card__status-pill is-soft"><?php echo htmlspecialchars($tf['status_customer']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/tickets" enctype="multipart/form-data" class="row g-3">
                    <?php echo CSRF::field(); ?>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 1</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($tf['section_1_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($tf['section_1_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($tf['category']); ?></label>
                        <select name="category" required class="form-select">
                            <option value=""><?php echo htmlspecialchars($tf['category_placeholder']); ?></option>
                            <option value="tecnico"><?php echo htmlspecialchars($tf['category_technical']); ?></option>
                            <option value="amministrativo"><?php echo htmlspecialchars($tf['category_admin']); ?></option>
                            <option value="commerciale"><?php echo htmlspecialchars($tf['category_sales']); ?></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($tf['priority']); ?></label>
                        <select name="priority" class="form-select">
                            <option value="low"><?php echo htmlspecialchars($tf['priority_low']); ?></option>
                            <option value="medium" selected><?php echo htmlspecialchars($tf['priority_medium']); ?></option>
                            <option value="high"><?php echo htmlspecialchars($tf['priority_high']); ?></option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 2</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($tf['section_2_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($tf['section_2_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($tf['subject']); ?></label>
                        <input class="form-control" type="text" name="subject" placeholder="<?php echo htmlspecialchars($tf['subject_placeholder']); ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($tf['description']); ?></label>
                        <textarea class="form-control" name="body" rows="7" required placeholder="<?php echo htmlspecialchars($tf['description_placeholder']); ?>"></textarea>
                    </div>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 3</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($tf['section_3_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($tf['section_3_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($tf['attachment']); ?></label>
                        <input class="form-control" type="file" name="attachment">
                        <div class="form-text"><?php echo htmlspecialchars($tf['attachment_help']); ?></div>
                    </div>
                    <div class="col-12 d-flex gap-2 flex-wrap">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane me-1"></i><?php echo htmlspecialchars($tf['submit']); ?></button>
                        <a href="/tickets" class="btn btn-outline-secondary"><?php echo htmlspecialchars($tf['cancel']); ?></a>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="col-xl-4">
            <div class="admin-form-sidebar">
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($tf['summary_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($tf['summary_title']); ?></h3>
                        <div class="admin-form-kpis mb-3">
                            <div class="admin-form-kpi">
                                <span><?php echo htmlspecialchars($tf['routing']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['routing_value']); ?></strong>
                            </div>
                            <div class="admin-form-kpi">
                                <span><?php echo htmlspecialchars($tf['sla']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['sla_value']); ?></strong>
                            </div>
                        </div>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($tf['summary_category']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['summary_category_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($tf['summary_priority']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['summary_priority_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($tf['summary_description']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['summary_description_value']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($tf['best_practice_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($tf['best_practice_title']); ?></h3>
                        <ul class="dashboard-insights mt-0">
                            <li><i class="fas fa-check-circle"></i><?php echo htmlspecialchars($tf['tip_subject']); ?></li>
                            <li><i class="fas fa-list"></i><?php echo htmlspecialchars($tf['tip_context']); ?></li>
                            <li><i class="fas fa-paperclip"></i><?php echo htmlspecialchars($tf['tip_attachment']); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($tf['note_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($tf['note_title']); ?></h3>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($tf['triage']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['triage_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($tf['followup']); ?></span>
                                <strong><?php echo htmlspecialchars($tf['followup_value']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
