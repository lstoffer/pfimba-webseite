document.addEventListener('DOMContentLoaded', function () {
    var filterBar = document.getElementById('galerie-filter');
    var grid = document.getElementById('galerie-grid');
    var emptyMessage = document.getElementById('galerie-empty');

    if (!filterBar || !grid) {
        return;
    }

    var stufeButtons = filterBar.querySelectorAll('[data-filter-stufe]');
    var items = grid.querySelectorAll('.galerie-item');

    var yearSelect = document.getElementById('galerie-filter-jahr');
    var yearTrigger = yearSelect ? yearSelect.querySelector('.galerie-select-trigger') : null;
    var yearValueLabel = yearSelect ? yearSelect.querySelector('.galerie-select-value') : null;
    var yearOptionsList = yearSelect ? yearSelect.querySelector('.galerie-select-options') : null;
    var yearOptions = yearSelect ? yearSelect.querySelectorAll('.galerie-select-option') : [];

    var activeStufe = 'all';
    var activeJahr = 'all';

    function applyFilter() {
        var visibleCount = 0;

        items.forEach(function (item) {
            var stufen = (item.getAttribute('data-stufe') || '').split(' ');
            var jahr = item.getAttribute('data-jahr') || '';

            var matchesStufe = activeStufe === 'all' || stufen.indexOf(activeStufe) !== -1;
            var matchesJahr = activeJahr === 'all' || jahr === activeJahr;
            var visible = matchesStufe && matchesJahr;

            item.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        if (emptyMessage) {
            emptyMessage.hidden = visibleCount !== 0;
        }
    }

    stufeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            stufeButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });
            button.classList.add('active');
            activeStufe = button.getAttribute('data-filter-stufe');
            applyFilter();
        });
    });

    if (yearSelect && yearTrigger && yearOptionsList) {
        function sizeYearTrigger() {
            var probe = document.createElement('span');
            var triggerStyle = getComputedStyle(yearTrigger);

            probe.style.position = 'absolute';
            probe.style.visibility = 'hidden';
            probe.style.whiteSpace = 'nowrap';
            probe.style.fontFamily = triggerStyle.fontFamily;
            probe.style.fontSize = triggerStyle.fontSize;
            probe.style.fontWeight = triggerStyle.fontWeight;
            document.body.appendChild(probe);

            var maxWidth = 0;

            yearOptions.forEach(function (option) {
                probe.textContent = option.textContent;
                maxWidth = Math.max(maxWidth, probe.getBoundingClientRect().width);
            });

            document.body.removeChild(probe);

            if (maxWidth > 0) {
                yearValueLabel.style.minWidth = Math.ceil(maxWidth) + 'px';
            }

            yearOptionsList.style.width = yearTrigger.getBoundingClientRect().width + 'px';
        }

        sizeYearTrigger();

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(sizeYearTrigger);
        }

        function openYearDropdown() {
            yearSelect.classList.add('open');
            yearOptionsList.hidden = false;
            yearTrigger.setAttribute('aria-expanded', 'true');
        }

        function closeYearDropdown() {
            yearSelect.classList.remove('open');
            yearOptionsList.hidden = true;
            yearTrigger.setAttribute('aria-expanded', 'false');
        }

        function selectYear(option) {
            yearOptions.forEach(function (opt) {
                opt.classList.remove('selected');
                opt.setAttribute('aria-selected', 'false');
            });
            option.classList.add('selected');
            option.setAttribute('aria-selected', 'true');
            yearValueLabel.textContent = option.textContent;
            activeJahr = option.getAttribute('data-value');
            applyFilter();
        }

        yearTrigger.addEventListener('click', function () {
            if (yearSelect.classList.contains('open')) {
                closeYearDropdown();
            } else {
                openYearDropdown();
            }
        });

        yearOptions.forEach(function (option) {
            option.addEventListener('click', function () {
                selectYear(option);
                closeYearDropdown();
                yearTrigger.focus();
            });
        });

        document.addEventListener('click', function (event) {
            if (!yearSelect.contains(event.target)) {
                closeYearDropdown();
            }
        });

        yearSelect.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeYearDropdown();
                yearTrigger.focus();
            }
        });
    }

    applyFilter();
});
