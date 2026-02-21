<?php use Core\Auth; ?>
<!-- app/Views/partials/topbar.php -->
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isActivePath = function ($path, $prefix = false) use ($currentPath) {
    if ($prefix) {
        return strpos($currentPath, $path) === 0;
    }
    return $currentPath === $path;
};

$currentUser = null;
$isAdmin = false;
try {
    $currentUser = Auth::user();
    $isAdmin = Auth::isAdmin();
} catch (\Throwable $e) {
    $currentUser = null;
    $isAdmin = false;
}

$isCustomer = false;
try {
    $isCustomer = Auth::isCustomer();
} catch (\Throwable $e) {
    $isCustomer = false;
}

$displayName = $currentUser['name'] ?? 'Utente';
?>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="/dashboard">
            <strong>CoreSuite Lite</strong>
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenuUser">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarMenuUser" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item <?php echo $isActivePath('/dashboard') ? 'is-active' : ''; ?>" href="/dashboard">
                <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                <span>Dashboard</span>
            </a>

            <?php if ($isAdmin): ?>
            <a class="navbar-item <?php echo $isActivePath('/admin/users', true) ? 'is-active' : ''; ?>" href="/admin/users">
                <span class="icon"><i class="fas fa-users"></i></span>
                <span>Gestione Utenti</span>
            </a>
            <a class="navbar-item <?php echo $isActivePath('/documents/upload') ? 'is-active' : ''; ?>" href="/documents/upload">
                <span class="icon"><i class="fas fa-upload"></i></span>
                <span>Carica Documento</span>
            </a>
            <?php endif; ?>

            <a class="navbar-item <?php echo $isActivePath('/tickets', true) ? 'is-active' : ''; ?>" href="/tickets">
                <span class="icon"><i class="fas fa-ticket-alt"></i></span>
                <span>Le mie richieste</span>
            </a>
            <?php if ($isCustomer): ?>
            <a class="navbar-item <?php echo $isActivePath('/tickets/create') ? 'is-active' : ''; ?>" href="/tickets/create">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Nuova richiesta</span>
            </a>
            <?php endif; ?>

            <a class="navbar-item <?php echo ($isActivePath('/documents', true) && !$isActivePath('/documents/upload')) ? 'is-active' : ''; ?>" href="/documents">
                <span class="icon"><i class="fas fa-file"></i></span>
                <span>I miei documenti</span>
            </a>

            <a class="navbar-item <?php echo $isActivePath('/profile') ? 'is-active' : ''; ?>" href="/profile">
                <span class="icon"><i class="fas fa-user-cog"></i></span>
                <span>Profilo</span>
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="dropdown is-right is-hoverable" id="themeDropdown">
                    <div class="dropdown-trigger">
                        <button class="theme-toggle-btn" aria-haspopup="true" aria-controls="theme-menu" id="themeToggleBtn" title="Tema">
                            <span class="icon" id="themeIcon">
                                <i class="fas fa-sun"></i>
                            </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="theme-menu" role="menu">
                        <div class="dropdown-content">
                            <a href="#" class="dropdown-item" data-theme="light">
                                <span class="icon"><i class="fas fa-sun"></i></span> Light
                            </a>
                            <a href="#" class="dropdown-item" data-theme="dark">
                                <span class="icon"><i class="fas fa-moon"></i></span> Dark
                            </a>
                            <a href="#" class="dropdown-item" data-theme="system">
                                <span class="icon"><i class="fas fa-desktop"></i></span> System
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <span class="icon"><i class="fas fa-user"></i></span>
                    <?php echo htmlspecialchars($displayName); ?>
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="/profile">
                        Area personale
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="/logout">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>