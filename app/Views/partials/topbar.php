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
        <div class="navbar-end">
            <div class="navbar-item">
                    <div class="dropdown is-right is-hoverable" id="themeDropdown">
                        <div class="dropdown-trigger">
                            <button class="button is-small" aria-haspopup="true" aria-controls="theme-menu" id="themeToggleBtn" title="Tema">
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