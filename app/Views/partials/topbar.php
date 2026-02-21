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

<style>
/* Admin UI enhancements (scoped to topbar) */
:root { --admin-accent: #06b6d4; --admin-bg-1: #081226; --admin-bg-2: #0b1724; --admin-contrast: #e6f6f9; }
nav[aria-label="main navigation"] { background: linear-gradient(90deg,var(--admin-bg-1),var(--admin-bg-2)); color:var(--admin-contrast); box-shadow: 0 6px 18px rgba(2,6,23,0.6); }
nav[aria-label="main navigation"] a { color: var(--admin-contrast); }
nav[aria-label="main navigation"] .inline-flex.items-center > i { color: var(--admin-accent); min-width:18px; display:inline-block; text-align:center; }
#userMenuBtn { border:1px solid rgba(255,255,255,0.06); padding:6px 10px; border-radius:9999px; background:rgba(255,255,255,0.02); }
#userMenuBtn i { background: rgba(255,255,255,0.04); padding:6px; border-radius:50%; }
.theme-toggle-btn i { color: var(--admin-accent); }
a.inline-flex.items-center:hover { background: rgba(255,255,255,0.03); }
/* Prevent wrapping of menu items */
nav .whitespace-nowrap { white-space: nowrap; }
@media (max-width: 768px) { nav .hidden.md\:flex { display:none !important; } }
</style>

<nav class="w-full bg-[var(--bg-secondary)] border-b z-50" role="navigation" aria-label="main navigation">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center h-[var(--topbar-height)]">
            <!-- Left: Brand -->
            <div class="flex items-center flex-none">
                <a href="/dashboard" class="text-lg font-semibold text-[var(--text-primary)] whitespace-nowrap inline-flex items-center gap-2">
                    <i class="fas fa-layer-group"></i>
                    <span>CoreSuite Lite</span>
                </a>
            </div>

            <!-- Center: Menu -->
            <div class="flex-1 flex justify-center">
                <div class="hidden md:flex items-center gap-4 whitespace-nowrap">
                    <a href="/dashboard" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo $isActivePath('/dashboard') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                    </a>

                    <?php if ($isAdmin): ?>
                    <a href="/admin/users" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo $isActivePath('/admin/users', true) ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-users"></i><span>Gestione Utenti</span>
                    </a>
                    <a href="/documents/upload" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo $isActivePath('/documents/upload') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-upload"></i><span>Carica Documento</span>
                    </a>
                    <?php endif; ?>

                    <a href="/tickets" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo $isActivePath('/tickets', true) ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-ticket-alt"></i><span>Le mie richieste</span>
                    </a>
                    <?php if ($isCustomer): ?>
                    <a href="/tickets/create" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo $isActivePath('/tickets/create') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-plus"></i><span>Nuova richiesta</span>
                    </a>
                    <?php endif; ?>

                    <a href="/documents" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo ($isActivePath('/documents', true) && !$isActivePath('/documents/upload')) ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-file"></i><span>I miei documenti</span>
                    </a>

                    <a href="/profile" class="inline-flex items-center gap-2 px-3 py-2 rounded <?php echo $isActivePath('/profile') ? 'font-semibold' : ''; ?>">
                        <i class="fas fa-user-cog"></i><span>Profilo</span>
                    </a>
                </div>
            </div>

            <!-- Right: Theme + User -->
            <div class="flex items-center gap-3 flex-none">
                <div class="relative">
                    <button id="themeToggleBtn" class="theme-toggle-btn inline-flex items-center gap-2" title="Tema">
                        <i class="fas fa-sun"></i>
                        <span class="hidden sm:inline">Tema</span>
                    </button>
                    <div id="themeMenu" class="absolute right-0 mt-2 w-36 bg-[var(--bg-secondary)] border rounded shadow-sm hidden">
                        <a href="#" data-theme="light" class="block px-3 py-2 text-sm">Light</a>
                        <a href="#" data-theme="dark" class="block px-3 py-2 text-sm">Dark</a>
                        <a href="#" data-theme="system" class="block px-3 py-2 text-sm">System</a>
                    </div>
                </div>

                <div class="relative">
                    <button id="userMenuBtn" class="px-3 py-2 rounded hover:bg-gray-100 inline-flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-user"></i>
                        <span><?php echo htmlspecialchars($displayName); ?></span>
                    </button>
                    <div id="userMenu" class="absolute right-0 mt-2 w-40 bg-[var(--bg-secondary)] border rounded shadow-sm hidden">
                        <a href="/profile" class="block px-3 py-2 text-sm">Area personale</a>
                        <div class="border-t"></div>
                        <a href="/logout" class="block px-3 py-2 text-sm">Logout</a>
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