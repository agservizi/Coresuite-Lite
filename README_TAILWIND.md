Installazione Tailwind (full integration)
---------------------------------------

Prerequisiti: Node.js >= 16 e npm

Comandi utili:

1. Installa dipendenze

```bash
npm install
```

2. Compila il CSS per produzione

```bash
npm run build:css
```

3. Durante lo sviluppo puoi guardare le modifiche

```bash
npm run watch:css
```

Note:
- `public/assets/css/tailwind.css` sarà generato dal comando di build e incluso in `app/Views/layout.php`.
- Manteniamo `public/assets/css/theme.css` per le variabili e override locali; dopo la migrazione delle classi potremo rimuoverlo o ridurlo.
