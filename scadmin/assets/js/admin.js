(function () {
    'use strict';

    const menuButton = document.getElementById('adminMenuButton');
    const sidebar = document.getElementById('adminSidebar');

    if (!menuButton || !sidebar) {
        return;
    }

    menuButton.addEventListener('click', function () {
        const isOpen = sidebar.classList.toggle('sidebar-open');
        menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 850) {
                sidebar.classList.remove('sidebar-open');
                menuButton.setAttribute('aria-expanded', 'false');
            }
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 850) {
            sidebar.classList.remove('sidebar-open');
            menuButton.setAttribute('aria-expanded', 'false');
        }
    });
}());
