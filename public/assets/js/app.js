// public/assets/js/app.js

// Toggle sidebar su mobile e collapse desktop
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar collapse/collapse mobile logic
    const sidebar = document.getElementById('sidebar');
    const collapseBtn = document.getElementById('sidebarCollapseBtn');
    const overlay = document.querySelector('.sidebar-overlay');
    const COLLAPSE_KEY = 'coresuite_sidebar_collapsed';

    function setSidebarCollapsed(collapsed) {
        if (collapsed) {
            sidebar.classList.add('collapsed');
            if (collapseBtn) {
                collapseBtn.querySelector('i').classList.add('fa-bars-staggered');
                collapseBtn.querySelector('i').classList.remove('fa-bars');
            }
            console.log('[Sidebar] Collassata (desktop)');
        } else {
            sidebar.classList.remove('collapsed');
            if (collapseBtn) {
                collapseBtn.querySelector('i').classList.remove('fa-bars-staggered');
                collapseBtn.querySelector('i').classList.add('fa-bars');
            }
            console.log('[Sidebar] Espansa (desktop)');
        }
        localStorage.setItem(COLLAPSE_KEY, collapsed ? '1' : '0');
    }

    // Collapse/expand desktop e mobile, anche su resize
    function syncSidebarState() {
        if (!sidebar) return;
        if (window.innerWidth > 768) {
            // Desktop: chiudi overlay, ripristina collapse
            sidebar.classList.remove('is-active');
            if (overlay) overlay.classList.remove('is-active');
            const collapsed = localStorage.getItem(COLLAPSE_KEY) === '1';
            setSidebarCollapsed(collapsed);
        } else {
            // Mobile: sidebar sempre espansa, no collapse
            sidebar.classList.remove('collapsed');
            // (overlay e is-active gestiti dal click)
        }
    }

    if (collapseBtn && sidebar) {
        collapseBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (window.innerWidth <= 768) {
                const wasActive = sidebar.classList.contains('is-active');
                sidebar.classList.toggle('is-active');
                if (overlay) overlay.classList.toggle('is-active');
                if (!wasActive && sidebar.classList.contains('is-active')) {
                    console.log('[Sidebar] Aperta (mobile overlay)');
                } else if (wasActive && !sidebar.classList.contains('is-active')) {
                    console.log('[Sidebar] Chiusa (mobile overlay)');
                }
            } else {
                const collapsed = !sidebar.classList.contains('collapsed');
                setSidebarCollapsed(collapsed);
            }
        });
        // All'avvio: sincronizza stato
        syncSidebarState();
        // Aggiorna su resize
        window.addEventListener('resize', syncSidebarState);
    }

    // Overlay click chiude sidebar mobile
    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('is-active');
            overlay.classList.remove('is-active');
        });
    }

    // Chiudi sidebar mobile con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('is-active')) {
            sidebar.classList.remove('is-active');
            if (overlay) overlay.classList.remove('is-active');
        }
    });
    const THEME_STORAGE_KEY = 'coresuite_theme_mode';
    const themeDropdown = document.getElementById('themeDropdown');
    const themeIcon = document.getElementById('themeIcon');
    const themeBtn = document.getElementById('themeToggleBtn');
    const themeItems = themeDropdown ? themeDropdown.querySelectorAll('.dropdown-item[data-theme]') : [];

    function setThemeIcon(theme) {
        if (!themeIcon) return;
        themeIcon.innerHTML = '';
        if (theme === 'dark') themeIcon.innerHTML = '<i class="fas fa-moon"></i>';
        else if (theme === 'system') themeIcon.innerHTML = '<i class="fas fa-desktop"></i>';
        else themeIcon.innerHTML = '<i class="fas fa-sun"></i>';
    }

    function applyTheme(theme) {
        setThemeIcon(theme);
        if (theme === 'system') {
            document.documentElement.removeAttribute('data-theme');
            localStorage.removeItem('theme');
        } else {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
    }

    // Load theme on page load
    let theme = localStorage.getItem('theme') || 'system';
    applyTheme(theme);

    themeItems.forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const selected = this.getAttribute('data-theme');
            applyTheme(selected);
        });
    });
});

// Chart.js init
if (window._chartValues && window._chartLabels && document.getElementById('dashboardChart')) {
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: window._chartLabels,
            datasets: [{
                label: 'Ticket ultimi 30 giorni',
                data: window._chartValues,
                borderColor: '#3273dc',
                backgroundColor: 'rgba(50,115,220,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                x: { title: { display: true, text: 'Data' } },
                y: { title: { display: true, text: 'Ticket' }, beginAtZero: true }
            }
        }
    });

    const applyThemeMode = function(mode) {
        const selectedMode = mode || 'light';
        const effectiveTheme = selectedMode === 'system'
            ? (systemThemeMatcher.matches ? 'dark' : 'light')
            : selectedMode;

        document.documentElement.setAttribute('data-theme-mode', selectedMode);
        document.documentElement.setAttribute('data-theme', effectiveTheme);
    };

    const savedThemeMode = localStorage.getItem(THEME_STORAGE_KEY) || 'light';
    applyThemeMode(savedThemeMode);

    if (themeModeToggle) {
        themeModeToggle.value = savedThemeMode;
        themeModeToggle.addEventListener('change', function(e) {
            const nextMode = e.target.value || 'light';
            localStorage.setItem(THEME_STORAGE_KEY, nextMode);
            applyThemeMode(nextMode);
        });
    }

    systemThemeMatcher.addEventListener('change', function() {
        const currentMode = localStorage.getItem(THEME_STORAGE_KEY) || 'light';
        if (currentMode === 'system') {
            applyThemeMode('system');
        }
    });

    // Navbar burger
    const navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    navbarBurgers.forEach(function(el) {
        el.addEventListener('click', function() {
            const target = el.dataset.target;
            const $target = document.getElementById(target);
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
        });
    });

    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        const toggleBtn = document.querySelector('.navbar-burger');
        const overlay = document.querySelector('.sidebar-overlay');

        const closeSidebar = function() {
            sidebar.classList.remove('is-active');
            if (toggleBtn) {
                toggleBtn.classList.remove('is-active');
            }
            if (overlay) {
                overlay.classList.remove('is-active');
            }
        };

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('is-active');
                if (overlay) {
                    overlay.classList.toggle('is-active');
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
    }

    // Dropdown toggle
    const dropdowns = Array.prototype.slice.call(document.querySelectorAll('.has-dropdown'), 0);
    dropdowns.forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.stopPropagation();
            el.classList.toggle('is-active');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        dropdowns.forEach(function(el) {
            el.classList.remove('is-active');
        });
    });

    // Modals
    const modals = Array.prototype.slice.call(document.querySelectorAll('.modal'), 0);
    modals.forEach(function(modal) {
        const closeBtn = modal.querySelector('.delete');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.classList.remove('is-active');
            });
        }

        const cancelBtn = modal.querySelector('.button:not(.is-danger)');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                modal.classList.remove('is-active');
            });
        }
    });

    // Flash messages dismiss
    const flashDismiss = Array.prototype.slice.call(document.querySelectorAll('.flash-dismiss'), 0);
    flashDismiss.forEach(function(btn) {
        btn.addEventListener('click', function() {
            btn.parentElement.style.display = 'none';
        });
    });

    // Mini chart per dashboard
    const canvas = document.getElementById('ticketChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        // Dati dinamici dal server
        const data = window._chartValues || [];
        const labels = window._chartLabels || [];
        if (data.length === 0) {
            ctx.fillStyle = '#999';
            ctx.font = '14px sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('Nessun dato disponibile', canvas.width / 2, canvas.height / 2);
        } else {
            const max = Math.max(...data, 1);
            const width = canvas.width;
            const height = canvas.height;
            const padding = 30;
            const barWidth = (width - padding) / data.length;

            ctx.fillStyle = '#3273dc';
            data.forEach((value, index) => {
                const barHeight = (value / max) * (height - padding - 10);
                ctx.fillRect(padding + index * barWidth, height - padding - barHeight, barWidth - 2, barHeight);
            });

            // Etichette asse X (ogni 5 giorni)
            ctx.fillStyle = '#666';
            ctx.font = '10px sans-serif';
            ctx.textAlign = 'center';
            labels.forEach((label, index) => {
                if (index % 5 === 0 || index === labels.length - 1) {
                    ctx.fillText(label, padding + index * barWidth + barWidth / 2, height - 5);
                }
            });

            // Asse Y
            ctx.strokeStyle = '#ddd';
            ctx.beginPath();
            ctx.moveTo(padding, 0);
            ctx.lineTo(padding, height - padding);
            ctx.lineTo(width, height - padding);
            ctx.stroke();

            // Etichette asse Y
            ctx.fillStyle = '#666';
            ctx.textAlign = 'right';
                for (let i = 0; i <= 4; i++) {
                    const val = Math.round((max / 4) * i);
                    const y = height - padding - (val / max) * (height - padding - 10);
                ctx.fillText(val.toString(), padding - 5, y + 4);
            }
        }
    }
};