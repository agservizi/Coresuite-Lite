<?php use Core\Auth; ?>
<!-- app/Views/partials/sidebar.php -->
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isActivePath = function ($path, $prefix = false) use ($currentPath) {
    if ($prefix) {
        return strpos($currentPath, $path) === 0;
    }
    return $currentPath === $path;
};

$isAdmin = false;
$isCustomer = false;
try {
    $isAdmin = Auth::isAdmin();
    $isCustomer = Auth::isCustomer();
} catch (\Throwable $e) {
    $isAdmin = false;
    $isCustomer = false;
}
?>
<aside class="sidebar" id="sidebar">
    <!-- Toggle collapse ora nella topbar -->
    <nav class="menu">
        <p class="menu-label sidebar-label">Generale</p>
        <ul class="menu-list">
            <li><a class="<?php echo $isActivePath('/dashboard') ? 'is-active' : ''; ?>" href="/dashboard"><span class="icon"><i class="fas fa-tachometer-alt"></i></span> <span class="sidebar-text">Dashboard</span></a></li>
        </ul>

        <?php if ($isAdmin): ?>
        <p class="menu-label sidebar-label">Amministrazione</p>
        <ul class="menu-list">
            <li><a class="<?php echo $isActivePath('/admin/users', true) ? 'is-active' : ''; ?>" href="/admin/users"><span class="icon"><i class="fas fa-users"></i></span> <span class="sidebar-text">Gestione Utenti</span></a></li>
            <li><a class="<?php echo $isActivePath('/documents/upload') ? 'is-active' : ''; ?>" href="/documents/upload"><span class="icon"><i class="fas fa-upload"></i></span> <span class="sidebar-text">Carica Documento</span></a></li>
        </ul>
        <?php endif; ?>

        <p class="menu-label sidebar-label">Supporto</p>
        <ul class="menu-list">
            <li><a class="<?php echo $isActivePath('/tickets', true) ? 'is-active' : ''; ?>" href="/tickets"><span class="icon"><i class="fas fa-ticket-alt"></i></span> <span class="sidebar-text">Le mie richieste</span></a></li>
            <?php if ($isCustomer): ?>
            <li><a class="<?php echo $isActivePath('/tickets/create') ? 'is-active' : ''; ?>" href="/tickets/create"><span class="icon"><i class="fas fa-plus"></i></span> <span class="sidebar-text">Nuova richiesta</span></a></li>
            <?php endif; ?>
        </ul>

        <p class="menu-label sidebar-label">Documenti</p>
        <ul class="menu-list">
            <li><a class="<?php echo $isActivePath('/documents', true) && !$isActivePath('/documents/upload') ? 'is-active' : ''; ?>" href="/documents"><span class="icon"><i class="fas fa-file"></i></span> <span class="sidebar-text">I miei documenti</span></a></li>
        </ul>

        <p class="menu-label sidebar-label">Account</p>
        <ul class="menu-list">
            <li><a class="<?php echo $isActivePath('/profile') ? 'is-active' : ''; ?>" href="/profile"><span class="icon"><i class="fas fa-user-cog"></i></span> <span class="sidebar-text">Profilo</span></a></li>
        </ul>
    </nav>
</aside>