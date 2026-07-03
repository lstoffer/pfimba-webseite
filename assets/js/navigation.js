document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('nav-toggle');
    var nav = document.getElementById('site-navigation');

    if (!toggle || !nav) {
        return;
    }

    function closeMenu() {
        nav.classList.remove('open');
        toggle.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Menü öffnen');
        document.body.classList.remove('nav-open');
    }

    function openMenu() {
        nav.classList.add('open');
        toggle.classList.add('open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Menü schliessen');
        document.body.classList.add('nav-open');
    }

    toggle.addEventListener('click', function () {
        if (nav.classList.contains('open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    nav.querySelectorAll('.submenu-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            var item = button.closest('li');
            var isOpen = item.classList.contains('sub-open');

            nav.querySelectorAll('li.sub-open').forEach(function (openItem) {
                if (openItem !== item) {
                    openItem.classList.remove('sub-open');
                    var openButton = openItem.querySelector('.submenu-toggle');
                    if (openButton) {
                        openButton.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            item.classList.toggle('sub-open', !isOpen);
            button.setAttribute('aria-expanded', String(!isOpen));
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900 && nav.classList.contains('open')) {
            closeMenu();
        }
    });
});
