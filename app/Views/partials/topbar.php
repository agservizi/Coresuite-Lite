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
                <div class="select is-small theme-mode-select">
                    <select id="themeModeToggle" aria-label="Seleziona tema">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="system">System</option>
                    </select>
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