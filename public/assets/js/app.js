// public/assets/js/app.js

// Toggle sidebar su mobile
document.addEventListener('DOMContentLoaded', function() {
    const THEME_STORAGE_KEY = 'coresuite_theme_mode';
    const themeModeToggle = document.getElementById('themeModeToggle');
    const systemThemeMatcher = window.matchMedia('(prefers-color-scheme: dark)');

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
        // Dati finti per demo
        const data = [5, 8, 12, 7, 15, 10, 9, 14, 11, 6, 13, 8, 16, 12, 9, 11, 7, 14, 10, 13, 8, 15, 12, 9, 11, 7, 14, 10, 13, 8];
        const max = Math.max(...data);
        const width = canvas.width;
        const height = canvas.height;
        const barWidth = width / data.length;

        ctx.fillStyle = '#3273dc';
        data.forEach((value, index) => {
            const barHeight = (value / max) * (height - 20);
            ctx.fillRect(index * barWidth, height - barHeight, barWidth - 2, barHeight);
        });

        // Assi
        ctx.strokeStyle = '#cccccc';
        ctx.beginPath();
        ctx.moveTo(0, height);
        ctx.lineTo(width, height);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(0, height);
        ctx.stroke();
    }
});