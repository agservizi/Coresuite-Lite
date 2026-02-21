<?php use Core\Auth; ?>
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

<nav class="w-full bg-[var(--bg-secondary)] border-b" role="navigation" aria-label="main navigation">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center justify-between h-[var(--topbar-height)]">
            <div class="flex items-center gap-4">
                <a href="/dashboard" class="text-lg font-semibold text-[var(--text-primary)]">CoreSuite Lite</a>
                <div class="hidden md:flex items-center gap-2">
                    <a href="/dashboard" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo $isActivePath('/dashboard') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>

                    <?php if ($isAdmin): ?>
                    <a href="/admin/users" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo $isActivePath('/admin/users', true) ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-users mr-2"></i>Gestione Utenti
                    </a>
                    <a href="/documents/upload" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo $isActivePath('/documents/upload') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-upload mr-2"></i>Carica Documento
                    </a>
                    <?php endif; ?>

                    <a href="/tickets" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo $isActivePath('/tickets', true) ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-ticket-alt mr-2"></i>Le mie richieste
                    </a>
                    <?php if ($isCustomer): ?>
                    <a href="/tickets/create" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo $isActivePath('/tickets/create') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-plus mr-2"></i>Nuova richiesta
                    </a>
                    <?php endif; ?>

                    <a href="/documents" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo ($isActivePath('/documents', true) && !$isActivePath('/documents/upload')) ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-file mr-2"></i>I miei documenti
                    </a>

                    <a href="/profile" class="px-3 py-2 rounded hover:bg-gray-100 <?php echo $isActivePath('/profile') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-user-cog mr-2"></i>Profilo
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2">
                    <div class="relative">
                        <button id="themeToggleBtn" class="theme-toggle-btn" title="Tema">
                            <span class="icon" id="themeIcon"><i class="fas fa-sun"></i></span>
                            <span class="ml-2 hidden sm:inline">Tema</span>
                        </button>
                        <div id="themeMenu" class="absolute right-0 mt-2 w-36 bg-[var(--bg-secondary)] border rounded shadow-sm hidden">
                            <a href="#" data-theme="light" class="block px-3 py-2 text-sm">Light</a>
                            <a href="#" data-theme="dark" class="block px-3 py-2 text-sm">Dark</a>
                            <a href="#" data-theme="system" class="block px-3 py-2 text-sm">System</a>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="userMenuBtn" class="px-3 py-2 rounded hover:bg-gray-100 flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars($displayName); ?></span>
                        </button>
                        <div id="userMenu" class="absolute right-0 mt-2 w-40 bg-[var(--bg-secondary)] border rounded shadow-sm hidden">
                            <a href="/profile" class="block px-3 py-2 text-sm">Area personale</a>
                            <div class="border-t"></div>
                            <a href="/logout" class="block px-3 py-2 text-sm">Logout</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button id="mobileMenuBtn" class="md:hidden px-3 py-2 rounded focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile stacked menu -->
    <div id="mobileMenu" class="md:hidden hidden border-t bg-[var(--bg-secondary)]">
        <div class="px-4 py-3 flex flex-col">
            <a href="/dashboard" class="py-2 <?php echo $isActivePath('/dashboard') ? 'font-semibold' : ''; ?>">Dashboard</a>
            <?php if ($isAdmin): ?>
            <a href="/admin/users" class="py-2 <?php echo $isActivePath('/admin/users', true) ? 'font-semibold' : ''; ?>">Gestione Utenti</a>
            <a href="/documents/upload" class="py-2 <?php echo $isActivePath('/documents/upload') ? 'font-semibold' : ''; ?>">Carica Documento</a>
            <?php endif; ?>
            <a href="/tickets" class="py-2 <?php echo $isActivePath('/tickets', true) ? 'font-semibold' : ''; ?>">Le mie richieste</a>
            <?php if ($isCustomer): ?>
            <a href="/tickets/create" class="py-2 <?php echo $isActivePath('/tickets/create') ? 'font-semibold' : ''; ?>">Nuova richiesta</a>
            <?php endif; ?>
            <a href="/documents" class="py-2 <?php echo ($isActivePath('/documents', true) && !$isActivePath('/documents/upload')) ? 'font-semibold' : ''; ?>">I miei documenti</a>
            <a href="/profile" class="py-2 <?php echo $isActivePath('/profile') ? 'font-semibold' : ''; ?>">Profilo</a>
        </div>
    </div>

    <script>
        // minimal menu toggles (no external dependency)
        (function(){
            var mobileBtn = document.getElementById('mobileMenuBtn');
            var mobileMenu = document.getElementById('mobileMenu');
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', function(){ mobileMenu.classList.toggle('hidden'); });
            }

            var userBtn = document.getElementById('userMenuBtn');
            var userMenu = document.getElementById('userMenu');
            if (userBtn && userMenu) {
                userBtn.addEventListener('click', function(e){ e.preventDefault(); userMenu.classList.toggle('hidden'); });
            }

            var themeBtn = document.getElementById('themeToggleBtn');
            var themeMenu = document.getElementById('themeMenu');
            if (themeBtn && themeMenu) {
                themeBtn.addEventListener('click', function(e){ e.preventDefault(); themeMenu.classList.toggle('hidden'); });
                themeMenu.addEventListener('click', function(e){
                    var t = e.target.closest('[data-theme]');
                    if (t) {
                        var theme = t.getAttribute('data-theme');
                        if (theme === 'system') { document.documentElement.removeAttribute('data-theme'); }
                        else { document.documentElement.setAttribute('data-theme', theme); }
                        themeMenu.classList.add('hidden');
                    }
                });
            }
        })();
    </script>
</nav>