# Guida UI - CoreSuite Lite

## Tema Scuro Bulma

Il tema utilizza Bulma con override CSS personalizzati per un look moderno e scuro.

### Variabili CSS

```css
:root {
    --bg-primary: #1a1a1a;      /* Sfondo principale */
    --bg-secondary: #2a2a2a;    /* Sidebar, header */
    --bg-card: #333333;         /* Card, modali */
    --text-primary: #ffffff;    /* Testo principale */
    --text-secondary: #cccccc;  /* Testo secondario */
    --border-color: #444444;    /* Bordi */
    --primary-color: #3273dc;   /* Bulma primary */
    --success-color: #48c774;   /* Success */
    --warning-color: #ffdd57;   /* Warning */
    --danger-color: #f14668;    /* Danger */
    --info-color: #3298dc;      /* Info */
}
```

## Layout Admin

### Struttura
- **Topbar**: Logo, navigazione, user menu
- **Sidebar**: Menu laterale collassabile
- **Content**: Area principale con breadcrumb e contenuto

### Componenti Bulma Utilizzati

#### Navigazione
- `navbar` - Topbar principale
- `menu` - Sidebar menu
- `breadcrumb` - Navigazione breadcrumb

#### Contenuto
- `card` - Container per sezioni
- `columns` - Layout a colonne
- `table` - Tabelle dati
- `notification` - Messaggi flash

#### Form
- `field` + `control` + `label` - Struttura form
- `input`, `textarea`, `select` - Campi input
- `button` - Pulsanti con vari colori

#### Interazione
- `modal` - Modali per conferme
- `dropdown` - Menu dropdown
- `tag` - Badge per stati/ruoli

## Personalizzazione Tema

### Cambiare Colori
Modifica le variabili CSS in `public/assets/css/theme.css`:

```css
:root {
    --primary-color: #your-color;
    --bg-primary: #your-bg;
}
```

### Aggiungere Componenti
Usa classi Bulma esistenti o aggiungi custom CSS.

### Icone
- Font Awesome via CDN
- Aggiungi icone con `<i class="fas fa-icon-name"></i>`

## Responsive Design

- **Desktop**: Sidebar fissa, layout completo
- **Tablet**: Sidebar collassabile
- **Mobile**: Sidebar diventa drawer con overlay

## JavaScript Vanilla

### Funzionalità
- Toggle sidebar mobile
- Gestione dropdown
- Modali open/close
- Flash messages dismiss
- Mini chart canvas

### Estensioni
Aggiungi funzioni in `public/assets/js/app.js`:

```javascript
// Esempio: toggle elemento
function toggleElement(selector) {
    document.querySelector(selector).classList.toggle('is-active');
}
```

## Best Practices UI

1. **Consistenza**: Usa sempre le stesse classi Bulma
2. **Accessibilità**: Aggiungi `aria-label` su bottoni icona
3. **Feedback**: Usa `is-loading` su pulsanti durante submit
4. **Validazione**: Mostra errori con `is-danger` + `help`
5. **Stati**: Usa tag colorati per stati (success/warning/danger)

## Esempi di Pattern

### Form con Validazione
```html
<div class="field">
    <label class="label">Email</label>
    <div class="control has-icons-left has-icons-right">
        <input class="input is-danger" type="email" placeholder="Email">
        <span class="icon is-small is-left">
            <i class="fas fa-envelope"></i>
        </span>
        <span class="icon is-small is-right">
            <i class="fas fa-exclamation-triangle"></i>
        </span>
    </div>
    <p class="help is-danger">Email non valida</p>
</div>
```

### Tabella con Azioni
```html
<table class="table is-fullwidth is-hoverable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Item 1</td>
            <td>
                <div class="buttons are-small">
                    <button class="button is-info">Modifica</button>
                    <button class="button is-danger">Elimina</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
```

### Card KPI
```html
<div class="card">
    <div class="card-content">
        <div class="content">
            <p class="title is-2">123</p>
            <p class="subtitle">Totale Utenti</p>
        </div>
    </div>
</div>
```