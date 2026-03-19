<?php
namespace Core;

class Locale {
    private const DEFAULT_LOCALE = 'it';
    private const SESSION_KEY = 'locale';
    private const SESSION_SOURCE_KEY = 'locale_source';

    private static ?string $current = null;

    public static function boot(): void {
        if (self::$current !== null) {
            return;
        }

        $selected = $_SESSION[self::SESSION_KEY] ?? null;
        if (self::isSupported($selected)) {
            self::set((string)$selected, false);
            return;
        }

        $detection = self::detectPreferredLocale();
        $selected = (string)($detection['locale'] ?? self::DEFAULT_LOCALE);
        self::set($selected ?: self::DEFAULT_LOCALE, false);

        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[self::SESSION_KEY] = self::$current;
            $_SESSION[self::SESSION_SOURCE_KEY] = (string)($detection['source'] ?? 'default');
        }
    }

    public static function current(): string {
        self::boot();
        return self::$current ?? self::DEFAULT_LOCALE;
    }

    public static function set(?string $locale, bool $persist = true): string {
        $locale = is_string($locale) ? strtolower(trim($locale)) : self::DEFAULT_LOCALE;
        if (!self::isSupported($locale)) {
            $locale = self::DEFAULT_LOCALE;
        }

        self::$current = $locale;
        if ($persist && session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[self::SESSION_KEY] = $locale;
            $_SESSION[self::SESSION_SOURCE_KEY] = 'manual';
        }

        return $locale;
    }

    public static function source(): string {
        self::boot();
        return (string)($_SESSION[self::SESSION_SOURCE_KEY] ?? 'manual');
    }

    public static function supported(): array {
        return [
            'it' => 'Italiano',
            'en' => 'English',
            'fr' => 'Francais',
            'es' => 'Espanol',
        ];
    }

    public static function currentLabel(): string {
        $supported = self::supported();
        return $supported[self::current()] ?? 'Italiano';
    }

    public static function dateFormat(): string {
        return self::current() === 'en' ? 'Y-m-d' : 'd-m-Y';
    }

    public static function dateTimeFormat(): string {
        return self::dateFormat() . ' H:i';
    }

    public static function formatDate($value, string $fallback = ''): string {
        $rawValue = trim((string)$value);
        if ($rawValue === '') {
            return $fallback;
        }

        try {
            return (new \DateTime($rawValue))->format(self::dateFormat());
        } catch (\Throwable $e) {
            return $rawValue;
        }
    }

    public static function formatDateTime($value, string $fallback = ''): string {
        $rawValue = trim((string)$value);
        if ($rawValue === '') {
            return $fallback;
        }

        try {
            return (new \DateTime($rawValue))->format(self::dateTimeFormat());
        } catch (\Throwable $e) {
            return $rawValue;
        }
    }

    public static function switchUrl(string $locale, ?string $redirect = null): string {
        $target = '/locale/' . rawurlencode($locale);
        $redirect = $redirect ?: (string)($_SERVER['REQUEST_URI'] ?? '/dashboard');

        return $target . '?redirect=' . rawurlencode($redirect);
    }

    public static function clientStrings(): array {
        $locale = self::current();

        $strings = [
            'it' => [
                'spotlight_footer_open' => 'Apri risultati completi',
                'spotlight_recent_empty' => 'Nessuna ricerca recente salvata.',
                'spotlight_recent_open' => 'Apri ricerca completa',
                'spotlight_no_results' => 'Nessun risultato rapido. Premi invio per aprire la ricerca completa.',
                'spotlight_results_count' => '%d risultati rapidi nel workspace',
                'spotlight_group_workspace' => 'Workspace',
                'spotlight_result' => 'Risultato',
                'spotlight_type_min_chars' => 'Digita almeno 2 caratteri per cercare nel workspace.',
                'spotlight_loading' => 'Ricerca in corso...',
                'spotlight_request_failed' => 'Non sono riuscito a recuperare i risultati rapidi.',
                'spotlight_pinned_label' => 'Pinned',
                'date_picker_today' => 'Oggi',
                'date_picker_clear' => 'Pulisci',
                'date_picker_prev_month' => 'Mese precedente',
                'date_picker_next_month' => 'Mese successivo',
                'date_picker_month' => 'Mese',
                'date_picker_year' => 'Anno',
                'notification_close' => 'Chiudi notifica',
                'notification_source' => 'CoreSuite Lite',
                'notification_open_item' => 'Apri dettaglio',
                'notification_open_ticket' => 'Apri ticket',
                'notification_open_documents' => 'Vai ai documenti',
                'notification_open_dashboard' => 'Vai alla dashboard',
                'notification_open_admin' => 'Apri admin',
                'notification_live_topbar' => 'Centro notifiche',
                'notification_live_dashboard' => 'Quick signals',
                'back_to_top' => 'Torna su',
            ],
            'en' => [
                'spotlight_footer_open' => 'Open full results',
                'spotlight_recent_empty' => 'No recent searches saved.',
                'spotlight_recent_open' => 'Open full search',
                'spotlight_no_results' => 'No quick results. Press enter to open the full search.',
                'spotlight_results_count' => '%d quick results in the workspace',
                'spotlight_group_workspace' => 'Workspace',
                'spotlight_result' => 'Result',
                'spotlight_type_min_chars' => 'Type at least 2 characters to search the workspace.',
                'spotlight_loading' => 'Searching...',
                'spotlight_request_failed' => 'I could not load the quick results.',
                'spotlight_pinned_label' => 'Pinned',
                'date_picker_today' => 'Today',
                'date_picker_clear' => 'Clear',
                'date_picker_prev_month' => 'Previous month',
                'date_picker_next_month' => 'Next month',
                'date_picker_month' => 'Month',
                'date_picker_year' => 'Year',
                'notification_close' => 'Close notification',
                'notification_source' => 'CoreSuite Lite',
                'notification_open_item' => 'Open detail',
                'notification_open_ticket' => 'Open ticket',
                'notification_open_documents' => 'Go to documents',
                'notification_open_dashboard' => 'Go to dashboard',
                'notification_open_admin' => 'Open admin',
                'notification_live_topbar' => 'Notification inbox',
                'notification_live_dashboard' => 'Quick signals',
                'back_to_top' => 'Back to top',
            ],
            'fr' => [
                'spotlight_footer_open' => 'Ouvrir les resultats complets',
                'spotlight_recent_empty' => 'Aucune recherche recente enregistree.',
                'spotlight_recent_open' => 'Ouvrir la recherche complete',
                'spotlight_no_results' => 'Aucun resultat rapide. Appuyez sur entree pour ouvrir la recherche complete.',
                'spotlight_results_count' => '%d resultats rapides dans le workspace',
                'spotlight_group_workspace' => 'Workspace',
                'spotlight_result' => 'Resultat',
                'spotlight_type_min_chars' => 'Saisissez au moins 2 caracteres pour rechercher dans le workspace.',
                'spotlight_loading' => 'Recherche en cours...',
                'spotlight_request_failed' => 'Impossible de recuperer les resultats rapides.',
                'spotlight_pinned_label' => 'Epingle',
                'date_picker_today' => 'Aujourd hui',
                'date_picker_clear' => 'Effacer',
                'date_picker_prev_month' => 'Mois precedent',
                'date_picker_next_month' => 'Mois suivant',
                'date_picker_month' => 'Mois',
                'date_picker_year' => 'Annee',
                'notification_close' => 'Fermer la notification',
                'notification_source' => 'CoreSuite Lite',
                'notification_open_item' => 'Ouvrir le detail',
                'notification_open_ticket' => 'Ouvrir le ticket',
                'notification_open_documents' => 'Aller aux documents',
                'notification_open_dashboard' => 'Aller au dashboard',
                'notification_open_admin' => 'Ouvrir admin',
                'notification_live_topbar' => 'Inbox notifications',
                'notification_live_dashboard' => 'Signaux rapides',
                'back_to_top' => 'Retour en haut',
            ],
            'es' => [
                'spotlight_footer_open' => 'Abrir resultados completos',
                'spotlight_recent_empty' => 'No hay busquedas recientes guardadas.',
                'spotlight_recent_open' => 'Abrir busqueda completa',
                'spotlight_no_results' => 'No hay resultados rapidos. Pulsa intro para abrir la busqueda completa.',
                'spotlight_results_count' => '%d resultados rapidos en el workspace',
                'spotlight_group_workspace' => 'Workspace',
                'spotlight_result' => 'Resultado',
                'spotlight_type_min_chars' => 'Escribe al menos 2 caracteres para buscar en el workspace.',
                'spotlight_loading' => 'Buscando...',
                'spotlight_request_failed' => 'No pude recuperar los resultados rapidos.',
                'spotlight_pinned_label' => 'Fijado',
                'date_picker_today' => 'Hoy',
                'date_picker_clear' => 'Limpiar',
                'date_picker_prev_month' => 'Mes anterior',
                'date_picker_next_month' => 'Mes siguiente',
                'date_picker_month' => 'Mes',
                'date_picker_year' => 'Ano',
                'notification_close' => 'Cerrar notificacion',
                'notification_source' => 'CoreSuite Lite',
                'notification_open_item' => 'Abrir detalle',
                'notification_open_ticket' => 'Abrir ticket',
                'notification_open_documents' => 'Ir a documentos',
                'notification_open_dashboard' => 'Ir al dashboard',
                'notification_open_admin' => 'Abrir admin',
                'notification_live_topbar' => 'Inbox notificaciones',
                'notification_live_dashboard' => 'Senales rapidas',
                'back_to_top' => 'Volver arriba',
            ],
        ];

        return $strings[$locale] ?? $strings[self::DEFAULT_LOCALE];
    }

    public static function runtime(string $key, array $replace = []): string {
        $locale = self::current();
        $messages = [
            'it' => [
                'csrf_invalid' => 'Token di sicurezza non valido.',
                'csrf_invalid_plain' => 'Token CSRF non valido',
                'db_unavailable_verify_env' => 'Database non disponibile. Verifica credenziali DB in .env e che il database esista.',
                'db_unavailable_configure_env' => 'Database non disponibile. Configura il file .env per lo sviluppo.',
                'invalid_credentials' => 'Credenziali non valide.',
                'admin_email_invalid' => 'Inserisci una email amministratore valida.',
                'reset_email_sent' => 'Se l\'email e registrata, riceverai un link per il reset della password.',
                'reset_link_invalid' => 'Il link di reset e scaduto o non valido. Richiedi un nuovo link.',
                'passwords_mismatch' => 'Le password non corrispondono.',
                'password_min_8' => 'La password deve essere di almeno 8 caratteri.',
                'password_updated' => 'Password aggiornata con successo. Puoi ora accedere con la nuova password.',
                'ticket_created' => 'Ticket creato con successo.',
                'status_invalid' => 'Stato non valido.',
                'ticket_assigned' => 'Ticket assegnato con successo.',
                'document_upload_required' => 'Cliente e file sono obbligatori.',
                'document_type_invalid' => 'Tipo file non supportato o troppo grande (max 10MB). Formati: PDF, JPG, PNG, DOC, DOCX.',
                'document_uploaded' => 'Documento caricato con successo.',
                'document_upload_error' => 'Errore nel caricamento del file.',
                'document_deleted' => 'Documento eliminato.',
                'profile_updated' => 'Profilo aggiornato con successo.',
                'email_in_use' => 'Email gia in uso da un altro utente.',
                'current_password_incorrect' => 'La password attuale non e corretta.',
                'new_password_min_6' => 'La nuova password deve essere almeno 6 caratteri.',
                'password_confirmation_mismatch' => 'Le password non coincidono.',
                'user_exists_email' => 'Un utente con questa email esiste gia.',
                'another_user_exists_email' => 'Un altro utente con questa email esiste gia.',
                'user_created' => 'Utente creato con successo.',
                'user_updated' => 'Utente aggiornato con successo.',
                'user_deleted' => 'Utente eliminato.',
                'cannot_delete_self' => 'Non puoi eliminare il tuo stesso account.',
                'workspace_required' => 'Workspace name e nome ambiente sono obbligatori.',
                'support_email_invalid' => 'Inserisci una support email valida.',
                'app_url_invalid' => 'Inserisci un URL applicazione valido, ad esempio https://example.com.',
                'mail_driver_invalid' => 'Mail driver non valido.',
                'mail_from_invalid' => 'Inserisci una email mittente valida per la consegna mail.',
                'mail_reply_to_invalid' => 'Inserisci una reply-to valida oppure lascia il campo vuoto.',
                'smtp_host_required' => 'SMTP host obbligatorio quando usi il driver SMTP.',
                'smtp_port_invalid' => 'SMTP port o timeout non validi.',
                'smtp_encryption_invalid' => 'SMTP encryption non valida. Usa none, tls oppure ssl.',
                'resend_api_key_required' => 'La chiave API Resend e obbligatoria quando usi il driver Resend.',
                'mail_test_recipient_invalid' => 'Inserisci una email valida per il test di invio.',
                'mail_test_sent' => 'Email di test inviata a :email.',
                'mail_test_failed' => 'Invio email di test non riuscito. Controlla configurazione e log.',
                'workspace_updated' => 'Workspace settings aggiornate con successo.',
                'notification_settings_updated' => 'Notification settings aggiornate con successo.',
                'roles_permissions_updated' => 'Ruoli e permessi aggiornati con successo.',
                'project_required_fields' => 'Nome progetto e codice sono obbligatori.',
                'project_code_exists' => 'Esiste gia un progetto con questo codice.',
                'project_date_invalid' => 'La data di consegna non puo essere precedente alla data di inizio.',
                'project_created' => 'Progetto creato con successo.',
                'project_updated' => 'Progetto aggiornato con successo.',
                'project_deleted' => 'Progetto eliminato.',
                'project_milestone_required' => 'Titolo milestone obbligatorio.',
                'project_milestone_created' => 'Milestone aggiunta al progetto.',
                'project_milestone_updated' => 'Milestone aggiornata.',
                'project_milestone_deleted' => 'Milestone rimossa dal progetto.',
                'project_task_required' => 'Titolo task obbligatorio.',
                'project_task_created' => 'Task aggiunto al progetto.',
                'project_task_updated' => 'Task aggiornato.',
                'project_task_deleted' => 'Task eliminato.',
                'project_task_status_updated' => 'Stato task aggiornato.',
            ],
            'en' => [
                'csrf_invalid' => 'Invalid security token.',
                'csrf_invalid_plain' => 'Invalid CSRF token',
                'db_unavailable_verify_env' => 'Database unavailable. Verify DB credentials in .env and make sure the database exists.',
                'db_unavailable_configure_env' => 'Database unavailable. Configure the .env file for development.',
                'invalid_credentials' => 'Invalid credentials.',
                'admin_email_invalid' => 'Enter a valid administrator email.',
                'reset_email_sent' => 'If the email is registered, you will receive a password reset link.',
                'reset_link_invalid' => 'The reset link is expired or invalid. Request a new link.',
                'passwords_mismatch' => 'Passwords do not match.',
                'password_min_8' => 'Password must be at least 8 characters.',
                'password_updated' => 'Password updated successfully. You can now sign in with the new password.',
                'ticket_created' => 'Ticket created successfully.',
                'status_invalid' => 'Invalid status.',
                'ticket_assigned' => 'Ticket assigned successfully.',
                'document_upload_required' => 'Customer and file are required.',
                'document_type_invalid' => 'Unsupported file type or file too large (max 10MB). Formats: PDF, JPG, PNG, DOC, DOCX.',
                'document_uploaded' => 'Document uploaded successfully.',
                'document_upload_error' => 'Error while uploading the file.',
                'document_deleted' => 'Document deleted.',
                'profile_updated' => 'Profile updated successfully.',
                'email_in_use' => 'Email is already used by another user.',
                'current_password_incorrect' => 'Current password is incorrect.',
                'new_password_min_6' => 'The new password must be at least 6 characters.',
                'password_confirmation_mismatch' => 'Passwords do not match.',
                'user_exists_email' => 'A user with this email already exists.',
                'another_user_exists_email' => 'Another user with this email already exists.',
                'user_created' => 'User created successfully.',
                'user_updated' => 'User updated successfully.',
                'user_deleted' => 'User deleted.',
                'cannot_delete_self' => 'You cannot delete your own account.',
                'workspace_required' => 'Workspace name and environment name are required.',
                'support_email_invalid' => 'Enter a valid support email.',
                'app_url_invalid' => 'Enter a valid application URL, for example https://example.com.',
                'mail_driver_invalid' => 'Invalid mail driver.',
                'mail_from_invalid' => 'Enter a valid sender email for mail delivery.',
                'mail_reply_to_invalid' => 'Enter a valid reply-to email or leave the field empty.',
                'smtp_host_required' => 'SMTP host is required when using the SMTP driver.',
                'smtp_port_invalid' => 'Invalid SMTP port or timeout value.',
                'smtp_encryption_invalid' => 'Invalid SMTP encryption. Use none, tls, or ssl.',
                'resend_api_key_required' => 'Resend API key is required when using the Resend driver.',
                'mail_test_recipient_invalid' => 'Enter a valid email address for the test send.',
                'mail_test_sent' => 'Test email sent to :email.',
                'mail_test_failed' => 'Test email delivery failed. Check configuration and logs.',
                'workspace_updated' => 'Workspace settings updated successfully.',
                'notification_settings_updated' => 'Notification settings updated successfully.',
                'roles_permissions_updated' => 'Roles and permissions updated successfully.',
                'project_required_fields' => 'Project name and code are required.',
                'project_code_exists' => 'A project with this code already exists.',
                'project_date_invalid' => 'Due date cannot be earlier than start date.',
                'project_created' => 'Project created successfully.',
                'project_updated' => 'Project updated successfully.',
                'project_deleted' => 'Project deleted.',
                'project_milestone_required' => 'Milestone title is required.',
                'project_milestone_created' => 'Milestone added to the project.',
                'project_milestone_updated' => 'Milestone updated.',
                'project_milestone_deleted' => 'Milestone removed from the project.',
                'project_task_required' => 'Task title is required.',
                'project_task_created' => 'Task added to the project.',
                'project_task_updated' => 'Task updated.',
                'project_task_deleted' => 'Task deleted.',
                'project_task_status_updated' => 'Task status updated.',
            ],
            'fr' => [
                'csrf_invalid' => 'Jeton de securite invalide.',
                'csrf_invalid_plain' => 'Jeton CSRF invalide',
                'db_unavailable_verify_env' => 'Base de donnees indisponible. Verifiez les identifiants DB dans .env et assurez-vous que la base existe.',
                'db_unavailable_configure_env' => 'Base de donnees indisponible. Configurez le fichier .env pour le developpement.',
                'invalid_credentials' => 'Identifiants invalides.',
                'admin_email_invalid' => 'Saisissez un email administrateur valide.',
                'reset_email_sent' => 'Si l email est enregistre, vous recevrez un lien de reinitialisation du mot de passe.',
                'reset_link_invalid' => 'Le lien de reinitialisation est expire ou invalide. Demandez un nouveau lien.',
                'passwords_mismatch' => 'Les mots de passe ne correspondent pas.',
                'password_min_8' => 'Le mot de passe doit contenir au moins 8 caracteres.',
                'password_updated' => 'Mot de passe mis a jour avec succes. Vous pouvez maintenant vous connecter avec le nouveau mot de passe.',
                'ticket_created' => 'Ticket cree avec succes.',
                'status_invalid' => 'Statut invalide.',
                'ticket_assigned' => 'Ticket attribue avec succes.',
                'document_upload_required' => 'Client et fichier sont obligatoires.',
                'document_type_invalid' => 'Type de fichier non pris en charge ou fichier trop volumineux (max 10MB). Formats : PDF, JPG, PNG, DOC, DOCX.',
                'document_uploaded' => 'Document televerse avec succes.',
                'document_upload_error' => 'Erreur lors du televersement du fichier.',
                'document_deleted' => 'Document supprime.',
                'profile_updated' => 'Profil mis a jour avec succes.',
                'email_in_use' => 'L email est deja utilise par un autre utilisateur.',
                'current_password_incorrect' => 'Le mot de passe actuel est incorrect.',
                'new_password_min_6' => 'Le nouveau mot de passe doit contenir au moins 6 caracteres.',
                'password_confirmation_mismatch' => 'Les mots de passe ne correspondent pas.',
                'user_exists_email' => 'Un utilisateur avec cet email existe deja.',
                'another_user_exists_email' => 'Un autre utilisateur avec cet email existe deja.',
                'user_created' => 'Utilisateur cree avec succes.',
                'user_updated' => 'Utilisateur mis a jour avec succes.',
                'user_deleted' => 'Utilisateur supprime.',
                'cannot_delete_self' => 'Vous ne pouvez pas supprimer votre propre compte.',
                'workspace_required' => 'Le nom du workspace et le nom d environnement sont obligatoires.',
                'support_email_invalid' => 'Saisissez un email de support valide.',
                'app_url_invalid' => 'Saisissez une URL application valide, par exemple https://example.com.',
                'mail_driver_invalid' => 'Driver mail invalide.',
                'mail_from_invalid' => 'Saisissez un email expediteur valide pour la livraison mail.',
                'mail_reply_to_invalid' => 'Saisissez un email reply-to valide ou laissez le champ vide.',
                'smtp_host_required' => 'Le host SMTP est obligatoire avec le driver SMTP.',
                'smtp_port_invalid' => 'Port SMTP ou timeout invalide.',
                'smtp_encryption_invalid' => 'Encryption SMTP invalide. Utilisez none, tls ou ssl.',
                'resend_api_key_required' => 'La cle API Resend est obligatoire avec le driver Resend.',
                'mail_test_recipient_invalid' => 'Saisissez un email valide pour le test d envoi.',
                'mail_test_sent' => 'Email de test envoye a :email.',
                'mail_test_failed' => 'Echec de l envoi du mail de test. Verifiez configuration et logs.',
                'workspace_updated' => 'Parametres workspace mis a jour avec succes.',
                'notification_settings_updated' => 'Parametres notifications mis a jour avec succes.',
                'roles_permissions_updated' => 'Roles et permissions mis a jour avec succes.',
                'project_required_fields' => 'Le nom du projet et le code sont obligatoires.',
                'project_code_exists' => 'Un projet avec ce code existe deja.',
                'project_date_invalid' => 'La date de livraison ne peut pas etre anterieure a la date de debut.',
                'project_created' => 'Projet cree avec succes.',
                'project_updated' => 'Projet mis a jour avec succes.',
                'project_deleted' => 'Projet supprime.',
                'project_milestone_required' => 'Le titre de la milestone est obligatoire.',
                'project_milestone_created' => 'Milestone ajoutee au projet.',
                'project_milestone_updated' => 'Milestone mise a jour.',
                'project_milestone_deleted' => 'Milestone retiree du projet.',
                'project_task_required' => 'Le titre de la tache est obligatoire.',
                'project_task_created' => 'Tache ajoutee au projet.',
                'project_task_updated' => 'Tache mise a jour.',
                'project_task_deleted' => 'Tache supprimee.',
                'project_task_status_updated' => 'Statut de la tache mis a jour.',
            ],
            'es' => [
                'csrf_invalid' => 'Token de seguridad no valido.',
                'csrf_invalid_plain' => 'Token CSRF no valido',
                'db_unavailable_verify_env' => 'Base de datos no disponible. Verifica las credenciales DB en .env y asegúrate de que la base exista.',
                'db_unavailable_configure_env' => 'Base de datos no disponible. Configura el archivo .env para desarrollo.',
                'invalid_credentials' => 'Credenciales no validas.',
                'admin_email_invalid' => 'Introduce un email de administrador valido.',
                'reset_email_sent' => 'Si el email esta registrado, recibiras un enlace para restablecer la contrasena.',
                'reset_link_invalid' => 'El enlace de restablecimiento ha caducado o no es valido. Solicita uno nuevo.',
                'passwords_mismatch' => 'Las contrasenas no coinciden.',
                'password_min_8' => 'La contrasena debe tener al menos 8 caracteres.',
                'password_updated' => 'Contrasena actualizada con exito. Ahora puedes iniciar sesion con la nueva contrasena.',
                'ticket_created' => 'Ticket creado con exito.',
                'status_invalid' => 'Estado no valido.',
                'ticket_assigned' => 'Ticket asignado con exito.',
                'document_upload_required' => 'Cliente y archivo son obligatorios.',
                'document_type_invalid' => 'Tipo de archivo no compatible o demasiado grande (max 10MB). Formatos: PDF, JPG, PNG, DOC, DOCX.',
                'document_uploaded' => 'Documento cargado con exito.',
                'document_upload_error' => 'Error al cargar el archivo.',
                'document_deleted' => 'Documento eliminado.',
                'profile_updated' => 'Perfil actualizado con exito.',
                'email_in_use' => 'El email ya esta en uso por otro usuario.',
                'current_password_incorrect' => 'La contrasena actual no es correcta.',
                'new_password_min_6' => 'La nueva contrasena debe tener al menos 6 caracteres.',
                'password_confirmation_mismatch' => 'Las contrasenas no coinciden.',
                'user_exists_email' => 'Ya existe un usuario con este email.',
                'another_user_exists_email' => 'Ya existe otro usuario con este email.',
                'user_created' => 'Usuario creado con exito.',
                'user_updated' => 'Usuario actualizado con exito.',
                'user_deleted' => 'Usuario eliminado.',
                'cannot_delete_self' => 'No puedes eliminar tu propia cuenta.',
                'workspace_required' => 'Workspace name y nombre del entorno son obligatorios.',
                'support_email_invalid' => 'Introduce un email de soporte valido.',
                'app_url_invalid' => 'Introduce una URL de aplicacion valida, por ejemplo https://example.com.',
                'mail_driver_invalid' => 'Mail driver no valido.',
                'mail_from_invalid' => 'Introduce un email remitente valido para el envio.',
                'mail_reply_to_invalid' => 'Introduce un reply-to valido o deja el campo vacio.',
                'smtp_host_required' => 'SMTP host obligatorio cuando usas el driver SMTP.',
                'smtp_port_invalid' => 'SMTP port o timeout no validos.',
                'smtp_encryption_invalid' => 'SMTP encryption no valida. Usa none, tls o ssl.',
                'resend_api_key_required' => 'La API key de Resend es obligatoria cuando usas el driver Resend.',
                'mail_test_recipient_invalid' => 'Introduce un email valido para la prueba de envio.',
                'mail_test_sent' => 'Email de prueba enviado a :email.',
                'mail_test_failed' => 'Fallo en el envio del email de prueba. Revisa configuracion y logs.',
                'workspace_updated' => 'Configuracion del workspace actualizada con exito.',
                'notification_settings_updated' => 'Configuracion de notificaciones actualizada con exito.',
                'roles_permissions_updated' => 'Roles y permisos actualizados con exito.',
                'project_required_fields' => 'Nombre del proyecto y codigo son obligatorios.',
                'project_code_exists' => 'Ya existe un proyecto con este codigo.',
                'project_date_invalid' => 'La fecha de entrega no puede ser anterior a la fecha de inicio.',
                'project_created' => 'Proyecto creado con exito.',
                'project_updated' => 'Proyecto actualizado con exito.',
                'project_deleted' => 'Proyecto eliminado.',
                'project_milestone_required' => 'El titulo de la milestone es obligatorio.',
                'project_milestone_created' => 'Milestone agregada al proyecto.',
                'project_milestone_updated' => 'Milestone actualizada.',
                'project_milestone_deleted' => 'Milestone eliminada del proyecto.',
                'project_task_required' => 'El titulo de la tarea es obligatorio.',
                'project_task_created' => 'Tarea agregada al proyecto.',
                'project_task_updated' => 'Tarea actualizada.',
                'project_task_deleted' => 'Tarea eliminada.',
                'project_task_status_updated' => 'Estado de la tarea actualizado.',
            ],
        ];

        $message = $messages[$locale][$key] ?? $messages[self::DEFAULT_LOCALE][$key] ?? $key;
        foreach ($replace as $replaceKey => $value) {
            $message = str_replace(':' . $replaceKey, (string)$value, $message);
        }

        return $message;
    }

    public static function translateResponse(string $content, ?string $uri = null): string {
        if ($content === '' || self::current() === self::DEFAULT_LOCALE) {
            return $content;
        }

        $headers = headers_list();
        foreach ($headers as $header) {
            if (stripos($header, 'Content-Type:') === 0 && stripos($header, 'text/html') === false) {
                return $content;
            }
        }

        $uri = (string)($uri ?? '');
        if (strpos($uri, '/api/') === 0 || preg_match('#^/documents/\d+/download$#', $uri)) {
            return $content;
        }

        $content = preg_replace('/<html(\s+lang=")([^"]+)(")/i', '<html$1' . self::current() . '$3', $content, 1) ?? $content;

        $map = self::dictionary(self::current());
        if (empty($map)) {
            return $content;
        }

        uksort($map, static function ($a, $b) {
            return mb_strlen((string)$b) <=> mb_strlen((string)$a);
        });

        return strtr($content, $map);
    }

    private static function isSupported(?string $locale): bool {
        if (!is_string($locale) || $locale === '') {
            return false;
        }

        return array_key_exists(strtolower($locale), self::supported());
    }

    private static function detectPreferredLocale(): array {
        $browser = self::detectFromBrowser();
        if (self::isSupported($browser)) {
            return ['locale' => (string)$browser, 'source' => 'auto_browser'];
        }

        $country = self::detectCountryCode();
        $localeFromCountry = self::mapCountryToLocale($country);
        if (self::isSupported($localeFromCountry)) {
            return ['locale' => (string)$localeFromCountry, 'source' => 'auto_ip'];
        }

        return ['locale' => self::DEFAULT_LOCALE, 'source' => 'default'];
    }

    private static function detectFromBrowser(): ?string {
        $header = (string)($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
        if ($header === '') {
            return null;
        }

        foreach (explode(',', $header) as $part) {
            $code = strtolower(trim(explode(';', $part)[0] ?? ''));
            $short = substr($code, 0, 2);
            if (self::isSupported($short)) {
                return $short;
            }
        }

        return null;
    }

    private static function detectCountryCode(): ?string {
        $headerKeys = [
            'HTTP_CF_IPCOUNTRY',
            'HTTP_CLOUDFRONT_VIEWER_COUNTRY',
            'HTTP_X_APPENGINE_COUNTRY',
            'HTTP_X_COUNTRY_CODE',
            'GEOIP_COUNTRY_CODE',
            'HTTP_GEOIP_COUNTRY_CODE',
            'HTTP_X_GEO_COUNTRY',
        ];

        foreach ($headerKeys as $key) {
            $value = strtoupper(trim((string)($_SERVER[$key] ?? '')));
            if (preg_match('/^[A-Z]{2}$/', $value)) {
                return $value;
            }
        }

        return null;
    }

    private static function mapCountryToLocale(?string $country): ?string {
        if (!is_string($country) || $country === '') {
            return null;
        }

        $country = strtoupper($country);

        if ($country === 'IT' || $country === 'SM' || $country === 'VA') {
            return 'it';
        }

        if ($country === 'FR' || $country === 'BE' || $country === 'LU' || $country === 'MC') {
            return 'fr';
        }

        $spanishCountries = [
            'ES', 'AR', 'BO', 'CL', 'CO', 'CR', 'CU', 'DO', 'EC', 'GQ', 'GT',
            'HN', 'MX', 'NI', 'PA', 'PE', 'PR', 'PY', 'SV', 'UY', 'VE',
        ];
        if (in_array($country, $spanishCountries, true)) {
            return 'es';
        }

        $englishCountries = [
            'US', 'GB', 'IE', 'CA', 'AU', 'NZ', 'ZA', 'SG', 'IN',
        ];
        if (in_array($country, $englishCountries, true)) {
            return 'en';
        }

        return null;
    }

    private static function dictionary(string $locale): array {
        $dictionaries = [
            'en' => [
                'Login - CoreSuite Lite' => 'Login - CoreSuite Lite',
                'Reset Password - CoreSuite Lite' => 'Reset Password - CoreSuite Lite',
                'Nuova Password - CoreSuite Lite' => 'New Password - CoreSuite Lite',
                'Accedi al tuo workspace operativo' => 'Sign in to your operational workspace',
                "Client portal e admin dashboard in un'unica esperienza, con un'interfaccia piu chiara, coerente e focalizzata sull'operativita." => 'Client portal and admin dashboard in one experience, with a clearer, more consistent interface focused on operations.',
                'Dashboard e KPI in tempo reale' => 'Dashboard and real-time KPIs',
                'Gestione ticket e documenti centralizzata' => 'Centralized ticket and document management',
                'Sessioni protette e controllo accessi' => 'Protected sessions and access control',
                'Bentornato' => 'Welcome back',
                'Inserisci le tue credenziali per entrare.' => 'Enter your credentials to continue.',
                'Ricordami' => 'Remember me',
                'Password dimenticata?' => 'Forgot password?',
                'Accedi' => 'Sign in',
                'Recupero accesso' => 'Access recovery',
                'Recupera la tua password' => 'Recover your password',
                "Inserisci l'indirizzo email associato all'account. Se presente, riceverai le istruzioni per il reset." => 'Enter the email address linked to the account. If it exists, you will receive reset instructions.',
                'Invia link di reset' => 'Send reset link',
                'Torna al login' => 'Back to login',
                'Nuova password' => 'New password',
                'Imposta una nuova password' => 'Set a new password',
                "Scegli una password robusta e confermala per completare il recupero dell'account." => 'Choose a strong password and confirm it to complete account recovery.',
                'Conferma password' => 'Confirm password',
                'Aggiorna password' => 'Update password',
                'Seleziona tema' => 'Select theme',
                'Tema' => 'Theme',
                'Dashboard' => 'Dashboard',
                'Documenti' => 'Documents',
                'Profilo' => 'Profile',
                'Ricerca globale' => 'Global search',
                'Gestione utenti' => 'User management',
                'Carica documento' => 'Upload document',
                'Filtra moduli e pagine...' => 'Filter modules and pages...',
                'Filtra menu sidebar' => 'Filter sidebar menu',
                'Operativo' => 'Operations',
                'Amministrazione' => 'Administration',
                'Workspace' => 'Workspace',
                'Preferenze' => 'Preferences',
                'Settings' => 'Settings',
                'Search' => 'Search',
                'CRM-style workspace' => 'CRM-style workspace',
                'Apri o chiudi menu' => 'Open or close menu',
                'Navigazione rapida' => 'Quick navigation',
                'Cerca ticket, clienti, documenti...' => 'Search tickets, customers, documents...',
                'Cerca in workspace' => 'Search in workspace',
                'Digita almeno 2 caratteri per cercare nel workspace.' => 'Type at least 2 characters to search the workspace.',
                'Le tue scorciatoie personali' => 'Your personal shortcuts',
                'Operazioni frequenti' => 'Frequent actions',
                'Ultime ricerche del workspace' => 'Latest workspace searches',
                'Apri risultati completi' => 'Open full results',
                'Notification inbox' => 'Notification inbox',
                'Logout' => 'Logout',
                'Nuovo' => 'New',
                'attive' => 'active',
                'Workspace attivo' => 'Workspace active',
                'Panoramica aggiornata e shell pronta per il lavoro.' => 'Updated overview and shell ready for work.',
                'Follow-up ticket' => 'Ticket follow-up',
                'Controlla i ticket aperti e le priorita alte.' => 'Check open tickets and high priorities.',
                'Library review' => 'Library review',
                'Apri l archivio documentale con filtri persistenti.' => 'Open the document library with persistent filters.',
                'Admin area' => 'Admin area',
                'Verifica utenti attivi, ruoli e accessi del workspace.' => 'Review active users, roles and workspace access.',
                'Workspace settings' => 'Workspace settings',
                'Notification settings' => 'Notification settings',
                'Roles permissions' => 'Roles permissions',
                'Reports' => 'Reports',
                'Audit logs' => 'Audit logs',
                'Customers' => 'Customers',
                'Overview' => 'Overview',
                'Apri tickets' => 'Open tickets',
                'Apri customers' => 'Open customers',
                'Apri reports' => 'Open reports',
                'Controllo operativo e governance' => 'Operational control and governance',
                'Azioni rapide sul supporto' => 'Quick support actions',
                'Le tue attivita piu frequenti' => 'Your most frequent activities',
                'Admin workflow' => 'Admin workflow',
                'Operator workflow' => 'Operator workflow',
                'Customer workspace' => 'Customer workspace',
                'Utenti attivi' => 'Active users',
                'Priorita alte' => 'High priority',
                'Documents board' => 'Documents board',
                'Ticket aperti' => 'Open tickets',
                'In lavorazione' => 'In progress',
                'I miei documenti' => 'My documents',
                'Apri richiesta' => 'Open request',
                'Tutti gli stati' => 'All statuses',
                'Aperti' => 'Open',
                'Risolti' => 'Resolved',
                'Chiusi' => 'Closed',
                'Tutte le priorita' => 'All priorities',
                'Alta' => 'High',
                'Media' => 'Medium',
                'Bassa' => 'Low',
                'Tutti i tipi' => 'All types',
                'Immagini' => 'Images',
                'Tutti i clienti' => 'All customers',
                'Tutti i ruoli' => 'All roles',
                'Tutte le azioni' => 'All actions',
                'Create' => 'Create',
                'Update' => 'Update',
                'Delete' => 'Delete',
                'Tutte le entità' => 'All entities',
                'Utente' => 'User',
                'Nome file' => 'File name',
                'Dimensione' => 'Size',
                'Azioni' => 'Actions',
                'Data' => 'Date',
                'Nome' => 'Name',
                'Telefono' => 'Phone',
                'Ruolo' => 'Role',
                'Stato' => 'Status',
                'Evento' => 'Event',
                'Attore' => 'Actor',
                'Entità' => 'Entity',
                'Timestamp' => 'Timestamp',
                'Precedente' => 'Previous',
                'Successiva' => 'Next',
                'Archivio documentale clienti' => 'Customer document library',
                'Library view' => 'Library view',
                'Customer index' => 'Customer index',
                'Lista clienti' => 'Customer list',
                'Ticket board' => 'Ticket board',
                'Panoramica richieste' => 'Requests overview',
                'Elenco utenti' => 'User list',
                'Directory' => 'Directory',
                'Audit stream' => 'Audit stream',
                'Storico completo degli eventi' => 'Complete event history',
                'Permission matrix' => 'Permission matrix',
                'Ruoli e capability applicative' => 'Roles and application capabilities',
                'Definisci chi puo vedere, aprire e amministrare ogni area' => 'Define who can view, open and manage each area',
                'Una matrice centrale per governare ruoli applicativi e permessi reali della suite, con un setup leggibile e coerente con il resto dell area admin.' => 'A central matrix to manage application roles and real permissions across the suite, with a readable setup aligned with the rest of the admin area.',
                'Salva matrice' => 'Save matrix',
                'Torna agli utenti' => 'Back to users',
                'Nuovo documento' => 'New document',
                'Nuovo cliente' => 'New customer',
                'Nuovo utente' => 'New user',
                'Nuovo ticket' => 'New ticket',
                'Apri documents board' => 'Open documents board',
                'Apri board kanban' => 'Open kanban board',
                'Apri backlog' => 'Open backlog',
                'Torna ai reports' => 'Back to reports',
                'Torna alla dashboard' => 'Back to dashboard',
                'Torna ai ticket' => 'Back to tickets',
                'Torna ai clienti' => 'Back to customers',
                'Torna alla lista' => 'Back to list',
                'Archivio clienti piu ordinato e leggibile' => 'A cleaner and easier-to-read customer archive',
                'Nessun documento disponibile.' => 'No documents available.',
                'Nessun ticket disponibile.' => 'No tickets available.',
                'Nessun utente trovato.' => 'No users found.',
                'Nessun evento audit trovato.' => 'No audit events found.',
                'Nessuna azione registrata per questo filtro.' => 'No actions recorded for this filter.',
                'Nessuna entità registrata per questo filtro.' => 'No entities recorded for this filter.',
                'Nessuna attivita recente.' => 'No recent activity.',
                'Nessun allegato disponibile.' => 'No attachments available.',
                'Nessun commento ancora.' => 'No comments yet.',
                'Nuovo commento' => 'New comment',
                'Stato attuale' => 'Current status',
                'Salva stato' => 'Save status',
                'Salva assegnazione' => 'Save assignment',
                'Salva profilo' => 'Save profile',
                'Salva impostazioni' => 'Save settings',
                'Salva notifiche' => 'Save notifications',
                'Ticket totali' => 'Total tickets',
                'Gestione Utenti' => 'User management',
                'Utenti visibili' => 'Visible users',
                'Clienti' => 'Customers',
                'Telefono non disponibile' => 'Phone not available',
                'Password attuale' => 'Current password',
                'è obbligatorio' => 'is required',
                'deve essere almeno' => 'must be at least',
                'caratteri' => 'characters',
                'Vista documentale orientata ai tipi di contenuto' => 'Document view oriented around content types',
                'Vista tabellare' => 'Table view',
                'Archivio condiviso' => 'Shared archive',
                'Nessun documento in questa colonna.' => 'No documents in this column.',
                'Gestisci ticket' => 'Manage tickets',
                'Apri documenti' => 'Open documents',
                'Trend operativo' => 'Operational trend',
                'Archivio' => 'Archive',
                'Documenti disponibili al download' => 'Documents available for download',
                'Archivio documentale disponibile per i clienti.' => 'Document archive available for customers.',
                'Archivio documenti ancora vuoto.' => 'Document archive still empty.',
                'Base clienti attiva pronta per le operazioni.' => 'Active customer base ready for operations.',
                'Nessun cliente attivo rilevato.' => 'No active customers detected.',
                'Nessuna notifica da mostrare.' => 'No notifications to show.',
                'Apri board completa' => 'Open full board',
                'Nessun ticket' => 'No tickets',
                'Customer summary' => 'Customer summary',
                'Nessun ticket recente da mostrare.' => 'No recent tickets to show.',
                'Apri archivio' => 'Open archive',
                'Nessun documento caricato di recente.' => 'No recently uploaded documents.',
                'Report operativi per capire carico, clienti e flussi' => 'Operational reports to understand workload, customers and flows',
                'Documenti 30 giorni' => 'Documents 30 days',
                'Nessun dato disponibile sulla distribuzione ticket.' => 'No data available on ticket distribution.',
                'Nessuna categoria ancora disponibile.' => 'No category available yet.',
                'Nessun cliente disponibile per l analisi.' => 'No customers available for analysis.',
                'Nessuna attivita recente disponibile.' => 'No recent activity available.',
                'Aggiungi un documento pronto per l\'archivio clienti' => 'Add a document ready for the customer archive',
                'Torna ai documenti' => 'Back to documents',
                'Annulla' => 'Cancel',
                'Aggiungi commento' => 'Add comment',
                'Dettaglio Ticket #' => 'Ticket Detail #',
                'Il mio profilo' => 'My profile',
                'Modifica cliente' => 'Edit customer',
                'Nessuna attivita recente per questo cliente.' => 'No recent activity for this customer.',
                'Request form' => 'Request form',
                'Invia richiesta' => 'Send request',
                'Crea un nuovo utente pronto all\'uso' => 'Create a new user ready to work',
                'Aggiorna dati, ruolo e stato account' => 'Update details, role and account status',
                'Modifica Utente' => 'Edit User',
                'Nuovo Utente' => 'New User',
                '403 - Accesso negato' => '403 - Access denied',
                '404 - Pagina non trovata' => '404 - Page not found',
                'Apri ticket' => 'Open tickets',
                'Area personale' => 'Profile area',
                'Cerca nel workspace' => 'Search workspace',
                'Nessun risultato trovato per "' => 'No results found for "',
                'Nessun ticket in questa ricerca.' => 'No tickets found in this search.',
                'Nessun documento in questa ricerca.' => 'No documents found in this search.',
                'Nessun cliente in questa ricerca.' => 'No customers found in this search.',
                'Configura CoreSuite Lite in pochi passaggi' => 'Set up CoreSuite Lite in a few steps',
                'Imposta database e amministratore iniziale da una procedura unica, chiara e pronta per la prima installazione.' => 'Set up the database and the initial administrator through a single, clear flow ready for the first installation.',
                'Connessione database e bootstrap applicativo' => 'Database connection and application bootstrap',
                'Creazione account amministratore iniziale' => 'Initial administrator account creation',
                'Base pronta per dashboard, ticket e documenti' => 'Foundation ready for dashboard, tickets and documents',
                'Installazione' => 'Installation',
                'Completa i dati richiesti per inizializzare il sistema.' => 'Complete the required data to initialize the system.',
                'Nome database' => 'Database name',
                'Amministratore' => 'Administrator',
                'Installa CoreSuite Lite' => 'Install CoreSuite Lite',
                'Accesso negato' => 'Access denied',
                'Non hai i permessi necessari per visualizzare questa pagina o eseguire questa azione.' => 'You do not have the required permissions to view this page or perform this action.',
                'Pagina non trovata' => 'Page not found',
                'La risorsa che stai cercando non esiste piu o il link non e valido.' => 'The resource you are looking for no longer exists or the link is invalid.',
                'Apri una richiesta ben contestualizzata' => 'Open a well-contextualized request',
                'Descrivi il problema con chiarezza, scegli la priorita giusta e allega materiali utili per velocizzare la presa in carico.' => 'Describe the problem clearly, choose the right priority and attach useful material to speed up handling.',
                'Definisci il contesto della richiesta' => 'Define the request context',
                'Imposta il tipo di ticket e il livello di urgenza per orientare correttamente il team.' => 'Set the ticket type and urgency level to guide the team correctly.',
                'Racconta il problema con precisione' => 'Describe the problem precisely',
                'Aggiungi materiali utili' => 'Add useful material',
                'Descrizione opzionale' => 'Optional description',
                'Allega file opzionale' => 'Optional file attachment',
                'Come verra letto il ticket' => 'How the ticket will be read',
                'Prima di inviare' => 'Before sending',
                'Cosa succede dopo l invio' => 'What happens after submission',
                'Seleziona il cliente, carica il file corretto e arricchiscilo con note e tag per renderlo piu facile da ritrovare.' => 'Select the customer, upload the right file and enrich it with notes and tags to make it easier to find.',
                'Scegli correttamente destinazione e file' => 'Choose destination and file correctly',
                'Aggiungi contesto utile alla ricerca' => 'Add context useful for search',
                'Descrizione e tag rendono l archivio piu leggibile e piu facile da usare nel tempo.' => 'Description and tags make the archive more readable and easier to use over time.',
                'Cosa stai definendo' => 'What you are defining',
                'Caricamento efficace' => 'Effective upload',
                'Pattern consigliato' => 'Recommended pattern',
                'Persone, ruoli e stato account in un\'unica vista' => 'People, roles and account status in a single view',
                'Vista clienti orientata a operazioni, storico e materiali' => 'Customer view focused on operations, history and materials',
                'Trova velocemente ticket, documenti e clienti' => 'Quickly find tickets, documents and customers',
                'Gestisci il tuo account e tieni traccia delle attivita recenti' => 'Manage your account and track recent activity',
                'Personalizza identita, shell e moduli visibili della suite' => 'Customize identity, shell and visible suite modules',
                'Decidi cosa segnalare, dove e con quale intensita' => 'Decide what to signal, where and with what intensity',
                'Admin only' => 'Admin only',
                'Governance live' => 'Governance live',
                'Admin shell' => 'Admin shell',
                'Controllo completo del workspace' => 'Complete workspace control',
                'Operations focus' => 'Operations focus',
                'Support workflow' => 'Support workflow',
                'Supporto e follow-up in tempo reale' => 'Real-time support and follow-up',
                'Requests & docs' => 'Requests & docs',
                'Area cliente sempre a portata di mano' => 'Customer area always within reach',
                'Suite workspace' => 'Suite workspace',
                'Operational shell' => 'Operational shell',
                'Workspace operativo attivo' => 'Operational workspace active',
                'Light' => 'Light',
                'Dark' => 'Dark',
                'System' => 'System',
                'Italiano' => 'Italian',
                'English' => 'English',
                'Francais' => 'French',
                'Espanol' => 'Spanish',
            ],
            'fr' => [
                'Accedi al tuo workspace operativo' => 'Accedez a votre espace de travail operationnel',
                'Bentornato' => 'Bon retour',
                'Inserisci le tue credenziali per entrare.' => 'Saisissez vos identifiants pour continuer.',
                'Ricordami' => 'Se souvenir de moi',
                'Password dimenticata?' => 'Mot de passe oublie ?',
                'Accedi' => 'Se connecter',
                'Recupera la tua password' => 'Recuperez votre mot de passe',
                'Invia link di reset' => 'Envoyer le lien de reinitialisation',
                'Torna al login' => 'Retour a la connexion',
                'Imposta una nuova password' => 'Definir un nouveau mot de passe',
                'Conferma password' => 'Confirmer le mot de passe',
                'Aggiorna password' => 'Mettre a jour le mot de passe',
                'Seleziona tema' => 'Choisir le theme',
                'Tema' => 'Theme',
                'Dashboard' => 'Tableau de bord',
                'Documenti' => 'Documents',
                'Profilo' => 'Profil',
                'Ricerca globale' => 'Recherche globale',
                'Gestione utenti' => 'Gestion des utilisateurs',
                'Carica documento' => 'Televerser un document',
                'Operativo' => 'Operationnel',
                'Amministrazione' => 'Administration',
                'Workspace settings' => 'Parametres du workspace',
                'Notification settings' => 'Parametres de notification',
                'Roles permissions' => 'Roles et permissions',
                'Reports' => 'Rapports',
                'Audit logs' => 'Journaux d audit',
                'Customers' => 'Clients',
                'Overview' => 'Vue generale',
                'Nuovo' => 'Nouveau',
                'Notification inbox' => 'Boite de notifications',
                'Area personale' => 'Espace personnel',
                'Logout' => 'Deconnexion',
                'Aperti' => 'Ouverts',
                'In lavorazione' => 'En cours',
                'Risolti' => 'Resolus',
                'Chiusi' => 'Fermes',
                'Tutti gli stati' => 'Tous les statuts',
                'Tutte le priorita' => 'Toutes les priorites',
                'Alta' => 'Haute',
                'Media' => 'Moyenne',
                'Bassa' => 'Basse',
                'Tutti i tipi' => 'Tous les types',
                'Immagini' => 'Images',
                'Tutti i clienti' => 'Tous les clients',
                'Tutti i ruoli' => 'Tous les roles',
                'Tutte le azioni' => 'Toutes les actions',
                'Tutte le entità' => 'Toutes les entites',
                'Azioni' => 'Actions',
                'Data' => 'Date',
                'Nome' => 'Nom',
                'Telefono' => 'Telephone',
                'Ruolo' => 'Role',
                'Stato' => 'Statut',
                'Evento' => 'Evenement',
                'Attore' => 'Acteur',
                'Entità' => 'Entite',
                'Timestamp' => 'Horodatage',
                'Precedente' => 'Precedent',
                'Successiva' => 'Suivante',
                'Customer index' => 'Index clients',
                'Lista clienti' => 'Liste des clients',
                'Ticket board' => 'Tableau des tickets',
                'Panoramica richieste' => 'Vue d ensemble des demandes',
                'Library view' => 'Vue bibliotheque',
                'Archivio documentale clienti' => 'Bibliotheque documentaire clients',
                'Elenco utenti' => 'Liste des utilisateurs',
                'Audit stream' => 'Flux audit',
                'Storico completo degli eventi' => 'Historique complet des evenements',
                'Permission matrix' => 'Matrice des permissions',
                'Salva matrice' => 'Enregistrer la matrice',
                'Torna agli utenti' => 'Retour aux utilisateurs',
                'Nuovo documento' => 'Nouveau document',
                'Nuovo cliente' => 'Nouveau client',
                'Nuovo utente' => 'Nouvel utilisateur',
                'Nuovo ticket' => 'Nouveau ticket',
                'Apri documents board' => 'Ouvrir le board documents',
                'Apri board kanban' => 'Ouvrir le board kanban',
                'Apri backlog' => 'Ouvrir le backlog',
                'Torna ai reports' => 'Retour aux rapports',
                'Torna alla dashboard' => 'Retour au tableau de bord',
                'Torna ai ticket' => 'Retour aux tickets',
                'Torna ai clienti' => 'Retour aux clients',
                'Torna alla lista' => 'Retour a la liste',
                'Archivio clienti piu ordinato e leggibile' => 'Archive clients plus ordonnee et lisible',
                'Nessun documento disponibile.' => 'Aucun document disponible.',
                'Nessun ticket disponibile.' => 'Aucun ticket disponible.',
                'Nessun utente trovato.' => 'Aucun utilisateur trouve.',
                'Nessun evento audit trovato.' => 'Aucun evenement audit trouve.',
                'Nessuna azione registrata per questo filtro.' => 'Aucune action enregistree pour ce filtre.',
                'Nessuna entità registrata per questo filtro.' => 'Aucune entite enregistree pour ce filtre.',
                'Nessuna attivita recente.' => 'Aucune activite recente.',
                'Nessun allegato disponibile.' => 'Aucune piece jointe disponible.',
                'Nessun commento ancora.' => 'Aucun commentaire pour le moment.',
                'Nuovo commento' => 'Nouveau commentaire',
                'Stato attuale' => 'Statut actuel',
                'Salva stato' => 'Enregistrer le statut',
                'Salva assegnazione' => 'Enregistrer l attribution',
                'Salva profilo' => 'Enregistrer le profil',
                'Salva impostazioni' => 'Enregistrer les parametres',
                'Salva notifiche' => 'Enregistrer les notifications',
                'Ticket totali' => 'Tickets totaux',
                'Gestione Utenti' => 'Gestion des utilisateurs',
                'Utenti visibili' => 'Utilisateurs visibles',
                'Clienti' => 'Clients',
                'Nome file' => 'Nom du fichier',
                'Telefono non disponibile' => 'Telephone non disponible',
                'Password attuale' => 'Mot de passe actuel',
                'è obbligatorio' => 'est obligatoire',
                'deve essere almeno' => 'doit contenir au moins',
                'caratteri' => 'caracteres',
                'Vista documentale orientata ai tipi di contenuto' => 'Vue documentaire orientee par types de contenu',
                'Vista tabellare' => 'Vue tabulaire',
                'Archivio condiviso' => 'Archive partagee',
                'Nessun documento in questa colonna.' => 'Aucun document dans cette colonne.',
                'Gestisci ticket' => 'Gerer les tickets',
                'Apri documenti' => 'Ouvrir les documents',
                'Trend operativo' => 'Tendance operationnelle',
                'Archivio' => 'Archive',
                'Documenti disponibili al download' => 'Documents disponibles au telechargement',
                'Archivio documentale disponibile per i clienti.' => 'Archive documentaire disponible pour les clients.',
                'Archivio documenti ancora vuoto.' => 'Archive documentaire encore vide.',
                'Base clienti attiva pronta per le operazioni.' => 'Base clients active prete pour les operations.',
                'Nessun cliente attivo rilevato.' => 'Aucun client actif detecte.',
                'Nessuna notifica da mostrare.' => 'Aucune notification a afficher.',
                'Apri board completa' => 'Ouvrir le board complet',
                'Nessun ticket' => 'Aucun ticket',
                'Nessun ticket recente da mostrare.' => 'Aucun ticket recent a afficher.',
                'Apri archivio' => 'Ouvrir l archive',
                'Nessun documento caricato di recente.' => 'Aucun document recemment televerse.',
                'Report operativi per capire carico, clienti e flussi' => 'Rapports operationnels pour comprendre la charge, les clients et les flux',
                'Documenti 30 giorni' => 'Documents 30 jours',
                'Nessun dato disponibile sulla distribuzione ticket.' => 'Aucune donnee disponible sur la distribution des tickets.',
                'Nessuna categoria ancora disponibile.' => 'Aucune categorie disponible pour le moment.',
                'Apri customers' => 'Ouvrir les clients',
                'Nessun cliente disponibile per l analisi.' => 'Aucun client disponible pour l analyse.',
                'Nessuna attivita recente disponibile.' => 'Aucune activite recente disponible.',
                'Aggiungi un documento pronto per l\'archivio clienti' => 'Ajoutez un document pret pour l archive client',
                'Torna ai documenti' => 'Retour aux documents',
                'Annulla' => 'Annuler',
                'Aggiungi commento' => 'Ajouter un commentaire',
                'Dettaglio Ticket #' => 'Detail Ticket #',
                'Il mio profilo' => 'Mon profil',
                'Modifica cliente' => 'Modifier le client',
                'Nessuna attivita recente per questo cliente.' => 'Aucune activite recente pour ce client.',
                'Request form' => 'Formulaire de demande',
                'Invia richiesta' => 'Envoyer la demande',
                'Crea un nuovo utente pronto all\'uso' => 'Creer un nouvel utilisateur pret a l emploi',
                'Aggiorna dati, ruolo e stato account' => 'Mettre a jour les donnees, le role et le statut du compte',
                'Modifica Utente' => 'Modifier l utilisateur',
                'Nuovo Utente' => 'Nouvel utilisateur',
                '403 - Accesso negato' => '403 - Acces refuse',
                '404 - Pagina non trovata' => '404 - Page introuvable',
                'Apri ticket' => 'Ouvrir les tickets',
                'Cerca nel workspace' => 'Rechercher dans le workspace',
                'Nessun risultato trovato per "' => 'Aucun resultat trouve pour "',
                'Nessun ticket in questa ricerca.' => 'Aucun ticket dans cette recherche.',
                'Nessun documento in questa ricerca.' => 'Aucun document dans cette recherche.',
                'Nessun cliente in questa ricerca.' => 'Aucun client dans cette recherche.',
                'Configura CoreSuite Lite in pochi passaggi' => 'Configurez CoreSuite Lite en quelques etapes',
                'Installazione' => 'Installation',
                'Nome database' => 'Nom de la base',
                'Utente' => 'Utilisateur',
                'Amministratore' => 'Administrateur',
                'Installa CoreSuite Lite' => 'Installer CoreSuite Lite',
                'Accesso negato' => 'Acces refuse',
                'Non hai i permessi necessari per visualizzare questa pagina o eseguire questa azione.' => 'Vous n avez pas les autorisations necessaires pour afficher cette page ou effectuer cette action.',
                'Pagina non trovata' => 'Page introuvable',
                'Apri una richiesta ben contestualizzata' => 'Ouvrir une demande bien contextualisee',
                'Aggiungi materiali utili' => 'Ajouter des elements utiles',
                'Descrizione opzionale' => 'Description optionnelle',
                'Allega file opzionale' => 'Joindre un fichier optionnel',
                'Persone, ruoli e stato account in un\'unica vista' => 'Personnes, roles et statut du compte dans une seule vue',
                'Vista clienti orientata a operazioni, storico e materiali' => 'Vue clients orientee vers les operations, l historique et les contenus',
                'Trova velocemente ticket, documenti e clienti' => 'Trouvez rapidement tickets, documents et clients',
                'Gestisci il tuo account e tieni traccia delle attivita recenti' => 'Gerez votre compte et suivez les activites recentes',
                'Personalizza identita, shell e moduli visibili della suite' => 'Personnalisez l identite, le shell et les modules visibles de la suite',
                'Decidi cosa segnalare, dove e con quale intensita' => 'Decidez quoi signaler, ou et avec quelle intensite',
                'Light' => 'Clair',
                'Dark' => 'Sombre',
                'System' => 'Systeme',
                'Italiano' => 'Italien',
                'English' => 'Anglais',
                'Francais' => 'Francais',
                'Espanol' => 'Espagnol',
            ],
            'es' => [
                'Accedi al tuo workspace operativo' => 'Accede a tu workspace operativo',
                'Bentornato' => 'Bienvenido de nuevo',
                'Inserisci le tue credenziali per entrare.' => 'Introduce tus credenciales para continuar.',
                'Ricordami' => 'Recordarme',
                'Password dimenticata?' => 'Has olvidado tu contrasena?',
                'Accedi' => 'Entrar',
                'Recupera la tua password' => 'Recupera tu contrasena',
                'Invia link di reset' => 'Enviar enlace de restablecimiento',
                'Torna al login' => 'Volver al login',
                'Imposta una nuova password' => 'Define una nueva contrasena',
                'Conferma password' => 'Confirmar contrasena',
                'Aggiorna password' => 'Actualizar contrasena',
                'Seleziona tema' => 'Selecciona tema',
                'Tema' => 'Tema',
                'Dashboard' => 'Panel',
                'Documenti' => 'Documentos',
                'Profilo' => 'Perfil',
                'Ricerca globale' => 'Busqueda global',
                'Gestione utenti' => 'Gestion de usuarios',
                'Carica documento' => 'Subir documento',
                'Operativo' => 'Operativo',
                'Amministrazione' => 'Administracion',
                'Workspace settings' => 'Ajustes del workspace',
                'Notification settings' => 'Ajustes de notificaciones',
                'Roles permissions' => 'Roles y permisos',
                'Reports' => 'Informes',
                'Audit logs' => 'Registros de auditoria',
                'Customers' => 'Clientes',
                'Overview' => 'Resumen',
                'Nuovo' => 'Nuevo',
                'Notification inbox' => 'Bandeja de notificaciones',
                'Area personale' => 'Area personal',
                'Logout' => 'Cerrar sesion',
                'Aperti' => 'Abiertos',
                'In lavorazione' => 'En curso',
                'Risolti' => 'Resueltos',
                'Chiusi' => 'Cerrados',
                'Tutti gli stati' => 'Todos los estados',
                'Tutte le priorita' => 'Todas las prioridades',
                'Alta' => 'Alta',
                'Media' => 'Media',
                'Bassa' => 'Baja',
                'Tutti i tipi' => 'Todos los tipos',
                'Immagini' => 'Imagenes',
                'Tutti i clienti' => 'Todos los clientes',
                'Tutti i ruoli' => 'Todos los roles',
                'Tutte le azioni' => 'Todas las acciones',
                'Tutte le entità' => 'Todas las entidades',
                'Azioni' => 'Acciones',
                'Data' => 'Fecha',
                'Nome' => 'Nombre',
                'Telefono' => 'Telefono',
                'Ruolo' => 'Rol',
                'Stato' => 'Estado',
                'Evento' => 'Evento',
                'Attore' => 'Actor',
                'Entità' => 'Entidad',
                'Timestamp' => 'Marca temporal',
                'Precedente' => 'Anterior',
                'Successiva' => 'Siguiente',
                'Customer index' => 'Indice de clientes',
                'Lista clienti' => 'Lista de clientes',
                'Ticket board' => 'Tablero de tickets',
                'Panoramica richieste' => 'Resumen de solicitudes',
                'Library view' => 'Vista de biblioteca',
                'Archivio documentale clienti' => 'Archivo documental de clientes',
                'Elenco utenti' => 'Lista de usuarios',
                'Audit stream' => 'Flujo de auditoria',
                'Storico completo degli eventi' => 'Historial completo de eventos',
                'Permission matrix' => 'Matriz de permisos',
                'Salva matrice' => 'Guardar matriz',
                'Torna agli utenti' => 'Volver a usuarios',
                'Nuovo documento' => 'Nuevo documento',
                'Nuovo cliente' => 'Nuevo cliente',
                'Nuovo utente' => 'Nuevo usuario',
                'Nuovo ticket' => 'Nuevo ticket',
                'Apri documents board' => 'Abrir board de documentos',
                'Apri board kanban' => 'Abrir tablero kanban',
                'Apri backlog' => 'Abrir backlog',
                'Torna ai reports' => 'Volver a informes',
                'Torna alla dashboard' => 'Volver al panel',
                'Torna ai ticket' => 'Volver a los tickets',
                'Torna ai clienti' => 'Volver a los clientes',
                'Torna alla lista' => 'Volver a la lista',
                'Archivio clienti piu ordinato e leggibile' => 'Archivo de clientes mas ordenado y legible',
                'Nessun documento disponibile.' => 'No hay documentos disponibles.',
                'Nessun ticket disponibile.' => 'No hay tickets disponibles.',
                'Nessun utente trovato.' => 'No se encontraron usuarios.',
                'Nessun evento audit trovato.' => 'No se encontraron eventos de auditoria.',
                'Nessuna azione registrata per questo filtro.' => 'No hay acciones registradas para este filtro.',
                'Nessuna entità registrata per questo filtro.' => 'No hay entidades registradas para este filtro.',
                'Nessuna attivita recente.' => 'No hay actividad reciente.',
                'Nessun allegato disponibile.' => 'No hay adjuntos disponibles.',
                'Nessun commento ancora.' => 'Todavia no hay comentarios.',
                'Nuovo commento' => 'Nuevo comentario',
                'Stato attuale' => 'Estado actual',
                'Salva stato' => 'Guardar estado',
                'Salva assegnazione' => 'Guardar asignacion',
                'Salva profilo' => 'Guardar perfil',
                'Salva impostazioni' => 'Guardar ajustes',
                'Salva notifiche' => 'Guardar notificaciones',
                'Ticket totali' => 'Tickets totales',
                'Gestione Utenti' => 'Gestion de usuarios',
                'Utenti visibili' => 'Usuarios visibles',
                'Clienti' => 'Clientes',
                'Nome file' => 'Nombre del archivo',
                'Telefono non disponibile' => 'Telefono no disponible',
                'Password attuale' => 'Contrasena actual',
                'è obbligatorio' => 'es obligatorio',
                'deve essere almeno' => 'debe tener al menos',
                'caratteri' => 'caracteres',
                'Vista documentale orientata ai tipi di contenuto' => 'Vista documental orientada a los tipos de contenido',
                'Vista tabellare' => 'Vista tabular',
                'Archivio condiviso' => 'Archivo compartido',
                'Nessun documento in questa colonna.' => 'No hay documentos en esta columna.',
                'Gestisci ticket' => 'Gestionar tickets',
                'Apri documenti' => 'Abrir documentos',
                'Trend operativo' => 'Tendencia operativa',
                'Archivio' => 'Archivo',
                'Documenti disponibili al download' => 'Documentos disponibles para descargar',
                'Archivio documentale disponibile per i clienti.' => 'Archivo documental disponible para los clientes.',
                'Archivio documenti ancora vuoto.' => 'El archivo documental todavia esta vacio.',
                'Base clienti attiva pronta per le operazioni.' => 'Base de clientes activa y lista para operar.',
                'Nessun cliente attivo rilevato.' => 'No se detectaron clientes activos.',
                'Nessuna notifica da mostrare.' => 'No hay notificaciones para mostrar.',
                'Apri board completa' => 'Abrir tablero completo',
                'Nessun ticket' => 'No hay tickets',
                'Nessun ticket recente da mostrare.' => 'No hay tickets recientes para mostrar.',
                'Apri archivio' => 'Abrir archivo',
                'Nessun documento caricato di recente.' => 'No hay documentos cargados recientemente.',
                'Report operativi per capire carico, clienti e flussi' => 'Informes operativos para entender carga, clientes y flujos',
                'Documenti 30 giorni' => 'Documentos 30 dias',
                'Nessun dato disponibile sulla distribuzione ticket.' => 'No hay datos disponibles sobre la distribucion de tickets.',
                'Nessuna categoria ancora disponibile.' => 'Todavia no hay categorias disponibles.',
                'Apri customers' => 'Abrir clientes',
                'Nessun cliente disponibile per l analisi.' => 'No hay clientes disponibles para el analisis.',
                'Nessuna attivita recente disponibile.' => 'No hay actividad reciente disponible.',
                'Aggiungi un documento pronto per l\'archivio clienti' => 'Anade un documento listo para el archivo de clientes',
                'Torna ai documenti' => 'Volver a los documentos',
                'Annulla' => 'Cancelar',
                'Aggiungi commento' => 'Anadir comentario',
                'Dettaglio Ticket #' => 'Detalle Ticket #',
                'Il mio profilo' => 'Mi perfil',
                'Modifica cliente' => 'Editar cliente',
                'Nessuna attivita recente per questo cliente.' => 'No hay actividad reciente para este cliente.',
                'Request form' => 'Formulario de solicitud',
                'Invia richiesta' => 'Enviar solicitud',
                'Crea un nuovo utente pronto all\'uso' => 'Crear un nuevo usuario listo para usar',
                'Aggiorna dati, ruolo e stato account' => 'Actualizar datos, rol y estado de la cuenta',
                'Modifica Utente' => 'Editar usuario',
                'Nuovo Utente' => 'Nuevo usuario',
                '403 - Accesso negato' => '403 - Acceso denegado',
                '404 - Pagina non trovata' => '404 - Pagina no encontrada',
                'Apri ticket' => 'Abrir tickets',
                'Cerca nel workspace' => 'Buscar en el workspace',
                'Nessun risultato trovato per "' => 'No se encontraron resultados para "',
                'Nessun ticket in questa ricerca.' => 'No hay tickets en esta busqueda.',
                'Nessun documento in questa ricerca.' => 'No hay documentos en esta busqueda.',
                'Nessun cliente in questa ricerca.' => 'No hay clientes en esta busqueda.',
                'Configura CoreSuite Lite in pochi passaggi' => 'Configura CoreSuite Lite en pocos pasos',
                'Installazione' => 'Instalacion',
                'Nome database' => 'Nombre de la base de datos',
                'Utente' => 'Usuario',
                'Amministratore' => 'Administrador',
                'Installa CoreSuite Lite' => 'Instalar CoreSuite Lite',
                'Accesso negato' => 'Acceso denegado',
                'Non hai i permessi necessari per visualizzare questa pagina o eseguire questa azione.' => 'No tienes los permisos necesarios para ver esta pagina o realizar esta accion.',
                'Pagina non trovata' => 'Pagina no encontrada',
                'Apri una richiesta ben contestualizzata' => 'Abre una solicitud bien contextualizada',
                'Aggiungi materiali utili' => 'Anade material util',
                'Descrizione opzionale' => 'Descripcion opcional',
                'Allega file opzionale' => 'Adjuntar archivo opcional',
                'Persone, ruoli e stato account in un\'unica vista' => 'Personas, roles y estado de la cuenta en una sola vista',
                'Vista clienti orientata a operazioni, storico e materiali' => 'Vista de clientes orientada a operaciones, historial y materiales',
                'Trova velocemente ticket, documenti e clienti' => 'Encuentra rapidamente tickets, documentos y clientes',
                'Gestisci il tuo account e tieni traccia delle attivita recenti' => 'Gestiona tu cuenta y sigue la actividad reciente',
                'Personalizza identita, shell e moduli visibili della suite' => 'Personaliza la identidad, la shell y los modulos visibles de la suite',
                'Decidi cosa segnalare, dove e con quale intensita' => 'Decide que notificar, donde y con que intensidad',
                'Light' => 'Claro',
                'Dark' => 'Oscuro',
                'System' => 'Sistema',
                'Italiano' => 'Italiano',
                'English' => 'Ingles',
                'Francais' => 'Frances',
                'Espanol' => 'Espanol',
            ],
        ];

        return $dictionaries[$locale] ?? [];
    }
}
