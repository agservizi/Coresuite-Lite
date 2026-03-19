document.addEventListener('DOMContentLoaded', function () {
    var root = document.documentElement;
    var body = document.body;
    var topbar = document.querySelector('.admin-topbar');
    var workspaceDefaults = window.__workspaceDefaults || {};
    var uiTextMap = window.__uiText || {};

    var themeIcon = document.getElementById('themeIcon');
    var themeCurrentLabel = document.getElementById('themeCurrentLabel');
    var themeTargets = document.querySelectorAll('[data-theme]');
    var themeModeToggle = document.getElementById('themeModeToggle');
    var themePreference = workspaceDefaults.defaultTheme || 'system';
    var themeOverrideStorageKey = 'theme-override';
    var systemThemeGeoKey = 'coresuite_system_theme_geo';
    var systemThemeState = {
        geo: null,
        requested: false
    };

    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebarOverlay = document.getElementById('adminSidebarOverlay');
    var sidebar = document.getElementById('adminSidebar');
    var sidebarLastActiveElement = null;
    var backToTopButton = document.getElementById('backToTop');

    function uiText(key, fallback) {
        return Object.prototype.hasOwnProperty.call(uiTextMap, key) ? uiTextMap[key] : fallback;
    }

    function setThemeIcon(theme) {
        if (!themeIcon) return;
        themeIcon.className = 'fas';

        if (theme === 'dark') {
            themeIcon.classList.add('fa-moon');
            return;
        }

        if (theme === 'system') {
            themeIcon.classList.add('fa-desktop');
            return;
        }

        themeIcon.classList.add('fa-sun');
    }

    function setThemeLabel(theme) {
        if (!themeCurrentLabel) return;

        var activeTarget = document.querySelector('[data-theme="' + theme + '"][data-theme-label]');
        if (activeTarget) {
            themeCurrentLabel.textContent = activeTarget.getAttribute('data-theme-label') || theme;
            return;
        }

        themeCurrentLabel.textContent = theme;
    }

    function resolveSystemTheme() {
        var hour = new Date().getHours();
        return (hour >= 19 || hour < 7) ? 'dark' : 'light';
    }

    function getDayOfYear(date) {
        var start = new Date(date.getFullYear(), 0, 0);
        var diff = date - start;
        return Math.floor(diff / 86400000);
    }

    function normalizeDegrees(value) {
        var normalized = value % 360;
        return normalized < 0 ? normalized + 360 : normalized;
    }

    function normalizeHours(value) {
        var normalized = value % 24;
        return normalized < 0 ? normalized + 24 : normalized;
    }

    function degreesToRadians(value) {
        return value * (Math.PI / 180);
    }

    function radiansToDegrees(value) {
        return value * (180 / Math.PI);
    }

    function calculateSolarUtcMinutes(date, latitude, longitude, isSunrise) {
        var day = getDayOfYear(date);
        var lngHour = longitude / 15;
        var approxTime = day + (((isSunrise ? 6 : 18) - lngHour) / 24);
        var meanAnomaly = (0.9856 * approxTime) - 3.289;
        var trueLongitude = normalizeDegrees(
            meanAnomaly +
            (1.916 * Math.sin(degreesToRadians(meanAnomaly))) +
            (0.020 * Math.sin(degreesToRadians(2 * meanAnomaly))) +
            282.634
        );
        var rightAscension = normalizeDegrees(radiansToDegrees(Math.atan(0.91764 * Math.tan(degreesToRadians(trueLongitude)))));
        var trueLongitudeQuadrant = Math.floor(trueLongitude / 90) * 90;
        var rightAscensionQuadrant = Math.floor(rightAscension / 90) * 90;
        rightAscension = (rightAscension + (trueLongitudeQuadrant - rightAscensionQuadrant)) / 15;

        var sinDeclination = 0.39782 * Math.sin(degreesToRadians(trueLongitude));
        var cosDeclination = Math.cos(Math.asin(sinDeclination));
        var cosLocalHour =
            (Math.cos(degreesToRadians(90.833)) - (sinDeclination * Math.sin(degreesToRadians(latitude)))) /
            (cosDeclination * Math.cos(degreesToRadians(latitude)));

        if (cosLocalHour > 1 || cosLocalHour < -1) {
            return null;
        }

        var localHourAngle = isSunrise
            ? 360 - radiansToDegrees(Math.acos(cosLocalHour))
            : radiansToDegrees(Math.acos(cosLocalHour));

        localHourAngle = localHourAngle / 15;

        var localMeanTime = localHourAngle + rightAscension - (0.06571 * approxTime) - 6.622;
        var utcHours = normalizeHours(localMeanTime - lngHour);

        return Math.round(utcHours * 60);
    }

    function resolveThemeFromSolarTime(date, latitude, longitude) {
        var sunriseUtcMinutes = calculateSolarUtcMinutes(date, latitude, longitude, true);
        var sunsetUtcMinutes = calculateSolarUtcMinutes(date, latitude, longitude, false);

        if (sunriseUtcMinutes === null || sunsetUtcMinutes === null) {
            return resolveSystemTheme();
        }

        var timezoneOffset = date.getTimezoneOffset();
        var currentLocalMinutes = (date.getHours() * 60) + date.getMinutes();
        var sunriseLocalMinutes = sunriseUtcMinutes - timezoneOffset;
        var sunsetLocalMinutes = sunsetUtcMinutes - timezoneOffset;

        if (sunriseLocalMinutes < 0) sunriseLocalMinutes += 1440;
        if (sunsetLocalMinutes < 0) sunsetLocalMinutes += 1440;
        if (sunriseLocalMinutes >= 1440) sunriseLocalMinutes -= 1440;
        if (sunsetLocalMinutes >= 1440) sunsetLocalMinutes -= 1440;

        return (currentLocalMinutes >= sunriseLocalMinutes && currentLocalMinutes < sunsetLocalMinutes) ? 'light' : 'dark';
    }

    function readStoredSystemGeo() {
        try {
            var raw = localStorage.getItem(systemThemeGeoKey);
            if (!raw) return null;
            var parsed = JSON.parse(raw);
            if (!parsed || typeof parsed !== 'object') return null;
            if (typeof parsed.latitude !== 'number' || typeof parsed.longitude !== 'number') return null;
            return parsed;
        } catch (error) {
            return null;
        }
    }

    function writeStoredSystemGeo(latitude, longitude) {
        try {
            localStorage.setItem(systemThemeGeoKey, JSON.stringify({
                latitude: latitude,
                longitude: longitude,
                updatedAt: Date.now()
            }));
        } catch (error) {}
    }

    function resolveSystemThemeAuto() {
        var now = new Date();
        var storedGeo = systemThemeState.geo || readStoredSystemGeo();

        if (storedGeo) {
            systemThemeState.geo = storedGeo;
            return resolveThemeFromSolarTime(now, storedGeo.latitude, storedGeo.longitude);
        }

        return resolveSystemTheme();
    }

    function requestSystemThemeGeo() {
        if (systemThemeState.requested || !navigator.geolocation) return;
        systemThemeState.requested = true;

        navigator.geolocation.getCurrentPosition(function (position) {
            systemThemeState.geo = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                updatedAt: Date.now()
            };
            writeStoredSystemGeo(position.coords.latitude, position.coords.longitude);
            syncSystemThemeIfNeeded();
        }, function () {
            systemThemeState.requested = false;
        }, {
            enableHighAccuracy: false,
            maximumAge: 86400000,
            timeout: 8000
        });
    }

    function syncThemeTargets(theme) {
        if (!themeTargets.length) return;

        themeTargets.forEach(function (item) {
            var isActive = (item.getAttribute('data-theme') || 'system') === theme;
            item.classList.toggle('is-active', isActive);
            item.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
    }

    function normalizeTheme(theme) {
        return ['light', 'dark', 'system'].indexOf(theme) !== -1 ? theme : 'system';
    }

    function readThemeOverride() {
        try {
            return normalizeTheme(localStorage.getItem(themeOverrideStorageKey) || '');
        } catch (error) {
            return 'system';
        }
    }

    function writeThemeOverride(theme) {
        try {
            localStorage.setItem(themeOverrideStorageKey, normalizeTheme(theme));
            localStorage.removeItem('theme');
        } catch (error) {}
    }

    function resolveInitialTheme() {
        try {
            var storedOverride = localStorage.getItem(themeOverrideStorageKey);
            if (storedOverride) {
                return normalizeTheme(storedOverride);
            }

            localStorage.removeItem('theme');
        } catch (error) {}

        return normalizeTheme(workspaceDefaults.defaultTheme || 'system');
    }

    function applyTheme(theme) {
        theme = normalizeTheme(theme);
        themePreference = theme;
        setThemeIcon(theme);
        setThemeLabel(theme);
        syncThemeTargets(theme);

        if (theme === 'system') {
            root.setAttribute('data-theme', resolveSystemThemeAuto());
            root.setAttribute('data-theme-mode', 'system');
            requestSystemThemeGeo();
            return;
        }

        root.removeAttribute('data-theme-mode');
        root.setAttribute('data-theme', theme);
    }

    try {
        var initialTheme = resolveInitialTheme();
        applyTheme(initialTheme);
        if (themeModeToggle) {
            themeModeToggle.value = initialTheme;
        }
    } catch (e) {
        applyTheme(workspaceDefaults.defaultTheme || 'system');
        if (themeModeToggle) {
            themeModeToggle.value = workspaceDefaults.defaultTheme || 'system';
        }
    }

    if (themeTargets.length) {
        themeTargets.forEach(function (item) {
            item.addEventListener('click', function (event) {
                event.preventDefault();
                var selectedTheme = item.getAttribute('data-theme') || 'system';
                applyTheme(selectedTheme);
                writeThemeOverride(selectedTheme);
                if (themeModeToggle) {
                    themeModeToggle.value = selectedTheme;
                }
                if (window.bootstrap) {
                    var dropdownNode = item.closest('.dropdown');
                    var dropdownToggle = dropdownNode ? dropdownNode.querySelector('[data-bs-toggle="dropdown"]') : null;
                    if (dropdownToggle) {
                        var instance = window.bootstrap.Dropdown.getInstance(dropdownToggle) || new window.bootstrap.Dropdown(dropdownToggle);
                        instance.hide();
                    }
                }
            });
        });
    }

    if (themeModeToggle) {
        themeModeToggle.addEventListener('change', function () {
            var selectedTheme = themeModeToggle.value || 'system';
            applyTheme(selectedTheme);
            writeThemeOverride(selectedTheme);
        });
    }

    function syncSystemThemeIfNeeded() {
        if (themePreference !== 'system') return;
        root.setAttribute('data-theme', resolveSystemThemeAuto());
    }

    window.setInterval(syncSystemThemeIfNeeded, 60000);
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
            syncSystemThemeIfNeeded();
        }
    });

    function initDateInputShells() {
        document.querySelectorAll('input[type="date"], input[type="datetime-local"]').forEach(function (input) {
            if (input.closest('.date-input-shell')) {
                if (!input.classList.contains('date-input-shell__control')) {
                    input.classList.add('date-input-shell__control');
                }
                return;
            }

            if (input.hasAttribute('data-date-shell-off')) {
                return;
            }

            var shell = document.createElement('div');
            shell.className = 'date-input-shell date-input-shell--auto';

            var icon = document.createElement('span');
            icon.className = 'date-input-shell__icon';
            icon.setAttribute('aria-hidden', 'true');
            icon.innerHTML = input.type === 'datetime-local'
                ? '<i class="fas fa-calendar-check"></i>'
                : '<i class="fas fa-calendar-day"></i>';

            input.classList.add('date-input-shell__control');
            input.parentNode.insertBefore(shell, input);
            shell.appendChild(icon);
            shell.appendChild(input);
        });

        var dateShells = document.querySelectorAll('.date-input-shell');
        if (!dateShells.length) return;

        var locale = document.documentElement.getAttribute('lang') || 'it';
        var activeInput = null;
        var visibleMonth = null;
        var weekdayFormatter = new Intl.DateTimeFormat(locale, { weekday: 'short' });
        var monthFormatter = new Intl.DateTimeFormat(locale, { month: 'long', year: 'numeric' });
        var prevMonthLabel = uiText('date_picker_prev_month', 'Previous month');
        var nextMonthLabel = uiText('date_picker_next_month', 'Next month');
        var todayLabel = uiText('date_picker_today', 'Today');
        var clearLabel = uiText('date_picker_clear', 'Clear');
        var monthLabel = uiText('date_picker_month', 'Month');
        var yearLabel = uiText('date_picker_year', 'Year');
        var timeLabel = uiText('date_picker_time', 'Time');
        var applyLabel = uiText('date_picker_apply', 'Apply');
        var monthNameFormatter = new Intl.DateTimeFormat(locale, { month: 'long' });
        var activeDateValue = null;
        var activeTimeValue = '';
        var panel = document.createElement('div');
        panel.className = 'date-picker-panel';
        panel.hidden = true;
        panel.innerHTML = [
            '<div class="date-picker-panel__chrome">',
            '<div class="date-picker-panel__header">',
            '<button class="date-picker-panel__nav" type="button" data-date-nav="prev" aria-label="' + prevMonthLabel.replace(/"/g, '&quot;') + '"><i class="fas fa-chevron-left"></i></button>',
            '<div class="date-picker-panel__title">',
            '<label class="date-picker-panel__select-wrap">',
            '<span class="visually-hidden">' + monthLabel + '</span>',
            '<select class="date-picker-panel__select" data-date-month aria-label="' + monthLabel.replace(/"/g, '&quot;') + '"></select>',
            '</label>',
            '<label class="date-picker-panel__select-wrap date-picker-panel__select-wrap--year">',
            '<span class="visually-hidden">' + yearLabel + '</span>',
            '<select class="date-picker-panel__select" data-date-year aria-label="' + yearLabel.replace(/"/g, '&quot;') + '"></select>',
            '</label>',
            '</div>',
            '<button class="date-picker-panel__nav" type="button" data-date-nav="next" aria-label="' + nextMonthLabel.replace(/"/g, '&quot;') + '"><i class="fas fa-chevron-right"></i></button>',
            '</div>',
            '<div class="date-picker-panel__weekdays" data-date-weekdays></div>',
            '<div class="date-picker-panel__grid" data-date-grid></div>',
            '<div class="date-picker-panel__time" data-date-time-row hidden>',
            '<label class="date-picker-panel__time-field">',
            '<span class="date-picker-panel__time-label">' + timeLabel + '</span>',
            '<input class="date-picker-panel__time-input" type="time" data-date-time-input step="60">',
            '</label>',
            '<button class="date-picker-panel__action date-picker-panel__action--apply" type="button" data-date-action="apply">' + applyLabel + '</button>',
            '</div>',
            '<div class="date-picker-panel__footer">',
            '<button class="date-picker-panel__action" type="button" data-date-action="today">' + todayLabel + '</button>',
            '<button class="date-picker-panel__action" type="button" data-date-action="clear">' + clearLabel + '</button>',
            '</div>',
            '</div>'
        ].join('');
        document.body.appendChild(panel);

        var monthSelect = panel.querySelector('[data-date-month]');
        var yearSelect = panel.querySelector('[data-date-year]');
        var weekdaysNode = panel.querySelector('[data-date-weekdays]');
        var gridNode = panel.querySelector('[data-date-grid]');
        var timeRow = panel.querySelector('[data-date-time-row]');
        var timeInput = panel.querySelector('[data-date-time-input]');

        function isDateTimeInput(input) {
            return !!input && input.type === 'datetime-local';
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatIsoDate(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function parseIsoDate(value) {
            if (!/^\d{4}-\d{2}-\d{2}$/.test(String(value || ''))) {
                return null;
            }

            var parts = String(value).split('-');
            var year = Number(parts[0]);
            var month = Number(parts[1]) - 1;
            var day = Number(parts[2]);
            var parsed = new Date(year, month, day);

            if (parsed.getFullYear() !== year || parsed.getMonth() !== month || parsed.getDate() !== day) {
                return null;
            }

            return parsed;
        }

        function parseLocalDateTime(value) {
            var match = String(value || '').match(/^(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2})/);
            if (!match) {
                return null;
            }

            var parsedDate = parseIsoDate(match[1]);
            if (!parsedDate) {
                return null;
            }

            return {
                date: parsedDate,
                time: match[2]
            };
        }

        function formatLocalDateTime(dateValue, timeValue) {
            return formatIsoDate(dateValue) + 'T' + String(timeValue || '00:00').slice(0, 5);
        }

        function defaultTimeValue() {
            var now = new Date();
            return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        }

        function buildWeekdays() {
            weekdaysNode.innerHTML = '';
            var anchor = new Date(2026, 2, 2);
            for (var index = 0; index < 7; index += 1) {
                var day = new Date(anchor);
                day.setDate(anchor.getDate() + index);
                var cell = document.createElement('span');
                cell.textContent = weekdayFormatter.format(day).replace('.', '').slice(0, 2).toUpperCase();
                weekdaysNode.appendChild(cell);
            }
        }

        function renderMonthOptions() {
            var markup = [];
            for (var monthIndex = 0; monthIndex < 12; monthIndex += 1) {
                var monthDate = new Date(2026, monthIndex, 1);
                markup.push('<option value="' + monthIndex + '">' + escapeHtml(monthNameFormatter.format(monthDate)) + '</option>');
            }
            monthSelect.innerHTML = markup.join('');
        }

        function renderYearOptions() {
            if (!visibleMonth) return;

            var selectedDate = activeInput ? parseIsoDate(activeInput.value) : null;
            var referenceYear = selectedDate ? selectedDate.getFullYear() : visibleMonth.getFullYear();
            var startYear = referenceYear - 12;
            var endYear = referenceYear + 12;
            var markup = [];

            for (var year = startYear; year <= endYear; year += 1) {
                markup.push('<option value="' + year + '">' + year + '</option>');
            }

            yearSelect.innerHTML = markup.join('');
        }

        function syncHeaderControls() {
            if (!visibleMonth) return;
            monthSelect.value = String(visibleMonth.getMonth());
            if (!yearSelect.querySelector('option[value="' + visibleMonth.getFullYear() + '"]')) {
                renderYearOptions();
            }
            yearSelect.value = String(visibleMonth.getFullYear());
        }

        function closePanel() {
            panel.hidden = true;
            panel.classList.remove('is-open');
            activeDateValue = null;
            activeTimeValue = '';
            if (timeRow) {
                timeRow.hidden = true;
            }
            if (activeInput) {
                var activeShell = activeInput.closest('.date-input-shell');
                if (activeShell) {
                    activeShell.classList.remove('is-open');
                }
            }
            activeInput = null;
        }

        function positionPanel(input) {
            var rect = input.closest('.date-input-shell').getBoundingClientRect();
            var panelWidth = 320;
            var top = rect.bottom + window.scrollY + 10;
            var left = rect.left + window.scrollX;
            var maxLeft = Math.max(12, window.scrollX + window.innerWidth - panelWidth - 12);
            panel.style.top = String(top) + 'px';
            panel.style.left = String(Math.min(left, maxLeft)) + 'px';
        }

        function syncInputValue(input, value) {
            input.value = value;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function syncTemporalControls() {
            if (!timeRow || !timeInput || !activeInput) return;

            if (isDateTimeInput(activeInput)) {
                timeRow.hidden = false;
                timeInput.value = activeTimeValue || defaultTimeValue();
            } else {
                timeRow.hidden = true;
                timeInput.value = '';
            }
        }

        function commitTemporalValue(shouldClose) {
            if (!activeInput || !activeDateValue) return;

            if (isDateTimeInput(activeInput)) {
                activeTimeValue = (timeInput && timeInput.value) ? timeInput.value : (activeTimeValue || defaultTimeValue());
                syncInputValue(activeInput, formatLocalDateTime(activeDateValue, activeTimeValue));
            } else {
                syncInputValue(activeInput, formatIsoDate(activeDateValue));
            }

            if (shouldClose !== false) {
                closePanel();
            }
        }

        function renderPanel() {
            if (!activeInput || !visibleMonth) return;

            syncHeaderControls();
            syncTemporalControls();
            gridNode.innerHTML = '';

            var today = new Date();
            today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

            var firstDay = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), 1);
            var startOffset = (firstDay.getDay() + 6) % 7;
            var gridStart = new Date(firstDay);
            gridStart.setDate(firstDay.getDate() - startOffset);

            for (var index = 0; index < 42; index += 1) {
                var cellDate = new Date(gridStart);
                cellDate.setDate(gridStart.getDate() + index);

                var button = document.createElement('button');
                button.type = 'button';
                button.className = 'date-picker-panel__day';
                button.textContent = String(cellDate.getDate());
                button.setAttribute('data-date-value', formatIsoDate(cellDate));

                if (cellDate.getMonth() !== visibleMonth.getMonth()) {
                    button.classList.add('is-muted');
                }
                if (activeDateValue && formatIsoDate(cellDate) === formatIsoDate(activeDateValue)) {
                    button.classList.add('is-selected');
                }
                if (formatIsoDate(cellDate) === formatIsoDate(today)) {
                    button.classList.add('is-today');
                }

                gridNode.appendChild(button);
            }
        }

        function openPanel(input) {
            activeInput = input;
            var temporalValue = isDateTimeInput(input) ? parseLocalDateTime(input.value) : null;
            var selectedDate = temporalValue ? temporalValue.date : parseIsoDate(input.value);
            activeDateValue = selectedDate || new Date();
            activeTimeValue = temporalValue ? temporalValue.time : defaultTimeValue();
            var baseDate = activeDateValue || new Date();
            visibleMonth = new Date(baseDate.getFullYear(), baseDate.getMonth(), 1);

            document.querySelectorAll('.date-input-shell.is-open').forEach(function (shell) {
                shell.classList.remove('is-open');
            });

            input.closest('.date-input-shell').classList.add('is-open');
            panel.hidden = false;
            panel.classList.add('is-open');
            positionPanel(input);
            renderPanel();
        }

        buildWeekdays();
        renderMonthOptions();

        panel.addEventListener('click', function (event) {
            var navButton = event.target.closest('[data-date-nav]');
            if (navButton) {
                if (!visibleMonth) return;
                var nextMonth = new Date(visibleMonth);
                nextMonth.setMonth(visibleMonth.getMonth() + (navButton.getAttribute('data-date-nav') === 'next' ? 1 : -1));
                visibleMonth = new Date(nextMonth.getFullYear(), nextMonth.getMonth(), 1);
                renderPanel();
                return;
            }

            var actionButton = event.target.closest('[data-date-action]');
            if (actionButton && activeInput) {
                var action = actionButton.getAttribute('data-date-action');
                if (action === 'today') {
                    activeDateValue = new Date();
                    if (isDateTimeInput(activeInput)) {
                        activeTimeValue = activeTimeValue || defaultTimeValue();
                    }
                    commitTemporalValue(true);
                } else if (action === 'apply') {
                    commitTemporalValue(true);
                } else {
                    syncInputValue(activeInput, '');
                    closePanel();
                }
                return;
            }

            var dayButton = event.target.closest('[data-date-value]');
            if (dayButton && activeInput) {
                activeDateValue = parseIsoDate(dayButton.getAttribute('data-date-value') || '');
                if (isDateTimeInput(activeInput)) {
                    renderPanel();
                } else {
                    commitTemporalValue(true);
                }
            }
        });

        if (timeInput) {
            timeInput.addEventListener('input', function () {
                activeTimeValue = timeInput.value || defaultTimeValue();
            });
        }

        monthSelect.addEventListener('change', function () {
            if (!visibleMonth) return;
            visibleMonth = new Date(visibleMonth.getFullYear(), Number(monthSelect.value || 0), 1);
            renderPanel();
        });

        yearSelect.addEventListener('change', function () {
            if (!visibleMonth) return;
            visibleMonth = new Date(Number(yearSelect.value || visibleMonth.getFullYear()), visibleMonth.getMonth(), 1);
            renderPanel();
        });

        document.addEventListener('click', function (event) {
            if (panel.hidden) return;
            if (panel.contains(event.target)) return;
            if (event.target.closest('.date-input-shell')) return;
            closePanel();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !panel.hidden) {
                closePanel();
            }
        });

        window.addEventListener('resize', function () {
            if (activeInput && !panel.hidden) {
                positionPanel(activeInput);
            }
        });

        window.addEventListener('scroll', function () {
            if (activeInput && !panel.hidden) {
                positionPanel(activeInput);
            }
        }, { passive: true });

        dateShells.forEach(function (shell) {
            var input = shell.querySelector('input[type="date"], input[type="datetime-local"]');
            if (!input) return;

            input.setAttribute('autocomplete', 'off');
            input.setAttribute('inputmode', 'none');
            input.readOnly = true;

            shell.addEventListener('click', function (event) {
                event.preventDefault();

                if (activeInput === input && !panel.hidden) {
                    closePanel();
                    return;
                }

                input.focus();
                openPanel(input);
            });

            input.addEventListener('focus', function () {
                shell.classList.add('is-focused');
            });

            input.addEventListener('blur', function () {
                shell.classList.remove('is-focused');
            });
        });
    }

    function initProjectFormUX() {
        var form = document.querySelector('[data-project-form]');
        if (!form) return;

        var nameInput = form.querySelector('[data-project-sync="name"]');
        var codeInput = form.querySelector('[data-project-sync="code"]');
        var customerSelect = form.querySelector('[data-project-sync="customer"]');
        var ownerSelect = form.querySelector('[data-project-sync="owner"]');
        var budgetInput = form.querySelector('[data-project-sync="budget"]');
        var startDateInput = form.querySelector('[data-project-sync="start_date"]');
        var dueDateInput = form.querySelector('[data-project-sync="due_date"]');
        var progressInput = form.querySelector('[data-project-sync="progress"]');
        var generateCodeButton = form.querySelector('[data-project-generate]');
        var hiddenFields = form.querySelectorAll('[data-project-hidden]');
        var pillButtons = form.querySelectorAll('[data-project-pill-target]');
        var previewName = document.querySelector('[data-project-preview="name"]');
        var previewCode = document.querySelector('[data-project-preview="code"]');
        var previewCustomer = document.querySelector('[data-project-preview="customer"]');
        var previewOwner = document.querySelector('[data-project-preview="owner"]');
        var previewDates = document.querySelector('[data-project-preview="dates"]');
        var previewBudget = document.querySelector('[data-project-preview="budget"]');
        var previewHealth = document.querySelector('[data-project-preview="health"]');
        var previewHealthPill = document.querySelector('[data-project-preview-health-pill]');
        var previewProgress = document.querySelector('[data-project-preview-progress]');
        var previewProgressBar = document.querySelector('[data-project-preview-progress-bar]');
        var progressLabel = document.querySelector('[data-project-progress-label]');
        var completionBar = document.querySelector('[data-project-completion-bar]');
        var completionValue = document.querySelector('[data-project-completion-value]');
        var assist = document.querySelector('[data-project-assist]');
        var emptyNameText = form.getAttribute('data-project-empty-name') || 'The project name will appear here in real time.';
        var emptyCustomerText = form.getAttribute('data-project-empty-customer') || 'No linked customer';
        var emptyOwnerText = form.getAttribute('data-project-empty-owner') || 'Assign an owner';
        var emptyDatesText = form.getAttribute('data-project-empty-dates') || 'Dates to define';
        var daysLabelText = form.getAttribute('data-project-days-label') || 'days';
        var assistReadyText = form.getAttribute('data-project-assist-ready') || 'Ready for the delivery board';
        var assistWatchText = form.getAttribute('data-project-assist-watch') || 'Operational context still needed';
        var assistRiskText = form.getAttribute('data-project-assist-risk') || 'High risk, needs attention';
        var codePlaceholderText = form.getAttribute('data-project-code-placeholder') || 'PRJ-2401';

        function hiddenValue(name) {
            var input = form.querySelector('[data-project-hidden="' + name + '"]');
            return input ? String(input.value || '') : '';
        }

        function setHiddenValue(name, value) {
            var input = form.querySelector('[data-project-hidden="' + name + '"]');
            if (!input) return;
            input.value = value;
        }

        function prettifyDate(value) {
            if (!value) return '';
            try {
                var parts = String(value).split('-');
                if (parts.length !== 3) return value;
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            } catch (error) {
                return value;
            }
        }

        function updateDateSummary() {
            if (!previewDates) return;
            var start = startDateInput ? String(startDateInput.value || '') : '';
            var due = dueDateInput ? String(dueDateInput.value || '') : '';
            if (!start && !due) {
                previewDates.textContent = emptyDatesText;
                return;
            }
            if (start && due) {
                var startObj = new Date(start + 'T00:00:00');
                var dueObj = new Date(due + 'T00:00:00');
                var days = Math.max(0, Math.round((dueObj - startObj) / 86400000));
                previewDates.textContent = prettifyDate(start) + ' - ' + prettifyDate(due) + ' • ' + days + ' ' + daysLabelText;
                return;
            }
            previewDates.textContent = prettifyDate(start || due);
        }

        function updateBudgetSummary() {
            if (!previewBudget || !budgetInput) return;
            var value = String(budgetInput.value || '').trim();
            if (!value) {
                previewBudget.textContent = '-';
                return;
            }
            var amount = Number(value);
            if (Number.isNaN(amount)) {
                previewBudget.textContent = value;
                return;
            }
            previewBudget.textContent = new Intl.NumberFormat(undefined, { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(amount);
        }

        function updateProgressSummary() {
            var progress = progressInput ? Math.max(0, Math.min(100, Number(progressInput.value || 0))) : 0;
            if (previewProgress) previewProgress.textContent = String(progress) + '%';
            if (progressLabel) progressLabel.textContent = String(progress) + '%';
            if (previewProgressBar) previewProgressBar.style.width = String(progress) + '%';
        }

        function updateCompletion() {
            var checks = [
                !!(nameInput && String(nameInput.value || '').trim()),
                !!(codeInput && String(codeInput.value || '').trim()),
                !!hiddenValue('status'),
                !!hiddenValue('priority'),
                !!hiddenValue('health'),
                !!(form.querySelector('[data-project-sync="description"]') && String(form.querySelector('[data-project-sync="description"]').value || '').trim())
            ];
            var percent = Math.round((checks.filter(Boolean).length / checks.length) * 100);
            if (completionBar) completionBar.style.width = String(percent) + '%';
            if (completionValue) completionValue.textContent = String(percent) + '%';
        }

        function updateAssist() {
            if (!assist) return;
            var health = hiddenValue('health') || 'on_track';
            var progress = progressInput ? Number(progressInput.value || 0) : 0;

            if (health === 'at_risk') {
                assist.textContent = assistRiskText;
                assist.dataset.state = 'risk';
                return;
            }

            if (health === 'watch' || progress < 30) {
                assist.textContent = assistWatchText;
                assist.dataset.state = 'watch';
                return;
            }

            assist.textContent = assistReadyText;
            assist.dataset.state = 'ready';
        }

        function updatePreview() {
            if (previewName && nameInput) {
                previewName.textContent = String(nameInput.value || '').trim() || emptyNameText;
            }
            if (previewCode && codeInput) {
                previewCode.textContent = String(codeInput.value || '').trim() || codePlaceholderText;
            }
            if (previewCustomer && customerSelect) {
                var option = customerSelect.options[customerSelect.selectedIndex];
                previewCustomer.textContent = option && option.value ? option.textContent : emptyCustomerText;
            }
            if (previewOwner && ownerSelect) {
                var ownerOption = ownerSelect.options[ownerSelect.selectedIndex];
                previewOwner.textContent = ownerOption && ownerOption.value ? ownerOption.textContent : emptyOwnerText;
            }
            if (previewHealth) {
                var activePill = form.querySelector('[data-project-pill-target="health"].is-active');
                previewHealth.textContent = activePill ? activePill.textContent.trim() : hiddenValue('health');
            }
            if (previewHealthPill) {
                var healthValue = hiddenValue('health') || 'on_track';
                previewHealthPill.className = 'project-health-pill project-health-pill--' + healthValue;
                previewHealthPill.textContent = previewHealth ? previewHealth.textContent : healthValue;
            }

            updateDateSummary();
            updateBudgetSummary();
            updateProgressSummary();
            updateCompletion();
            updateAssist();
        }

        pillButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var target = button.getAttribute('data-project-pill-target');
                var value = button.getAttribute('data-project-pill-value') || '';
                form.querySelectorAll('[data-project-pill-target="' + target + '"]').forEach(function (item) {
                    item.classList.toggle('is-active', item === button);
                });
                setHiddenValue(target, value);
                updatePreview();
            });
        });

        hiddenFields.forEach(function (input) {
            input.addEventListener('change', updatePreview);
        });

        [nameInput, codeInput, customerSelect, ownerSelect, budgetInput, startDateInput, dueDateInput, progressInput, form.querySelector('[data-project-sync="description"]')].forEach(function (input) {
            if (!input) return;
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        });

        if (generateCodeButton && codeInput && nameInput) {
            generateCodeButton.addEventListener('click', function () {
                var source = String(nameInput.value || '').trim().toUpperCase();
                var slug = source.replace(/[^A-Z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 12);
                var sequence = String(Math.floor(Math.random() * 9000) + 1000);
                codeInput.value = (slug ? slug : 'PRJ') + '-' + sequence;
                updatePreview();
            });
        }

        updatePreview();
    }

    function initBrowserNotifications() {
        var stack = document.querySelector('[data-browser-notification-stack]');
        var closeLabel = uiText('notification_close', 'Close notification');
        var sourceLabel = uiText('notification_source', 'CoreSuite Lite');
        var openItemLabel = uiText('notification_open_item', 'Open detail');
        var liveSources = {
            topbar: uiText('notification_live_topbar', 'Topbar live signal'),
            dashboard: uiText('notification_live_dashboard', 'Dashboard live signal')
        };
        var sessionKey = 'coresuite_live_notifications_seen';
        var toneIcons = {
            info: 'fa-sparkles',
            success: 'fa-circle-check',
            warning: 'fa-bell',
            danger: 'fa-triangle-exclamation'
        };

        if (!stack) {
            stack = document.createElement('div');
            stack.className = 'browser-notification-stack';
            stack.setAttribute('data-browser-notification-stack', '');
            stack.setAttribute('aria-live', 'polite');
            document.body.appendChild(stack);
        }

        function dismissNotification(node) {
            if (!node || node.dataset.dismissing === '1') return;
            node.dataset.dismissing = '1';
            node.classList.add('is-leaving');
            window.setTimeout(function () {
                if (node.parentNode) {
                    node.parentNode.removeChild(node);
                }
            }, 220);
        }

        function scheduleDismiss(node) {
            var timeout = Number(node.getAttribute('data-auto-dismiss') || 0);
            if (!timeout) return;

            var timerId = null;
            var startedAt = 0;
            var remaining = timeout;

            function clearTimer() {
                if (timerId) {
                    window.clearTimeout(timerId);
                    timerId = null;
                }
            }

            function startTimer() {
                clearTimer();
                if (remaining <= 0) {
                    dismissNotification(node);
                    return;
                }
                startedAt = Date.now();
                timerId = window.setTimeout(function () {
                    dismissNotification(node);
                }, remaining);
            }

            function pauseTimer() {
                if (!timerId) return;
                remaining -= Date.now() - startedAt;
                clearTimer();
            }

            function resumeTimer() {
                if (node.dataset.dismissing === '1') return;
                startTimer();
            }

            startTimer();
            node.addEventListener('mouseenter', pauseTimer);
            node.addEventListener('mouseleave', resumeTimer);
            node.addEventListener('focusin', pauseTimer);
            node.addEventListener('focusout', resumeTimer);
        }

        function registerNotification(node) {
            if (!node || node.dataset.bound === '1') return;
            node.dataset.bound = '1';

            var closeButton = node.querySelector('[data-browser-notification-close]');
            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    dismissNotification(node);
                });
            }

            window.requestAnimationFrame(function () {
                node.classList.add('is-visible');
            });

            scheduleDismiss(node);
        }

        function createNotification(options) {
            var tone = String(options.tone || 'info');
            var article = document.createElement('article');
            article.className = 'browser-notification is-' + tone;
            article.setAttribute('data-browser-notification', '');
            article.setAttribute('role', tone === 'danger' ? 'alert' : 'status');
            article.setAttribute('aria-live', 'polite');
            article.setAttribute('data-auto-dismiss', String(options.autoDismiss || 5600));

            var accent = document.createElement('span');
            accent.className = 'browser-notification__accent';
            accent.setAttribute('aria-hidden', 'true');

            var icon = document.createElement('span');
            icon.className = 'browser-notification__icon';
            icon.setAttribute('aria-hidden', 'true');
            icon.innerHTML = '<i class="fas ' + (options.icon || toneIcons[tone] || toneIcons.info) + '"></i>';

            var content = document.createElement('div');
            content.className = 'browser-notification__content';

            var eyebrow = document.createElement('span');
            eyebrow.className = 'browser-notification__eyebrow';
            eyebrow.textContent = options.source || sourceLabel;
            content.appendChild(eyebrow);

            var title = document.createElement('strong');
            title.textContent = options.title || sourceLabel;
            content.appendChild(title);

            if (options.message) {
                var message = document.createElement('p');
                message.textContent = options.message;
                content.appendChild(message);
            }

            if (options.meta) {
                var meta = document.createElement('small');
                meta.className = 'browser-notification__meta';
                meta.textContent = options.meta;
                content.appendChild(meta);
            }

            if (options.actionLabel && options.actionHref) {
                var action = document.createElement('a');
                action.className = 'browser-notification__action';
                action.href = options.actionHref;
                action.textContent = options.actionLabel;
                content.appendChild(action);
            }

            var closeButton = document.createElement('button');
            closeButton.className = 'browser-notification__close';
            closeButton.type = 'button';
            closeButton.setAttribute('data-browser-notification-close', '');
            closeButton.setAttribute('aria-label', closeLabel);
            closeButton.innerHTML = '<i class="fas fa-xmark" aria-hidden="true"></i>';

            var progress = document.createElement('span');
            progress.className = 'browser-notification__progress';
            progress.setAttribute('aria-hidden', 'true');

            article.appendChild(accent);
            article.appendChild(icon);
            article.appendChild(content);
            article.appendChild(closeButton);
            article.appendChild(progress);

            return article;
        }

        function readSeenKeys() {
            try {
                var raw = window.sessionStorage.getItem(sessionKey);
                var parsed = raw ? JSON.parse(raw) : [];
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }
        }

        function writeSeenKeys(keys) {
            try {
                window.sessionStorage.setItem(sessionKey, JSON.stringify(keys.slice(-24)));
            } catch (error) {}
        }

        function hasSeenKey(key) {
            if (!key) return false;
            return readSeenKeys().indexOf(key) !== -1;
        }

        function markSeenKey(key) {
            if (!key) return;
            var keys = readSeenKeys();
            if (keys.indexOf(key) !== -1) return;
            keys.push(key);
            writeSeenKeys(keys);
        }

        function inferActionLabel(href) {
            var target = String(href || '');
            if (target.indexOf('/tickets') === 0) {
                return uiText('notification_open_ticket', 'Open ticket');
            }
            if (target.indexOf('/documents') === 0) {
                return uiText('notification_open_documents', 'Go to documents');
            }
            if (target.indexOf('/admin') === 0) {
                return uiText('notification_open_admin', 'Open admin');
            }
            if (target.indexOf('/dashboard') === 0) {
                return uiText('notification_open_dashboard', 'Go to dashboard');
            }
            return openItemLabel;
        }

        function optionsFromLiveNode(node) {
            if (!node) return null;

            var href = node.getAttribute('data-notification-href') || node.getAttribute('href') || '';
            var source = node.getAttribute('data-notification-source') || 'topbar';
            return {
                key: node.getAttribute('data-notification-key') || '',
                tone: node.getAttribute('data-notification-tone') || 'info',
                icon: node.getAttribute('data-notification-icon') || '',
                title: node.getAttribute('data-notification-title') || sourceLabel,
                message: node.getAttribute('data-notification-message') || '',
                meta: node.getAttribute('data-notification-meta') || '',
                source: liveSources[source] || sourceLabel,
                actionHref: href,
                actionLabel: inferActionLabel(href),
                autoDismiss: source === 'dashboard' ? 7600 : 6200
            };
        }

        function showLiveNotification(node) {
            var options = optionsFromLiveNode(node);
            if (!options || !options.key || hasSeenKey(options.key)) return;
            window.CoresuiteNotify.show(options);
            markSeenKey(options.key);
        }

        stack.querySelectorAll('[data-browser-notification]').forEach(registerNotification);

        document.querySelectorAll('[data-notification-preview]').forEach(function (button) {
            button.addEventListener('click', function () {
                var notificationNode = createNotification({
                    tone: button.getAttribute('data-notification-tone') || 'info',
                    icon: button.getAttribute('data-notification-icon') || '',
                    title: button.getAttribute('data-notification-title') || sourceLabel,
                    message: button.getAttribute('data-notification-message') || '',
                    meta: button.getAttribute('data-notification-meta') || sourceLabel,
                    autoDismiss: 5200
                });

                stack.appendChild(notificationNode);
                registerNotification(notificationNode);
            });
        });

        window.CoresuiteNotify = {
            show: function (options) {
                var notificationNode = createNotification(options || {});
                stack.appendChild(notificationNode);
                registerNotification(notificationNode);
                return notificationNode;
            },
            dismiss: dismissNotification
        };

        document.addEventListener('shown.bs.dropdown', function (event) {
            var toggle = event.target;
            if (!toggle || !toggle.closest) return;
            var dropdown = toggle.closest('.admin-topbar-dropdown');
            if (!dropdown) return;
            var liveContainer = dropdown.querySelector('[data-live-notification-source="topbar"]');
            if (!liveContainer) return;
            var candidate = liveContainer.querySelector('[data-live-notification]');
            if (candidate) {
                showLiveNotification(candidate);
            }
        });

        window.setTimeout(function () {
            var dashboardContainer = document.querySelector('[data-live-notification-source="dashboard"]');
            if (!dashboardContainer) return;
            var dashboardItem = dashboardContainer.querySelector('[data-live-notification]');
            if (dashboardItem) {
                showLiveNotification(dashboardItem);
            }
        }, 900);
    }

    function initTopbarNotificationPanel() {
        var panel = document.querySelector('.admin-topbar-menu--notifications');
        if (!panel) return;

        var list = panel.querySelector('[data-topbar-notification-list]');
        var topbarItems = Array.prototype.slice.call(panel.querySelectorAll('[data-notification-item]'));
        var dashboardItems = Array.prototype.slice.call(document.querySelectorAll('[data-live-notification-source="dashboard"] [data-live-notification]'));
        var allItems = topbarItems.concat(dashboardItems);
        var filters = panel.querySelectorAll('[data-notification-filter]');
        var markAllButton = panel.querySelector('[data-notification-mark-all]');
        var emptyState = panel.querySelector('[data-topbar-notification-empty]');
        var summary = panel.querySelector('[data-topbar-notification-summary]');
        var notificationToggle = document.querySelector('[data-notification-toggle]');
        var dashboardSummary = document.querySelector('[data-dashboard-notification-summary]');
        var badge = document.querySelector('.admin-topbar-notify__badge');
        var storageKey = 'coresuite_inbox_notifications_read';
        var activeFilter = 'all';

        if (!list || !allItems.length) {
            if (markAllButton) markAllButton.disabled = true;
            return;
        }

        function readReadKeys() {
            try {
                var raw = window.localStorage.getItem(storageKey);
                var parsed = raw ? JSON.parse(raw) : [];
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }
        }

        function writeReadKeys(keys) {
            try {
                window.localStorage.setItem(storageKey, JSON.stringify(keys.slice(-48)));
            } catch (error) {}
        }

        function isRead(item) {
            var key = item.getAttribute('data-notification-key') || '';
            return readReadKeys().indexOf(key) !== -1;
        }

        function markRead(item) {
            var key = item.getAttribute('data-notification-key') || '';
            if (!key) return;
            var keys = readReadKeys();
            if (keys.indexOf(key) === -1) {
                keys.push(key);
                writeReadKeys(keys);
            }
        }

        function applyReadState(item) {
            var read = isRead(item);
            item.classList.toggle('is-read', read);
            item.classList.toggle('is-unread', !read);
            item.setAttribute('data-read-state', read ? 'read' : 'unread');
        }

        function updateSummary(unreadCount) {
            if (summary) {
                var label = summary.getAttribute('data-count-label') || '';
                summary.textContent = String(unreadCount) + ' ' + label;
            }
            if (notificationToggle) {
                var emptyLabel = notificationToggle.getAttribute('data-aria-empty-label') || 'Notifications';
                var countTemplate = notificationToggle.getAttribute('data-aria-count-template') || '{count} unread notifications';
                notificationToggle.setAttribute('aria-label', unreadCount > 0 ? countTemplate.replace('{count}', String(unreadCount)) : emptyLabel);
            }
            if (dashboardSummary) {
                var dashboardLabel = dashboardSummary.getAttribute('data-count-label') || '';
                dashboardSummary.textContent = String(unreadCount) + ' ' + dashboardLabel;
            }
            if (badge) {
                badge.textContent = String(unreadCount);
                badge.hidden = unreadCount <= 0;
            }
        }

        function syncFilterButtons() {
            filters.forEach(function (button) {
                var isActive = (button.getAttribute('data-notification-filter') || 'all') === activeFilter;
                button.classList.toggle('is-active', isActive);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
        }

        function renderTopbar(unreadCount) {
            var visibleCount = 0;

            topbarItems.forEach(function (item) {
                applyReadState(item);
                var read = item.classList.contains('is-read');
                var hidden = activeFilter === 'unread' && read;
                item.hidden = hidden;
                if (!hidden) visibleCount += 1;
            });

            updateSummary(unreadCount);
            syncFilterButtons();

            if (emptyState) {
                emptyState.hidden = visibleCount > 0;
                if (!emptyState.hidden) {
                    emptyState.textContent = activeFilter === 'unread'
                        ? (panel.getAttribute('data-empty-unread') || 'No unread notifications.')
                        : (panel.getAttribute('data-empty-all') || 'No notifications available.');
                }
            }
        }

        function renderDashboard() {
            dashboardItems.forEach(function (item) {
                applyReadState(item);
            });
        }

        function render() {
            var unreadCount = 0;

            allItems.forEach(function (item) {
                applyReadState(item);
                var read = item.classList.contains('is-read');
                if (!read) unreadCount += 1;
            });

            renderTopbar(unreadCount);
            renderDashboard();

            if (markAllButton) {
                markAllButton.disabled = unreadCount === 0;
            }
        }

        panel.addEventListener('click', function (event) {
            if (event.target.closest('[data-notification-filter], [data-notification-mark-all]')) {
                event.stopPropagation();
            }
        });

        filters.forEach(function (button) {
            button.addEventListener('click', function () {
                activeFilter = button.getAttribute('data-notification-filter') || 'all';
                render();
            });
        });

        if (markAllButton) {
            markAllButton.addEventListener('click', function () {
                allItems.forEach(markRead);
                render();
            });
        }

        allItems.forEach(function (item) {
            item.addEventListener('click', function () {
                markRead(item);
                render();
            });
        });

        window.addEventListener('storage', function (event) {
            if (event.key === storageKey) {
                render();
            }
        });

        render();
    }

    initBrowserNotifications();
    initTopbarNotificationPanel();
    initDateInputShells();
    initProjectFormUX();

    function isDesktopViewport() {
        return window.matchMedia('(min-width: 992px)').matches;
    }

    function getSidebarFocusableElements() {
        if (!sidebar) return [];

        return Array.prototype.slice.call(sidebar.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])')).filter(function (node) {
            return !node.hidden && node.offsetParent !== null;
        });
    }

    function syncSidebarAccessibilityState() {
        var isDesktop = isDesktopViewport();
        var isExpanded = isDesktop ? !body.classList.contains('sidebar-collapsed') : body.classList.contains('sidebar-open');

        if (sidebarToggle) {
            sidebarToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
        }

        if (sidebar) {
            sidebar.setAttribute('aria-hidden', isDesktop ? 'false' : (isExpanded ? 'false' : 'true'));
        }
    }

    function closeSidebar(restoreFocus) {
        if (isDesktopViewport()) {
            syncSidebarAccessibilityState();
            return;
        }

        body.classList.remove('sidebar-open');
        syncSidebarAccessibilityState();

        if (restoreFocus && sidebarLastActiveElement && typeof sidebarLastActiveElement.focus === 'function') {
            sidebarLastActiveElement.focus();
        }
    }

    function openSidebar() {
        if (isDesktopViewport()) {
            syncSidebarAccessibilityState();
            return;
        }

        sidebarLastActiveElement = document.activeElement;
        body.classList.add('sidebar-open');
        syncSidebarAccessibilityState();

        var focusables = getSidebarFocusableElements();
        if (focusables.length) {
            focusables[0].focus();
        } else if (sidebar) {
            sidebar.focus();
        }
    }

    function handleSidebarToggle() {
        var isDesktop = isDesktopViewport();

        if (isDesktop) {
            body.classList.toggle('sidebar-collapsed');
            try {
                localStorage.setItem('sidebar-collapsed', body.classList.contains('sidebar-collapsed') ? '1' : '0');
            } catch (error) {}
            syncSidebarAccessibilityState();
            return;
        }

        if (body.classList.contains('sidebar-open')) {
            closeSidebar(true);
            return;
        }

        openSidebar();
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', handleSidebarToggle);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            closeSidebar(true);
        });
    }

    window.addEventListener('resize', function () {
        if (isDesktopViewport()) {
            closeSidebar(false);
        }

        syncSidebarAccessibilityState();
    });

    document.addEventListener('keydown', function (event) {
        if (isDesktopViewport() || !body.classList.contains('sidebar-open')) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            closeSidebar(true);
            return;
        }

        if (event.key !== 'Tab') {
            return;
        }

        var focusables = getSidebarFocusableElements();
        if (!focusables.length) {
            event.preventDefault();
            return;
        }

        var first = focusables[0];
        var last = focusables[focusables.length - 1];
        if (!sidebar || !sidebar.contains(document.activeElement)) {
            event.preventDefault();
            first.focus();
            return;
        }

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });

    try {
        var shouldCollapse = localStorage.getItem('sidebar-collapsed');
        if (shouldCollapse === null) {
            shouldCollapse = workspaceDefaults.sidebarCollapsedDefault ? '1' : '0';
        }
        if (shouldCollapse === '1' && window.matchMedia('(min-width: 992px)').matches) {
            body.classList.add('sidebar-collapsed');
        }
    } catch (error) {}

    syncSidebarAccessibilityState();

    function syncTopbarScrollState() {
        if (!topbar) return;
        topbar.classList.toggle('is-scrolled', window.scrollY > 10);
    }

    function syncBackToTopState() {
        if (!backToTopButton) return;
        var shouldShow = window.scrollY > 320;
        backToTopButton.hidden = !shouldShow;
        backToTopButton.classList.toggle('is-visible', shouldShow);
    }

    syncTopbarScrollState();
    syncBackToTopState();
    window.addEventListener('scroll', syncTopbarScrollState, { passive: true });
    window.addEventListener('scroll', syncBackToTopState, { passive: true });

    if (backToTopButton) {
        backToTopButton.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    function initSidebarUX() {
        if (!sidebar) return;

        var filterInput = sidebar.querySelector('[data-sidebar-filter]');
        var navLinks = sidebar.querySelectorAll('.admin-nav-link');
        var sectionNodes = sidebar.querySelectorAll('[data-sidebar-section]');
        var sectionToggles = sidebar.querySelectorAll('[data-sidebar-section-toggle]');
        var tooltipTargets = sidebar.querySelectorAll('[data-tooltip]');
        var emptyState = sidebar.querySelector('[data-sidebar-empty]');
        var storageKey = 'coresuite_sidebar_sections';
        var floatingTooltip = document.createElement('div');
        floatingTooltip.className = 'admin-floating-tooltip';
        floatingTooltip.hidden = true;
        document.body.appendChild(floatingTooltip);

        function isCollapsedDesktop() {
            return window.matchMedia('(min-width: 992px)').matches && body.classList.contains('sidebar-collapsed');
        }

        function positionTooltip(target) {
            var rect = target.getBoundingClientRect();
            floatingTooltip.style.top = String(rect.top + rect.height / 2) + 'px';
            floatingTooltip.style.left = String(rect.right + 14) + 'px';
        }

        function showTooltip(target) {
            if (!isCollapsedDesktop()) return;
            var label = target.getAttribute('data-tooltip');
            if (!label) return;
            floatingTooltip.textContent = label;
            positionTooltip(target);
            floatingTooltip.hidden = false;
            floatingTooltip.classList.add('is-visible');
        }

        function hideTooltip() {
            floatingTooltip.hidden = true;
            floatingTooltip.classList.remove('is-visible');
        }

        function readSectionsState() {
            try {
                var parsed = JSON.parse(localStorage.getItem(storageKey) || '{}');
                return parsed && typeof parsed === 'object' ? parsed : {};
            } catch (error) {
                return {};
            }
        }

        function writeSectionsState(state) {
            try {
                localStorage.setItem(storageKey, JSON.stringify(state));
            } catch (error) {}
        }

        function getSectionNode(toggle) {
            return toggle.closest('[data-sidebar-section]');
        }

        function syncSectionToggle(toggle, expanded) {
            var target = toggle.getAttribute('data-sidebar-section-toggle');
            var bodyNode = sidebar.querySelector('[data-sidebar-section-body=\"' + target + '\"]');
            if (!bodyNode) return;
            toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            bodyNode.hidden = !expanded;
        }

        function restoreSectionsState() {
            sectionToggles.forEach(function (toggle) {
                var key = toggle.getAttribute('data-sidebar-section-toggle');
                var expanded = Object.prototype.hasOwnProperty.call(sectionState, key)
                    ? !!sectionState[key]
                    : toggle.getAttribute('aria-expanded') !== 'false';
                var sectionNode = getSectionNode(toggle);
                if (sectionNode) {
                    sectionNode.hidden = false;
                }
                syncSectionToggle(toggle, expanded);
            });
        }

        function applySidebarFilter(query) {
            var normalizedQuery = String(query || '').trim().toLowerCase();
            var visibleTotal = 0;

            sectionToggles.forEach(function (toggle) {
                var target = toggle.getAttribute('data-sidebar-section-toggle');
                var bodyNode = sidebar.querySelector('[data-sidebar-section-body="' + target + '"]');
                var sectionNode = getSectionNode(toggle);
                var sectionVisible = 0;

                if (!bodyNode) {
                    return;
                }

                Array.prototype.forEach.call(bodyNode.querySelectorAll('.admin-nav-link'), function (link) {
                    var label = String(link.getAttribute('data-nav-label') || link.textContent || '').toLowerCase();
                    var hidden = normalizedQuery !== '' && label.indexOf(normalizedQuery) === -1;
                    link.hidden = hidden;
                    if (!hidden) {
                        sectionVisible += 1;
                        visibleTotal += 1;
                    }
                });

                if (normalizedQuery !== '') {
                    if (sectionNode) {
                        sectionNode.hidden = sectionVisible === 0;
                    }
                    if (sectionVisible > 0) {
                        syncSectionToggle(toggle, true);
                    }
                    return;
                }

                if (sectionNode) {
                    sectionNode.hidden = false;
                }
            });

            if (normalizedQuery === '') {
                restoreSectionsState();
            }

            if (emptyState) {
                emptyState.hidden = normalizedQuery === '' || visibleTotal > 0;
            }

            if (sectionNodes.length && normalizedQuery === '') {
                sectionNodes.forEach(function (sectionNode) {
                    sectionNode.hidden = false;
                });
            }
        }

        var sectionState = readSectionsState();
        sectionToggles.forEach(function (toggle) {
            var key = toggle.getAttribute('data-sidebar-section-toggle');
            if (Object.prototype.hasOwnProperty.call(sectionState, key)) {
                syncSectionToggle(toggle, !!sectionState[key]);
            }

            toggle.addEventListener('click', function () {
                var isExpanded = toggle.getAttribute('aria-expanded') !== 'false';
                syncSectionToggle(toggle, !isExpanded);
                sectionState[key] = !isExpanded;
                writeSectionsState(sectionState);
            });
        });

        if (filterInput) {
            filterInput.addEventListener('input', function () {
                applySidebarFilter(filterInput.value || '');
            });
        }

        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (!isDesktopViewport()) {
                    closeSidebar(false);
                }
            });
        });

        tooltipTargets.forEach(function (target) {
            target.addEventListener('mouseenter', function () {
                showTooltip(target);
            });
            target.addEventListener('mouseleave', hideTooltip);
            target.addEventListener('focus', function () {
                showTooltip(target);
            });
            target.addEventListener('blur', hideTooltip);
            target.addEventListener('mousemove', function () {
                if (!floatingTooltip.hidden) {
                    positionTooltip(target);
                }
            });
        });

        window.addEventListener('scroll', hideTooltip, { passive: true });
        window.addEventListener('resize', hideTooltip);
        restoreSectionsState();
    }

    function initSpotlightSearch() {
        var searchForm = document.querySelector('[data-spotlight-search]');
        if (!searchForm || !window.fetch) return;

        var input = searchForm.querySelector('[data-spotlight-input]');
        var panel = searchForm.querySelector('[data-spotlight-panel]');
        var status = searchForm.querySelector('[data-spotlight-status]');
        var emptyState = searchForm.querySelector('[data-spotlight-empty]');
        var pinnedSection = searchForm.querySelector('[data-spotlight-pinned-section]');
        var pinnedContainer = searchForm.querySelector('[data-spotlight-pinned]');
        var recentContainer = searchForm.querySelector('[data-spotlight-recent]');
        var results = searchForm.querySelector('[data-spotlight-results]');
        var footer = searchForm.querySelector('[data-spotlight-footer]');
        var pinButtons = searchForm.querySelectorAll('[data-action-pin]');
        var activeIndex = -1;
        var itemNodes = [];
        var debounceTimer = null;
        var requestId = 0;
        var storageKey = 'coresuite_spotlight_recent';
        var pinnedStorageKey = 'coresuite_spotlight_pinned';
        var quickActionMap = {};

        pinButtons.forEach(function (button) {
            quickActionMap[button.getAttribute('data-action-pin')] = {
                id: button.getAttribute('data-action-pin'),
                label: button.getAttribute('data-action-label'),
                icon: button.getAttribute('data-action-icon'),
                href: button.getAttribute('data-action-href')
            };
        });

        function closePanel() {
            if (!panel) return;
            panel.hidden = true;
            activeIndex = -1;
            itemNodes = [];
        }

        function openPanel() {
            if (!panel) return;
            panel.hidden = false;
        }

        function updateActiveItem() {
            itemNodes.forEach(function (node, index) {
                node.classList.toggle('is-active', index === activeIndex);
            });
        }

        function setStatus(message) {
            if (status) {
                status.textContent = message;
            }
        }

        function toggleEmptyState(show) {
            if (!emptyState) return;
            emptyState.hidden = !show;
        }

        function setFooter(url, total) {
            if (!footer) return;
            footer.href = url || '/search';
            footer.hidden = !url;
            var label = uiText('spotlight_footer_open', 'Apri risultati completi');
            footer.textContent = url ? (label + ' (' + total + ')') : label;
        }

        function readPinnedActions() {
            try {
                var parsed = JSON.parse(localStorage.getItem(pinnedStorageKey) || '[]');
                return Array.isArray(parsed) ? parsed.filter(Boolean).slice(0, 4) : [];
            } catch (error) {
                return [];
            }
        }

        function writePinnedActions(ids) {
            try {
                localStorage.setItem(pinnedStorageKey, JSON.stringify(ids.slice(0, 4)));
            } catch (error) {
                return;
            }
        }

        function togglePinnedAction(id) {
            var current = readPinnedActions();
            var next = current.indexOf(id) >= 0
                ? current.filter(function (item) { return item !== id; })
                : current.concat(id);
            writePinnedActions(next);
            renderPinnedActions();
        }

        function renderPinnedActions() {
            if (!pinnedSection || !pinnedContainer) return;

            var pinnedIds = readPinnedActions();
            pinnedContainer.innerHTML = '';

            pinButtons.forEach(function (button) {
                button.classList.toggle('is-active', pinnedIds.indexOf(button.getAttribute('data-action-pin')) >= 0);
            });

            if (!pinnedIds.length) {
                pinnedSection.hidden = true;
                return;
            }

            pinnedSection.hidden = false;
            pinnedIds.forEach(function (id) {
                var action = quickActionMap[id];
                if (!action) return;
                var link = document.createElement('a');
                link.className = 'admin-spotlight__chip admin-spotlight__chip--pinned';
                link.href = action.href || '#';
                link.innerHTML =
                    '<i class="fas ' + escapeHtml(action.icon || 'fa-thumbtack') + '"></i>' +
                    '<span>' + escapeHtml(action.label || 'Azione') + '</span>' +
                    '<small>' + escapeHtml(uiText('spotlight_pinned_label', 'Pinned')) + '</small>';
                pinnedContainer.appendChild(link);
            });
        }

        function readRecentSearches() {
            try {
                var parsed = JSON.parse(localStorage.getItem(storageKey) || '[]');
                return Array.isArray(parsed) ? parsed.slice(0, 5) : [];
            } catch (error) {
                return [];
            }
        }

        function writeRecentSearch(query) {
            var trimmed = String(query || '').trim();
            if (trimmed.length < 2) return;

            var existing = readRecentSearches().filter(function (item) {
                return String(item || '').toLowerCase() !== trimmed.toLowerCase();
            });
            existing.unshift(trimmed);

            try {
                localStorage.setItem(storageKey, JSON.stringify(existing.slice(0, 5)));
            } catch (error) {
                return;
            }
        }

        function renderRecentSearches() {
            if (!recentContainer) return;

            var recents = readRecentSearches();
            recentContainer.innerHTML = '';

            if (!recents.length) {
                recentContainer.innerHTML = '<div class="admin-spotlight__recent-empty">' + escapeHtml(uiText('spotlight_recent_empty', 'Nessuna ricerca recente salvata.')) + '</div>';
                return;
            }

            recents.forEach(function (term) {
                var link = document.createElement('a');
                link.className = 'admin-spotlight__recent-item';
                link.href = '/search?q=' + encodeURIComponent(term);
                link.innerHTML =
                    '<i class="fas fa-clock-rotate-left"></i>' +
                    '<span>' + escapeHtml(term) + '</span>' +
                    '<small>' + escapeHtml(uiText('spotlight_recent_open', 'Apri ricerca completa')) + '</small>';
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    input.value = term;
                    fetchSpotlight(term);
                    input.focus();
                });
                recentContainer.appendChild(link);
            });
        }

        pinButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                togglePinnedAction(button.getAttribute('data-action-pin'));
            });
        });

        function renderItems(payload) {
            results.innerHTML = '';
            itemNodes = [];
            activeIndex = -1;

            if (!payload.items || !payload.items.length) {
                setStatus(uiText('spotlight_no_results', 'Nessun risultato rapido. Premi invio per aprire la ricerca completa.'));
                toggleEmptyState(false);
                setFooter(payload.view_all_url || '', payload.total || 0);
                return;
            }

            setStatus(uiText('spotlight_results_count', '%d risultati rapidi nel workspace').replace('%d', String(payload.total || payload.items.length)));
            toggleEmptyState(false);

            payload.items.forEach(function (item) {
                var link = document.createElement('a');
                link.className = 'admin-spotlight__item';
                link.href = item.href || '/search';
                link.innerHTML =
                    '<span class=\"admin-spotlight__icon\"><i class=\"fas ' + (item.icon || 'fa-compass') + '\"></i></span>' +
                    '<span class=\"admin-spotlight__content\">' +
                        '<span class=\"admin-spotlight__eyebrow\">' + (item.group || uiText('spotlight_group_workspace', 'Workspace')) + '</span>' +
                        '<span class=\"admin-spotlight__title\">' + (item.title || uiText('spotlight_result', 'Risultato')) + '</span>' +
                        '<span class=\"admin-spotlight__subtitle\">' + (item.subtitle || '') + '</span>' +
                        '<span class=\"admin-spotlight__meta\">' + (item.meta || '') + '</span>' +
                    '</span>';
                results.appendChild(link);
                itemNodes.push(link);
            });

            setFooter(payload.view_all_url || '', payload.total || itemNodes.length);
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function renderItemsSafe(payload) {
            var safePayload = {
                items: (payload.items || []).map(function (item) {
                    return {
                        group: escapeHtml(item.group),
                        title: escapeHtml(item.title),
                        subtitle: escapeHtml(item.subtitle),
                        meta: escapeHtml(item.meta),
                        href: item.href,
                        icon: escapeHtml(item.icon)
                    };
                }),
                total: payload.total || 0,
                view_all_url: payload.view_all_url || ''
            };
            renderItems(safePayload);
        }

        function fetchSpotlight(query) {
            requestId += 1;
            var currentRequest = requestId;

            if (query.length < 2) {
                setStatus(uiText('spotlight_type_min_chars', 'Digita almeno 2 caratteri per cercare nel workspace.'));
                results.innerHTML = '';
                toggleEmptyState(true);
                renderRecentSearches();
                setFooter('', 0);
                openPanel();
                return;
            }

            setStatus(uiText('spotlight_loading', 'Ricerca in corso...'));
            results.innerHTML = '';
            toggleEmptyState(false);
            setFooter('', 0);
            openPanel();

            fetch('/api/search/spotlight?q=' + encodeURIComponent(query), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function (response) {
                    return response.ok ? response.json() : Promise.reject(new Error('Request failed'));
                })
                .then(function (payload) {
                    if (currentRequest !== requestId) return;
                    writeRecentSearch(query);
                    renderItemsSafe(payload || {});
                })
                .catch(function () {
                    if (currentRequest !== requestId) return;
                    setStatus(uiText('spotlight_request_failed', 'Non sono riuscito a recuperare i risultati rapidi.'));
                    results.innerHTML = '';
                    toggleEmptyState(false);
                    setFooter('/search?q=' + encodeURIComponent(query), 0);
                });
        }

        input.addEventListener('focus', function () {
            openPanel();
            if (input.value.trim().length > 0) {
                fetchSpotlight(input.value.trim());
                return;
            }
            setStatus(uiText('spotlight_type_min_chars', 'Digita almeno 2 caratteri per cercare nel workspace.'));
            toggleEmptyState(true);
            renderPinnedActions();
            renderRecentSearches();
            setFooter('', 0);
        });

        input.addEventListener('input', function () {
            var query = input.value.trim();
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                fetchSpotlight(query);
            }, 180);
        });

        input.addEventListener('keydown', function (event) {
            if (panel.hidden || !itemNodes.length) {
                if (event.key === 'Escape') {
                    closePanel();
                    input.blur();
                }
                return;
            }

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                activeIndex = (activeIndex + 1) % itemNodes.length;
                updateActiveItem();
                return;
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                activeIndex = activeIndex <= 0 ? itemNodes.length - 1 : activeIndex - 1;
                updateActiveItem();
                return;
            }

            if (event.key === 'Enter' && activeIndex >= 0) {
                event.preventDefault();
                itemNodes[activeIndex].click();
                return;
            }

            if (event.key === 'Escape') {
                closePanel();
                input.blur();
            }
        });

        document.addEventListener('keydown', function (event) {
            var activeTag = document.activeElement ? document.activeElement.tagName : '';
            var isTypingTarget = /INPUT|TEXTAREA|SELECT/.test(activeTag) || (document.activeElement && document.activeElement.isContentEditable);

            if ((event.metaKey || event.ctrlKey) && String(event.key).toLowerCase() === 'k') {
                event.preventDefault();
                openPanel();
                input.focus();
                input.select();
                if (!input.value.trim()) {
                    toggleEmptyState(true);
                    renderPinnedActions();
                    renderRecentSearches();
                }
                return;
            }

            if (event.key === '/' && !event.metaKey && !event.ctrlKey && !event.altKey && !isTypingTarget) {
                event.preventDefault();
                openPanel();
                input.focus();
                if (!input.value.trim()) {
                    toggleEmptyState(true);
                    renderPinnedActions();
                    renderRecentSearches();
                }
                return;
            }
        });

        document.addEventListener('click', function (event) {
            if (!searchForm.contains(event.target)) {
                closePanel();
            }
        });

        renderPinnedActions();
    }

    function initDashboardMotion() {
        var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var revealItems = document.querySelectorAll('.dashboard-reveal');
        var hoverLiftItems = document.querySelectorAll('.dashboard-hoverlift');

        if (revealItems.length && !prefersReducedMotion && 'IntersectionObserver' in window) {
            var revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                });
            }, { threshold: 0.14 });

            revealItems.forEach(function (item, index) {
                item.style.setProperty('--reveal-delay', String(index * 40) + 'ms');
                revealObserver.observe(item);
            });
        } else {
            revealItems.forEach(function (item) {
                item.classList.add('is-visible');
            });
        }

        if (prefersReducedMotion) {
            return;
        }

        hoverLiftItems.forEach(function (item) {
            item.addEventListener('pointermove', function (event) {
                var rect = item.getBoundingClientRect();
                var x = ((event.clientX - rect.left) / rect.width) - 0.5;
                var y = ((event.clientY - rect.top) / rect.height) - 0.5;
                item.style.setProperty('--lift-rotate-x', String((-y * 4).toFixed(2)) + 'deg');
                item.style.setProperty('--lift-rotate-y', String((x * 5).toFixed(2)) + 'deg');
            });

            item.addEventListener('pointerleave', function () {
                item.style.removeProperty('--lift-rotate-x');
                item.style.removeProperty('--lift-rotate-y');
            });
        });
    }

    initDashboardMotion();
    initSpotlightSearch();
    initSidebarUX();
});
