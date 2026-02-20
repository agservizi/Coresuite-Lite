# Ruoli e Permessi

## Ruoli Disponibili

### Admin
**Permessi Completi**
- Gestione utenti (CRUD)
- Caricamento documenti
- Visualizzazione tutti ticket/documenti
- Modifica stati ticket
- Accesso audit logs
- Configurazione sistema

### Operator
**Permessi Supporto**
- Visualizzazione ticket assegnati/non assegnati
- Modifica stati ticket
- Aggiunta commenti (pubblici e interni)
- Assegnazione ticket
- Download documenti clienti
- Visualizzazione commenti interni

### Customer
**Permessi Clienti**
- Creazione ticket
- Visualizzazione propri ticket
- Aggiunta commenti pubblici
- Download propri documenti
- Modifica profilo personale

## Matrice Permessi

| Funzione | Admin | Operator | Customer |
|----------|-------|----------|----------|
| Login | ✓ | ✓ | ✓ |
| Dashboard | ✓ | ✓ | ✓ |
| Profilo | ✓ | ✓ | ✓ |
| Lista Utenti | ✓ | ✗ | ✗ |
| CRUD Utenti | ✓ | ✗ | ✗ |
| Lista Ticket | ✓ | ✓ | Propri |
| Crea Ticket | ✓ | ✓ | ✓ |
| Modifica Ticket | ✓ | Assegnati | Propri |
| Commenti Interni | ✓ | ✓ | ✗ |
| Carica Documenti | ✓ | ✗ | ✗ |
| Download Documenti | ✓ | Tutti | Propri |
| Elimina Documenti | ✓ | ✗ | ✗ |
| Audit Logs | ✓ | ✗ | ✗ |

## Implementazione

### Controllo Ruoli in Controller
```php
if (!Auth::isAdmin()) {
    http_response_code(403);
    // Redirect o errore
}
```

### Filtri Query per Ruolo
```php
if (Auth::isCustomer()) {
    $stmt = DB::prepare("SELECT * FROM tickets WHERE customer_id = ?");
    $stmt->execute([Auth::user()['id']]);
} elseif (Auth::isOperator()) {
    $stmt = DB::prepare("SELECT * FROM tickets"); // Tutti
}
```

## Sicurezza per Ruolo

### Admin
- Accesso a dati sensibili
- Modifiche configurazione
- Eliminazione dati
- **Rischio**: Elevato - richiede 2FA raccomandata

### Operator
- Accesso commenti interni
- Modifica stati ticket
- **Rischio**: Medio - supervisione necessaria

### Customer
- Solo dati propri
- Nessun accesso admin
- **Rischio**: Basso - isolamento garantito

## Audit per Ruolo

Tutti i ruoli loggano azioni critiche:
- Login/Logout
- Modifiche dati
- Upload/Delete file
- Cambi stato ticket

## Estensioni Future

### Ruoli Personalizzati
- Definizione ruoli via DB
- Permessi granulari per funzione
- Gruppi utenti

### Approvazioni
- Workflow multi-step
- Escalation automatica
- Notifiche per approvazioni

### Multi-Tenant
- Isolamento per organizzazione
- Branding per tenant
- Configurazioni separate