# UI Guide

## Current UI Stack

- CSS framework: Bootstrap 5 in `public/assets/css/bootstrap.css`
- Custom theme: `public/assets/css/theme.css`
- Charts: local chart assets in `public/assets/js/`
- UI behavior: `public/assets/js/app.js`

## Layout Architecture

- `app/Views/layout.php`: main admin shell
- `app/Views/partials/topbar.php`: top navigation and actions
- `app/Views/partials/sidebar.php`: primary navigation
- `app/Views/partials/flash.php`: app-level alerts
- `app/Views/partials/footer.php`: global footer

## Core Design Tokens

Main variables live in `:root` and `[data-theme="dark"]` inside `theme.css`.

- surfaces: `--bg-app`, `--bg-surface`, `--bg-soft`
- text: `--text-main`, `--text-muted`
- brand: `--accent`, `--accent-strong`
- borders and shadows: `--border`, `--shadow-sm`, `--shadow-md`
- shell sizing: `--topbar-height`, `--sidebar-width`

## Recommended Patterns

- list pages: toolbar card plus clean table layout
- forms: card containers, `row g-3`, Bootstrap controls, and helper text where needed
- dashboard metrics: `admin-kpi-*` classes
- primary actions: `btn btn-primary`
- secondary actions: `btn btn-outline-secondary`

## Copy Guidelines

- prefer explicit action labels
- avoid vague CTA labels when multiple actions are present
- keep equivalent pages consistent in wording and hierarchy

## Responsive Behavior

- desktop: visible sidebar with collapsible behavior
- tablet/mobile: overlay sidebar and stacked content
- main switch point: `992px`

## Minimum Accessibility Expectations

- every input should keep a visible label
- buttons should use descriptive text
- focus states should remain visible
- state should not rely on color alone

## Avoid

- large inline styles when reusable theme classes already exist
- introducing a parallel design language without updating `theme.css`
- mixing unrelated utility systems inside application views
