// public/assets/js/app.js
// Simplified app script: theme handling and safe chart init only

document.addEventListener('DOMContentLoaded', function () {
    // Theme handling (minimal, safe guards)
    const themeDropdown = document.getElementById('themeDropdown');
    const themeIcon = document.getElementById('themeIcon');
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

    // Load theme
    try {
        let theme = localStorage.getItem('theme') || 'system';
        applyTheme(theme);
    } catch (e) {
        console.warn('[App] Theme load error', e);
    }

    // Theme selection
    if (themeItems && themeItems.forEach) {
        themeItems.forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const selected = this.getAttribute('data-theme');
                applyTheme(selected);
            });
        });
    }

    // Safe Chart init
    try {
        if (typeof Chart !== 'undefined' && window._chartValues && window._chartLabels && document.getElementById('dashboardChart')) {
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
                options: { responsive: true }
            });
        }
    } catch (e) {
        console.warn('[App] Chart/init error', e);
    }

});
